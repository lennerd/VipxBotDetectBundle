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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Vipx\BotDetect\BotDetectorInterface;
use Vipx\BotDetect\Metadata\MetadataInterface;
use Vipx\BotDetectBundle\Security\BotAuthenticationListener;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Vipx\BotDetectBundle\Security\BotToken;

class BotAuthenticationListenerTest extends TestCase
{

    public function testSettingToken()
    {
        /** @var TokenStorageInterface|MockObject $tokenStorage */
        $tokenStorage = $this->getMockBuilder(TokenStorageInterface::class)->getMock();

        if (version_compare(Kernel::VERSION, '4.0', '>=')) {
            $anonymousToken = new AnonymousToken('secret', 'user', array('anon.'));
        } else {
            $anonymousToken = new AnonymousToken(null, 'anon.');
        }


        $tokenStorage->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($anonymousToken));

        $tokenStorage->expects($this->once())
            ->method('setToken')
            ->with($this->isInstanceOf(BotToken::class));

        /** @var BotDetectorInterface|MockObject $botDetector */
        $botDetector = $this->getMockBuilder(BotDetectorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $metaData = $this->getMockBuilder(MetadataInterface::class)->getMock();

        $botDetector->expects($this->once())
            ->method('detect')
            ->will($this->returnValue($metaData));

        $listener = new BotAuthenticationListener($tokenStorage, $botDetector);

        /** @var HttpKernelInterface $kernel */
        $kernel = $this->getMockBuilder(HttpKernelInterface::class)->getMock();
        $event = new GetResponseEvent($kernel, new Request(), HttpKernelInterface::MASTER_REQUEST);

        $listener->onKernelRequest($event);
    }

}
