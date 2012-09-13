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

use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Vipx\BotDetectBundle\Bot\Metadata\Metadata;

class BotToken extends AnonymousToken
{

    private $metadata;

    /**
     * @param string $key
     * @param \Vipx\BotDetectBundle\Bot\Metadata\Metadata $metadata
     * @param array $roles
     */
    public function __construct($key, Metadata $metadata, array $roles = array())
    {
        if (!in_array('ROLE_BOT', $roles)) {
            $roles[] = 'ROLE_BOT';
        }

        $this->metadata = $metadata;

        parent::__construct($key, ucfirst($metadata->getType()) . ' (' . $metadata->getName() . ')' , $roles);
    }

    /**
     * A shortcut for creating a bot token from an anonymous token
     *
     * @param \Vipx\BotDetectBundle\Bot\Metadata\Metadata $metadata
     * @param \Symfony\Component\Security\Core\Authentication\Token\AnonymousToken $token
     * @return BotToken
     */
    public static function fromAnonymousToken(Metadata $metadata, AnonymousToken $token)
    {
        return new self($token->getKey(), $metadata, $token->getRoles());
    }

}
