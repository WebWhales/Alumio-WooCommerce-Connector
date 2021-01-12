<?php
/**
 * Copyright Alumio. All rights reserved.
 * https://www.alumio.com
 */

namespace WebWhales\AlumioWooCommerceConnector\Publisher;

use Magement\Publisher\PublisherInterface;
use Magement\Publisher\PublisherInputInterface;
use Magement\Storage\StorageInterface;
use Magement\Entity\IdentifierResolver\EntityIdentityResolverInterface;
use Magement\Entity\Entity;

class ProductPublisher implements PublisherInterface
{
    /** @var StorageInterface */
    private $storage;

    /** @var EntityIdentityResolverInterface */
    private $entityIdentityResolver;

    /** @var string */
    private $entityType;

    /**
     * Constructor
     *
     * @param StorageInterface                $storage
     * @param EntityIdentityResolverInterface $entityIdentityResolver
     * @param string                          $entityType
     */
    public function __construct(
        StorageInterface $storage,
        EntityIdentityResolverInterface $entityIdentityResolver,
        string $entityType
    ) {
        $this->storage = $storage;
        $this->entityIdentityResolver = $entityIdentityResolver;
        $this->entityType = $entityType;
    }

    /**
     * Publish an entity.
     *
     * @param array $entity
     *
     * @return void
     */
    public function __invoke(array $entity): void
    {
        $this->storage->set(
            $this->resolver->resolve(
                new Entity(
                    $this->entityType,
                    $entity
                )
            ),
            $entity
        );
    }
}