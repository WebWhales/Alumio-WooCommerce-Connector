<?php

namespace WebWhales\AlumioWooCommerceConnector\Transformer;

use Mediact\Condition\ConditionInterface;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Transformer\TransformerInterface;
use Mediact\VariableExpander\VariableExpander;
use Mediact\VariableExpander\VariableExpanderInterface;

class WooCommerceCustomerRestructureTransformer implements TransformerInterface
{
    /**
     * @var \Mediact\VariableExpander\VariableExpander|\Mediact\VariableExpander\VariableExpanderInterface
     */
    private $expander;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $first_name;

    /**
     * @var string|null
     */
    private $last_name;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var array|null
     */
    private $billing;

    /**
     * @var array|null
     */
    private $shipping;
    /**
     * @var array|null
     */
    private $meta_data;

    /**
     * WooCommerceCustomerRestructureTransformer constructor.
     *
     * @param string|null                                              $email
     * @param string|null                                              $first_name
     * @param string|null                                              $last_name
     * @param string|null                                              $username
     * @param string|null                                              $password
     * @param array|null                                               $billing
     * @param array|null                                               $shipping
     * @param array|null                                               $meta_data
     * @param \Mediact\VariableExpander\VariableExpanderInterface|null $expander
     */
    public function __construct(
        string $email = null,
        string $first_name = null,
        string $last_name = null,
        string $username = null,
        string $password = null,
        array $billing = null,
        array $shipping = null,
        array $meta_data = null,
        VariableExpanderInterface $expander = null
    ) {
        $this->email      = $email;
        $this->first_name = $first_name;
        $this->last_name  = $last_name;
        $this->username   = $username;
        $this->password   = $password;
        $this->billing    = $billing;
        $this->shipping   = $shipping;
        $this->meta_data  = $meta_data;
        $this->expander   = $expander ?? new VariableExpander();
    }

    /**
     * @param \Mediact\DataContainer\DataContainerInterface $container
     *
     * @return \Mediact\DataContainer\DataContainerInterface
     */
    public function __invoke(DataContainerInterface $container): \Mediact\DataContainer\DataContainerInterface
    {
        foreach (
            [
            'email'      => 'wooCommerceCustomer.email',
            'first_name' => 'wooCommerceCustomer.first_name',
            'last_name'  => 'wooCommerceCustomer.last_name',
            'username'   => 'wooCommerceCustomer.username',
            'password'   => 'wooCommerceCustomer.password',
            'billing'    => 'wooCommerceCustomer.billing',
            'shipping'   => 'wooCommerceCustomer.shipping',
            'meta_data'  => 'wooCommerceCustomer.meta_data',

            ] as $alumioProp => $wooCommerceProp
        ) {
            $value = $this->expander->__invoke($this->{$alumioProp}, $container->all());
            if ($value) {
                $container->set($wooCommerceProp, $value);
            }
        }

        return $container;
    }
}
