<?php

/*
 * (c) Lennart Hildebrandt <code@lennerd.com>
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
