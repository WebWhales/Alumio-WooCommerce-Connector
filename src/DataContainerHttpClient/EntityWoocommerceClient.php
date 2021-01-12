<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace WebWhales\AlumioWooCommerceConnector\DataContainerHttpClient;

use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\HttpClient\ClientInterface;
use Mediact\DataContainer\HttpClient\EntityClientInterface;
use Mediact\DataContainer\HttpClient\ResponseInterface;
use Mediact\VariableExpander\PlaceHolderFinder;
use Mediact\VariableExpander\StringExpander;
use Mediact\VariableExpander\VariableExpander;
use Mediact\VariableExpander\VariableExpanderInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\UriFactoryInterface;

class EntityWoocommerceClient implements EntityClientInterface
{
    /** @var string */
    private $uri;

    /** @var mixed */
    private $payload;

    /** @var ClientInterface */
    private $client;

    /** @var VariableExpanderInterface */
    private $expander;

    /** @var UriFactoryInterface */
    private $uriFactory;

    private $extra_object_id;

    private $extra_object_name;

    /**
     * Constructor.
     *
     * @param ClientInterface                $client
     * @param mixed                          $payload
     * @param string|null                    $object_id
     * @param string|null                    $extra_object_id
     * @param string|null                    $object_name
     * @param string|null                    $extra_object_name
     * @param VariableExpanderInterface|null $expander
     * @param UriFactoryInterface|null       $uriFactory
     */
    public function __construct(

        ClientInterface $client,
        $payload = [],
        $object_id = null,
        $extra_object_id = null,
        $object_name = null,
        $extra_object_name = null,
        VariableExpanderInterface $expander = null,
        UriFactoryInterface $uriFactory = null
    ) {

        $this->extra_object_id = $extra_object_id;

        $this->uri                  = "/{$object_name}/{$object_id}";
        $this->extra_object_name = $extra_object_name;

        $this->client  = $client;
        $this->payload = $payload;

        $this->expander   = new VariableExpander(
            new StringExpander(null, new PlaceHolderFinder('&{'), 1)
        );
        $this->uriFactory = $uriFactory ?? new Psr17Factory();
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

        $data = $entity->all();

        $this->uri          = (string) $this->expander->__invoke($this->uri, $data);
        $extra_object_id = (string) $this->expander->__invoke($this->extra_object_id, $data);

        // ToDo: Add something to distinguish the difference between creating a sub object
        //  (where we should include the "extra_object_name") and updating the main object
        if ($extra_object_id) {
            $this->uri .= "/{$this->extra_object_name}/{$extra_object_id}";
        }

        $payload = (array) $this->expander->__invoke($this->payload, $data);

        return $this->client->put(
            $this->uri,
            new DataContainer($payload)
        );
    }
}
