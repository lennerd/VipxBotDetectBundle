<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Vipx\BotDetectBundle\Bot\BotMetadata;

class BotToken extends AnonymousToken
{

    private $metadata;

    /**
     * Constructor.
     *
     * @param string $key   The key shared with the authentication provider
     * @param string $user  The user
     * @param Role[] $roles An array of roles
     */
    public function __construct($key, BotMetadata $metadata, array $roles = array())
    {
        if (!in_array('ROLE_BOT', $roles)) {
            $roles[] = 'ROLE_BOT';
        }

        $this->metadata = $metadata;

        parent::__construct($key, ucfirst($metadata->getType()) . ' (' . $metadata->getName() . ')' , $roles);
    }

    public static function fromAnonymousToken(BotMetadata $metadata, AnonymousToken $token)
    {
        return new self($token->getKey(), $metadata, $token->getRoles());
    }

}
