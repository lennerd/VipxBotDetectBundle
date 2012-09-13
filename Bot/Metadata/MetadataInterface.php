<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Bot\Metadata;

interface MetadataInterface
{

    /**
     * Returns the name of the bot
     *
     * @return string
     */
    function getName();

    /**
     * Returns true if the given agent and ip matches the agent and ip of the bot
     *
     * @param string $agent
     * @param string $ip
     * @return bool
     */
    function match($agent, $ip);

}
