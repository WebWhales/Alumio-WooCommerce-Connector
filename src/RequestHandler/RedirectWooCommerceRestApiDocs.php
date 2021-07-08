<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace WebWhales\AlumioWooCommerceConnector\RequestHandler;

use Alumio\Http\Message\Response\JsMessageFactoryInterface;
use Alumio\Http\Message\Response\RedirectFactoryInterface;
use League\OAuth2\Client\Provider\AbstractProvider;
use Magement\Oauth\TokenStorageInterface;
use Magement\Oauth\ProviderManagerInterface;
use Phpro\ApiProblem\Http\ExceptionApiProblem;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class RedirectWooCommerceRestApiDocs implements RequestHandlerInterface
{
    /** @var RedirectFactoryInterface */
    private $redirectFactory;

    /**
     * @var string
     */
    private $serverParam;

    /**
     * @var string[]
     */
    private static $docsUrls = [
        'products' => 'https://woocommerce.github.io/woocommerce-rest-api-docs/#create-a-product',
        'customers' => 'https://woocommerce.github.io/woocommerce-rest-api-docs/#customer-properties',
    ];

    /**
     * RedirectWooCommerceRestApiDocs constructor.
     *
     * @param \Alumio\Http\Message\Response\RedirectFactoryInterface $redirectFactory
     * @param string                                                 $serverParam
     */
    public function __construct(
        RedirectFactoryInterface $redirectFactory,
        string $serverParam
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->serverParam     = $serverParam;
    }

    /**
     * Handle a request.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //$request->get

        return $this->redirectFactory->createResponse(
            self::$docsUrls[$this->serverParam]
        );
    }
}
