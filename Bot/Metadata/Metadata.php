<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Bot\Metadata;

class Metadata implements MetadataInterface
{

    const AGENT_MATCH_EXACT = 'exact';
    const AGENT_MATCH_REGEXP = 'regexp';

    const TYPE_BOT = 'bot';
    const TYPE_CRAWLER = 'crawler';
    const TYPE_SPIDER = 'spider';
    const TYPE_BAD_BOT = 'bad_bot';
    const TYPE_AGENT = 'agent';

    private $name;
    private $agent;
    private $ip = null;
    private $type = array();
    private $agentMatch = self::AGENT_MATCH_REGEXP;

    /**
     * @param string $name
     * @param string $agent
     * @param null|string $ip
     * @param string $type
     * @param string $agentMatch
     */
    public function __construct($name, $agent, $ip = null, $type = self::TYPE_BOT, $agentMatch = self::AGENT_MATCH_REGEXP)
    {
        $this->name = $name;
        $this->agent = $agent;
        $this->ip = $ip;
        $this->type = $type;
        $this->agentMatch = $agentMatch;
    }

    /**
     * Returns the agent of the bot
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Returns the type of the agent check
     *
     * @return string
     */
    public function getAgentMatch()
    {
        return $this->agentMatch;
    }

    /**
     * Returns the ip of the bot
     *
     * @return null|string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Returns the type of the bot
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function match($agent, $ip)
    {
        if ((self::AGENT_MATCH_EXACT === $this->agentMatch && $this->agent !== $agent) ||
            (self::AGENT_MATCH_REGEXP === $this->agentMatch && !@preg_match('#' . $this->agent . '#', $agent))) {
            return false;
        }

        if (is_null($this->ip)) {
            return true;
        }

        return $this->ip === $ip;
    }

}
