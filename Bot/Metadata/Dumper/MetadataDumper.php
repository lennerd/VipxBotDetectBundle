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

abstract class MetadataDumper implements MetadataDumperInterface
{

    private $metadatas = array();

    public function __construct(array $metadatas)
    {
        $this->metadatas = $metadatas;
    }

    /**
     * @return \Vipx\BotDetectBundle\Bot\Metadata\Metadata[]
     */
    public function getMetadatas()
    {
        return $this->metadatas;
    }

}
