<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Bot\Metadata\Dumper;

abstract class MetadataDumper implements MetadataDumperInterface
{

    private $metadatas = array();

    /**
     * @param \Vipx\BotDetectBundle\Bot\Metadata\Metadata[] $metadatas
     */
    public function __construct(array $metadatas)
    {
        $this->metadatas = $metadatas;
    }

    /**
     * Returns all bot metadatas
     *
     * @return \Vipx\BotDetectBundle\Bot\Metadata\Metadata[]
     */
    public function getMetadatas()
    {
        return $this->metadatas;
    }

}
