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
     * @var string
     */
    private $name;

    /**
     * @var \Mediact\VariableExpander\VariableExpander|\Mediact\VariableExpander\VariableExpanderInterface
     */
    private $expander;

    private $email;

    private $first_name;

    private $last_name;

    private $username;

    private $password;

    private $billing;

    private $shipping;

    private $meta_data;

    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct(
        string $email = null,
        $first_name = null,
        $last_name = null,
        $username = null,
        $password = null,
        $billing = null,
        $shipping = null,
        $meta_data = null,

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

    public function __invoke(DataContainerInterface $container): DataContainerInterface
    {
      //  $value = $this->expander->__invoke($this->shipping, $container->all());
      //  $container->set('wooCommerceCustomer.shipping33',$this->shipping);
    //    foreach ($this->shipping[0] as $key => $value){
    //        $container->set('wooCommerceCustomer.shipping',$this->expander->__invoke($value, $container->all()));
    //        $container->set('wooCommerceCustomer.shipping1',$key);
    //
    //    }
        //   return $container;

        foreach ([
            'email'      => 'wooCommerceCustomer.email',
            'first_name' => 'wooCommerceCustomer.first_name',
            'last_name'  => 'wooCommerceCustomer.last_name',
            'username'   => 'wooCommerceCustomer.username',
            'password'   => 'wooCommerceCustomer.password',
            'billing'    => 'wooCommerceCustomer.billing',
            'shipping'   => 'wooCommerceCustomer.shipping',
            'meta_data'  => 'wooCommerceCustomer.meta_data',

        ] as $alumioProp => $wooCommerceProp) {

            $value = $this->expander->__invoke($this->{$alumioProp}, $container->all());
            if ($value) {

                $container->set($wooCommerceProp, $value);
            }
        }

        return $container;
    }
}