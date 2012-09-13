<?php

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
