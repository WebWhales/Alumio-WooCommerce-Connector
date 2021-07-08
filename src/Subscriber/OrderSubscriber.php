<?php

/**
 * Copyright Alumio. All rights reserved.
 * https://www.alumio.com
 */

namespace WebWhales\AlumioWooCommerceConnector\Subscriber;

use Magement\Subscriber\SubscriberInterface;
use Magement\Subscriber\SubscriberOutputInterface;

class OrderSubscriber implements SubscriberInterface
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string[] */
    private $address;

    /**
     * Constructor
     * @param string   $firstName
     * @param string   $lastName
     * @param string[] $address
     */
    public function __construct(
        string $firstName,
        string $lastName,
        array $address
    ) {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->address   = $address;
    }

    /**
     * Execute the subscriber.
     *
     * @param SubscriberOutputInterface $output
     *
     * @return void
     */
    public function __invoke(SubscriberOutputInterface $output): void
    {
        $output->write(
            [
                'firstname' => $this->firstName,
                'lastname' => $this->lastName,
                'address' => $this->address,
            ]
        );
    }
}
