<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Magement\Storage\DataTransformer;

use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Transformer\TransformerInterface;
use Mediact\Storage\StorageInterface;

class StorageAddTransformer implements TransformerInterface
{
    /** @var StorageInterface */
    private $storage;

    /** @var string */
    private $sourcePath;

    /** @var string */
    private $storagePath;

    /**
     * Constructor.
     *
     * @param StorageInterface $storage
     * @param string           $sourcePath
     * @param string           $storagePath
     */
    public function __construct(
        StorageInterface $storage,
        string $sourcePath,
        string $storagePath
    ) {
        $this->storage     = $storage;
        $this->sourcePath  = $sourcePath;
        $this->storagePath = $storagePath;
    }

    /**
     * Transform a data container.
     *
     * @param DataContainerInterface $container
     *
     * @return DataContainerInterface
     */
    public function __invoke(
        DataContainerInterface $container
    ): DataContainerInterface {
        $storageContainer = new DataContainer($this->storage->get('value') ?? []);
        $key = array_key_last($storageContainer->all()) >= 0 ? array_key_last($storageContainer->all())+1:0;
        $storageContainer->set(
            $key,
            $container->get($this->sourcePath)
        );
        $container->set('test',array_keys($storageContainer->all()));
        $this->storage->set('value', $storageContainer->all());


        return $container;
        $storageContainer->set(
            $this->storagePath,
            $container->get($this->sourcePath)
        );

        $this->storage->set('value', $storageContainer->all());

        return $container;
    }
}
