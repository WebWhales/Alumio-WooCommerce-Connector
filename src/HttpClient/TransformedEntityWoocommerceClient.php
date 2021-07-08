<?php

declare(strict_types=1);

namespace WebWhales\AlumioWooCommerceConnector\HttpClient;

use Magement\Entity\Entity;
use Magement\Entity\EntityIterator;
use Magement\Entity\Transformer\ListTransformerInterface;
use Magement\HttpClient\TransformedEntityClient;
use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\HttpClient\EntityClientInterface;
use Mediact\DataContainer\HttpClient\Response;
use Mediact\DataContainer\HttpClient\ResponseInterface;

class TransformedEntityWoocommerceClient extends TransformedEntityClient
{
    /** @var EntityClientInterface */
    private $client;

    /** @var ListTransformerInterface */
    private $transformer;

    /**
     * Constructor.
     *
     * @param EntityClientInterface    $client
     * @param ListTransformerInterface $transformer
     */
    public function __construct(
        EntityClientInterface $client,
        ListTransformerInterface $transformer
    ) {
        $this->client      = $client;
        $this->transformer = $transformer;
    }

    /**
     * Execute a request based on data.
     *
     * @param DataContainerInterface $entity
     *
     * @return ResponseInterface
     */
    public function __invoke(DataContainerInterface $entity): ResponseInterface
    {
        $responses = [];
        foreach (
            $this
                ->transformer
                ->__invoke(
                    new EntityIterator(
                        new Entity('woocommerce', $entity->all())
                    )
                ) as $requestEntity
        ) {
            $response = $this->client->__invoke(
                new DataContainer($requestEntity->all())
            );

            $responses[] = $response->getDataContainer()->all();
        }

        return (new Response())->withDataContainer(new DataContainer($responses));
    }
}
