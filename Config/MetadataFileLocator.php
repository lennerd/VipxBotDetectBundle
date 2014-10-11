<?php

/*
 * This file is part of the VipxBotDetectBundle package.
 *
 * (c) Lennart Hildebrandt <http://github.com/lennerd>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vipx\BotDetectBundle\Config;

use Symfony\Component\HttpKernel\Config\FileLocator as FileLocator;

/**
 * This file locator locates metadata files from the vipx/bot-detect package.
 */
class MetadataFileLocator extends FileLocator
{

    /**
     * @var string
     */
    private $metadataFilePath;

    /**
     * Returns the metadata file path from the vipx/bot-detect package.
     *
     * @return string
     */
    protected function getMetadataFilePath()
    {
        if (null === $this->metadataFilePath) {
            $reflector = new \ReflectionClass('Vipx\BotDetect\BotDetector');
            $dir = dirname($reflector->getFileName());
            $this->metadataFilePath = $dir . '/Resources/metadata';
        }

        return $this->metadataFilePath;
    }

    /**
     * {@inheritdoc}
     */
    public function locate($name, $currentPath = null, $first = true)
    {
        try {
            return parent::locate($name, $currentPath, $first);
        } catch(\InvalidArgumentException $e) {
            $path = $this->getMetadataFilePath() . '/' . $name;

            if (file_exists($path)) {
                return $path;
            }

            throw new \InvalidArgumentException(sprintf('The metadata file "%s" does not exist.', $name), 0, $e);
        }

    }

}