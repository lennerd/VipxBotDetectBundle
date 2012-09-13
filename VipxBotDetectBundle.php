<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Vipx\BotDetectBundle\DependencyInjection\Compiler\MetadataResolverPass;

class VipxBotDetectBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MetadataResolverPass());
    }

}
