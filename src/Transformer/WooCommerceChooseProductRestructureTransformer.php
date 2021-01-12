<?php

namespace WebWhales\AlumioWooCommerceConnector\Transformer;

use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Transformer\TransformerInterface;

class WooCommerceChooseProductRestructureTransformer implements TransformerInterface
{

    private $parent_id;
    private $product_id;

    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct(
        string $parent_id,
        $product_id
    ) {
        $this->parent_id     = $parent_id;
        $this->product_id = $product_id;
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
        $product_id = $this->parent_id != 0 ? $this->parent_id : $this->product_id ;
        $variation_id = $this->parent_id != 0 ? $this->product_id :  $this->parent_id;

        $container->copy($product_id, 'product_id');
        $container->copy($variation_id, 'variation_id');
        $container->copy(true, 'manage_stock');



        $container->remove('sku');
        return $container;
    }
}