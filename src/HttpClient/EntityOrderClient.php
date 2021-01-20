<?php

declare(strict_types=1);


namespace WebWhales\AlumioWooCommerceConnector\HttpClient;


use Mediact\DataContainer\DataContainer;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\HttpClient\ClientInterface;
use Mediact\DataContainer\HttpClient\InvalidMethodException;
use Mediact\VariableExpander\VariableExpander;
use Mediact\VariableExpander\VariableExpanderInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\UriFactoryInterface;
use Mediact\DataContainer\HttpClient\ResponseInterface;
use Mediact\DataContainer\HttpClient\EntityClientInterface;

class EntityOrderClient implements EntityClientInterface
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

    /**
     * Constructor.
     *
     * @param ClientInterface                $client
     * @param int                            $days
     * @param mixed                          $payload
     * @param VariableExpanderInterface|null $expander
     * @param UriFactoryInterface|null       $uriFactory
     */
    public function __construct(
        int $days = 30,
        int $limit = null,

        ClientInterface $client,
        $payload = [],
        VariableExpanderInterface $expander = null,
        UriFactoryInterface $uriFactory = null
    ) {

        $date = \Illuminate\Support\Carbon::now();
        $after = $date->subDays($days)->format('Y-m-d\TH:i:s');
        $parameters= "after=".$after;
        if($limit){
            $parameters .= "&per_page=".$limit;
        }

        $this->uri        = "/orders?".$parameters;
        $this->client     = $client;
        $this->payload    = $payload;
        $this->expander   = $expander ?? new VariableExpander();
        $this->uriFactory = $uriFactory ?? new Psr17Factory();
    }

    /**
     * Execute a request based on data.
     *
     * @param DataContainerInterface $entity
     *
     * @return ResponseInterface
     * @throws InvalidMethodException When the method is not callable.
     */
    public function __invoke(DataContainerInterface $entity): ResponseInterface
    {
        $data    = $entity->all();
        $uri     = (string) $this->expander->__invoke($this->uri, $data);
        $payload = (array) $this->expander->__invoke($this->payload, $data);

        return $this->client->get(
            $this->appendQuery($uri, $payload)
        );

        throw new InvalidMethodException($method);
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



