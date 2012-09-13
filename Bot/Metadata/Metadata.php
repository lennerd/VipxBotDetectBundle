<?php

/*
 * This file is part of the FOSUserBundle package.
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

    private $name;
    private $agent;
    private $ip = null;
    private $type = array();
    private $agentMatch = self::AGENT_MATCH_REGEXP;

    public function __construct($name, $agent, $ip = null, $type = self::TYPE_BOT, $agentMatch = self::AGENT_MATCH_REGEXP)
    {
        $this->name = $name;
        $this->agent = $agent;
        $this->ip = $ip;
        $this->type = $type;
        $this->agentMatch = $agentMatch;
    }

    public function getAgent()
    {
        return $this->agent;
    }

    public function getAgentMatch()
    {
        return $this->agentMatch;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

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
