<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Bot\Metadata;

interface MetadataInterface
{

    function getName();

    function match($agent, $ip);

}
