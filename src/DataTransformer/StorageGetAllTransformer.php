<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace WebWhales\AlumioWooCommerceConnector\DataTransformer;

use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Transformer\TransformerInterface;
use Mediact\Storage\StorageInterface;

class StorageGetAllTransformer implements TransformerInterface
{
    /** @var StorageInterface */
    private $storage;

    /** @var string */
    private $destinationPath;


    /**
     * Constructor.
     *
     * @param StorageInterface $storage
     * @param string           $destinationPath
     */
    public function __construct(
        StorageInterface $storage,
        string $destinationPath
    ) {
        $this->storage         = $storage;
        $this->destinationPath = $destinationPath;
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

        $container->set(
            $this->destinationPath,
            $this->storage
        );

        return $container;
    }
}
