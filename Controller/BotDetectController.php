<?php

namespace Vipx\BotDetectBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Test controller.
 */
class BotDetectController extends Controller
{
    /**
     * Utility action to manually test user agents.
     *
     * @param Request $request
     *
     * @Route("/testBotDetect", name="test_bot_detect")
     * @Template("VipxBotDetectBundle::testBotDetect.html.twig")
     *
     * @return array
     */
    public function testBotDetectAction(Request $request)
    {
        $userAgent = $request->get('user-agent');
        $request->server->set('HTTP_USER_AGENT', $userAgent);

        return [
            'user_agent' => $userAgent,
            'bot' => $this->get('vipx_bot_detect.detector')->detectFromRequest($request)
        ];
    }
}