<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Bot\Metadata\Dumper;

class PhpMetadataDumper extends MetadataDumper
{

    public function dump()
    {
        return <<<EOF
<?php

/**
 * This file has been auto-generated
 * by the VipxBotDetectBundle.
 */
return array(
    {$this->dumpMetadatas()}
);
EOF;
    }

    private function dumpMetadatas()
    {
        $metadatas = $this->getMetadatas();
        $dump = '';

        foreach ($metadatas as $name => $metadata) {
            /* $ip = null, $type = self::TYPE_BOT, $agentMatch = self::AGENT_MATCH_REGEXP */
            $dump .= sprintf("    '%s' => new %s('%s', '%s', %s, '%s', '%s'),\n",
                $name,
                get_class($metadata),
                $name,
                $metadata->getAgent(),
                var_export($metadata->getIp(), true),
                $metadata->getType(),
                $metadata->getAgentMatch());
        }

        return $dump;
    }

}
