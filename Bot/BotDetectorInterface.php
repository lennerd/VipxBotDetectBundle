<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Bot;

use Symfony\Component\HttpFoundation\Request;

interface BotDetectorInterface
{

    /**
     * Tries to detect if the given request is made by a bot
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return null|\Vipx\BotDetectBundle\Bot\Metadata\Metadata
     */
    function detect(Request $request);

}
