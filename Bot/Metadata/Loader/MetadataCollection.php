<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Bot\Metadata\Loader;

use Symfony\Component\Config\Resource\ResourceInterface;
use Vipx\BotDetectBundle\Bot\Metadata\MetadataInterface;

class MetadataCollection
{

    private $resources = array();
    private $metadatas = array();

    public function addResource(ResourceInterface $resource)
    {
        $this->resources[] = $resource;
    }

    public function addMetadata(MetadataInterface $metadata)
    {
        $this->metadatas[$metadata->getName()] = $metadata;
    }

    public function getResources()
    {
        return $this->resources;
    }

    public function getMetadatas()
    {
        return $this->metadatas;
    }

}
