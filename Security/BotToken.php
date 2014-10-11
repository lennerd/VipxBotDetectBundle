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
use Vipx\BotDetect\Metadata\MetadataInterface;

class BotToken extends AnonymousToken
{

    private $metadata;

    /**
     * @param string $key
     * @param MetadataInterface $metadata
     * @param array $roles
     */
    public function __construct($key, MetadataInterface $metadata, array $roles = array())
    {
        if (!in_array('ROLE_BOT', $roles)) {
            $roles[] = 'ROLE_BOT';
        }

        $this->metadata = $metadata;

        parent::__construct($key, ucfirst($metadata->getType()) . ' (' . $metadata->getName() . ')' , $roles);
    }

    /**
     * @return MetadataInterface
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * A shortcut for creating a bot token from an anonymous token
     *
     * @param MetadataInterface $metadata
     * @param AnonymousToken $token
     * @return BotToken
     */
    public static function fromAnonymousToken(MetadataInterface $metadata, AnonymousToken $token)
    {
        return new self($token->getKey(), $metadata, $token->getRoles());
    }

}
