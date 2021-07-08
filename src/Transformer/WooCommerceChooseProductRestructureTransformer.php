<?php

namespace WebWhales\AlumioWooCommerceConnector\Transformer;

use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Transformer\TransformerInterface;

class WooCommerceChooseProductRestructureTransformer implements TransformerInterface
{
    /**
     * @var string
     */
    private $parent_id;

    /**
     * @var string
     */
    private $product_id;

    /**
     * WooCommerceChooseProductRestructureTransformer constructor.
     *
     * @param string $parent_id
     * @param string $product_id
     */
    public function __construct(
        string $parent_id,
        string $product_id
    ) {
        $this->parent_id  = $parent_id;
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
        $product_id   = $this->parent_id != 0 ? $this->parent_id : $this->product_id ;
        $variation_id = $this->parent_id != 0 ? $this->product_id :  $this->parent_id;

        $container->copy($product_id, 'product_id');
        $container->copy($variation_id, 'variation_id');
        $container->copy(true, 'manage_stock');



        $container->remove('sku');
        return $container;
    }
}
