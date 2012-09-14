<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Tests\Bot;

use Vipx\BotDetectBundle\Bot\BotDetector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Vipx\BotDetectBundle\Bot\Metadata\Loader\YamlFileLoader;

class BotDetectorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSettingOptions()
    {
        $detector = $this->getDetector();

        $detector->setOptions(array(
            'invalid_options' => 'value'
        ));
    }

    public function testDetection()
    {
        $detector = $this->getDetector();

        $request = new Request();
        $request->server->set('HTTP_USER_AGENT', 'Googlebot');

        $this->assertEquals($detector->detect($request)->getName(), 'Google');

        $request = new Request();
        $request->server->set('HTTP_USER_AGENT', ' ');
        $request->server->set('REMOTE_ADDR', '212.227.101.211');

        $this->assertEquals($detector->detect($request)->getName(), 'vectra-mods');
    }

    private function getDetector()
    {
        $locator = new FileLocator();
        $loader = new YamlFileLoader($locator);
        $metadataFile = __DIR__ . '/../../Resources/metadata/extended.yml';

        return new BotDetector($loader, $metadataFile);
    }

}
