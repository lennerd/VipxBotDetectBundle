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
use Vipx\BotDetectBundle\Security\BotToken;

class BotTokenTest extends TestCase
{

    public function testBotRole()
    {
        $metadata = $this->getMockBuilder('Vipx\BotDetect\Metadata\MetadataInterface')->getMock();
        $token = new BotToken('test', $metadata);
        $roles = $token->getRoles();

        $contains = false;

        foreach ($roles as $role) {
            if ('ROLE_BOT' === $role->getRole()) {
                $contains = true;
            }
        }

        $this->assertTrue($contains, 'The BotToken has no role "ROLE_BOT"');
    }

    public function testCanCreateBotTokenFromAnonymousToken()
    {
        $metadata = $this->getMockBuilder('Vipx\BotDetect\Metadata\MetadataInterface')->getMock();

        $anonymousToken = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\AnonymousToken')
            ->disableOriginalConstructor()
            ->getMock();

        $anonymousToken->method('getSecret')->willReturn('theSecretKey');
        $anonymousToken->method('getRoles')->willReturn([]);

        $botToken = BotToken::fromAnonymousToken($metadata, $anonymousToken);

        $this->assertInstanceOf(BotToken::class, $botToken);
        $this->assertSame($botToken->getSecret(), $anonymousToken->getSecret());
    }

}
