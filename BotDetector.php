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

use Symfony\Component\HttpFoundation\Request;
use Vipx\BotDetect\BotDetector as BaseBotDetector;

class BotDetector extends BaseBotDetector
{

    /**
     * {@inheritdoc}
     */
    public function detectFromRequest(Request $request)
    {
        $agent = $request->server->get('HTTP_USER_AGENT');
        $ip = $request->getClientIp();

        return $this->detect($agent, $ip);
    }

}
