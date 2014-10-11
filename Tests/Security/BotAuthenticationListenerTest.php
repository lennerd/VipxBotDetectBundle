<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Tests\Security;

use Vipx\BotDetectBundle\Security\BotAuthenticationListener;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class BotAuthenticationListenerTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingToken()
    {
        $securityContext = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');
        $anonymousToken = new AnonymousToken(null, 'anon.');

        $securityContext->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($anonymousToken));

        $securityContext->expects($this->any())
            ->method('setToken')
            ->with($this->isInstanceOf('Vipx\BotDetectBundle\Security\BotToken'));

        $botDetector = $this->getMock('Vipx\BotDetect\BotDetectorInterface');
        $metaData = $this->getMock('Vipx\BotDetect\Metadata\MetadataInterface');

        $botDetector->expects($this->any())
            ->method('detectFromRequest')
            ->will($this->returnValue($metaData));

        $listener = new BotAuthenticationListener($securityContext, $botDetector);

        $kernel = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
        $event = new GetResponseEvent($kernel, new Request(), HttpKernelInterface::MASTER_REQUEST);

        $listener->onKernelRequest($event);
    }

}
