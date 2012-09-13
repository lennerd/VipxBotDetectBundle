<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Security;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Vipx\BotDetectBundle\Bot\BotDetector;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * A kernel.request listener, which automatically authenticate visiting bots.
 */
class BotAuthenticationListener
{

    private $context;
    private $detector;

    /**
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $context
     * @param \Vipx\BotDetectBundle\Bot\BotDetector $detector
     */
    public function __construct(SecurityContextInterface $context, BotDetector $detector)
    {
        $this->context = $context;
        $this->detector = $detector;
    }

    /**
     * Listens to the kernel.request events and sets a bot token if the visitor is a spider or crawler
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $token = $this->context->getToken();
        $request = $event->getRequest();

        if ($token instanceof AnonymousToken && null !== $metaData = $this->detector->detect($request)) {
            $this->context->setToken(BotToken::fromAnonymousToken($metaData, $token));
        }
    }

}
