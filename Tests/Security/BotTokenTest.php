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

use Vipx\BotDetectBundle\Security\BotToken;

class BotTokenTest extends \PHPUnit_Framework_TestCase
{

    public function testBotRole()
    {
        $metadata = $this->getMock('Vipx\BotDetect\Metadata\MetadataInterface');
        $token = new BotToken('test', $metadata);
        $roles = $token->getRoles();

        $contains = false;

        foreach ($roles as $role) {
            if ('ROLE_BOT' === $role->getRole()) {
                $contains = true;
            }
        }

        if (!$contains) {
            $this->fail('The BotToken has no role "ROLE_BOT"');
        }
    }

}
