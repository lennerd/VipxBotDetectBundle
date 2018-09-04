<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Vipx\BotDetectBundle\DependencyInjection\Compiler\MetadataResolverPass;
use Vipx\BotDetectBundle\VipxBotDetectBundle;

class VipxBotDetectBundleTest extends TestCase
{
    public function testContainerHasCompilerPass()
    {
        $bundle = new VipxBotDetectBundle();
        $container = new ContainerBuilder();

        $bundle->build($container);
        $passes = $container->getCompiler()->getPassConfig()->getBeforeOptimizationPasses();

        $passAdded = false;
        foreach ($passes as $pass) {
            if ($pass instanceof MetadataResolverPass) {
                $passAdded = true;
            }
        }

        $this->assertTrue($passAdded, 'Resolver pass has not been added.');
    }
}