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


    /** @var string|null */
    private $extra_object_id;

    /** @var string|null */
    private $extra_object_name;

    /** @var array */
    private $header;

    /** @var string|null */
    private $method;


    /**
     * Constructor.
     *
     * @param ClientInterface          $client
     * @param mixed                    $payload
     * @param string|null              $object_id
     * @param array|null               $extra_object
     * @param string|null              $object_name
     * @param string|null              $url
     * @param array                    $header
     * @param string|null              $method
     * @param UriFactoryInterface|null $uriFactory
     */
    public function __construct(
        ClientInterface $client,
        $payload = [],
        ?string $object_id = null,
        ?array $extra_object = null,
        ?string $object_name = null,
        ?string $url = null,
        array $header = [],
        ?string $method = null,
        UriFactoryInterface $uriFactory = null
    ) {

        $this->extra_object_id = $extra_object["extra_object_id"];
        $this->uri             = "";
        if ($method) {
            $this->method = $method;
        }

        if ($url) {
            $this->uri .= "{$url}";
        }

        $this->uri .= "/{$object_name}";

        if ($object_id) {
            $this->uri .= "/{$object_id}";
        }

        $this->extra_object_name = $extra_object["extra_object_name"];

        $this->client  = $client;
        $this->payload = $payload;

        $this->expander   = new VariableExpander(
            new StringExpander(null, new PlaceHolderFinder('&{'), 1)
        );
        $this->uriFactory = $uriFactory ?? new Psr17Factory();

        $this->header = $header;
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

        $uri             = (string) $this->expander->__invoke($this->uri, $data);
        $extra_object_id = (string) $this->expander->__invoke($this->extra_object_id, $data);

        // ToDo: Add something to distinguish the difference between creating a sub object
        //  (where we should include the "extra_object_name") and updating the main object
        if ($extra_object_id) {
            $uri .= "/{$this->extra_object_name}/{$extra_object_id}";
        }

        $payload = (array) $this->expander->__invoke($this->payload, $data);
        $header  = [];
        foreach ($this->header as $value) {
            $header[$value["key"]] = (string) $this->expander->__invoke($value["value"], $data);
        }

        if ($this->method) {
            $method  = (string) $this->expander->__invoke($this->method, $data);
            $uri     = (string) $this->expander->__invoke($uri, $data);
            $payload = (array) $this->expander->__invoke($this->payload, $data);

            switch ($method) {
                case 'get':
                    return $this->client->get(
                        $this->appendQuery($uri, $payload),
                        $header
                    );
                case 'post':
                case 'put':
                case 'patch':
                case 'delete':
                    return $this->client->$method(
                        $uri,
                        new DataContainer($payload)
                    );
            }
        }

        return $this->client->put(
            $uri,
            new DataContainer($payload),
            $header
        );
    }

    /**
     * Append a query to an URI.
     *
     * @param string $uri
     * @param array  ...$additional
     *
     * @return string
     */
    private function appendQuery(string $uri, array ...$additional): string
    {
        $uri = $this->uriFactory->createUri($uri);

        parse_str($uri->getQuery(), $existingQuery);
        return $uri->withQuery(
            http_build_query(
                array_merge($existingQuery, ...$additional)
            )
        )->__toString();
    }
}
