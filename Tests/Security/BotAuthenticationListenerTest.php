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

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Vipx\BotDetectBundle\Security\BotAuthenticationListener;

class BotAuthenticationListenerTest extends TestCase
{

    public function testSettingToken()
    {
        $tokenStorage = $this->getMockBuilder(
            'Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface'
        )->getMock();
        $anonymousToken = new AnonymousToken(null, 'anon.');

        $tokenStorage->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue($anonymousToken));

        $tokenStorage->expects($this->once())
            ->method('setToken')
            ->with($this->isInstanceOf('Vipx\BotDetectBundle\Security\BotToken'));

        $botDetector = $this->getMockBuilder('Vipx\BotDetect\BotDetectorInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $metaData = $this->getMockBuilder('Vipx\BotDetect\Metadata\MetadataInterface')->getMock();

        $botDetector->expects($this->once())
            ->method('detect')
            ->will($this->returnValue($metaData));

        $listener = new BotAuthenticationListener($tokenStorage, $botDetector);

        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $event = new GetResponseEvent($kernel, new Request(), HttpKernelInterface::MASTER_REQUEST);

        $listener->onKernelRequest($event);
    }

}
