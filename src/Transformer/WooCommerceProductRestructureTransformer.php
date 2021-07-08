<?php

namespace WebWhales\AlumioWooCommerceConnector\Transformer;

use Mediact\Condition\ConditionInterface;
use Mediact\DataContainer\DataContainerInterface;
use Mediact\DataContainer\Transformer\TransformerInterface;
use Mediact\VariableExpander\VariableExpander;
use Mediact\VariableExpander\VariableExpanderInterface;

class WooCommerceProductRestructureTransformer implements TransformerInterface
{

    /**
     * @var \Mediact\VariableExpander\VariableExpander|\Mediact\VariableExpander\VariableExpanderInterface
     */
    private $expander;

    /**
     * @var array
     */
    private $fields = [
        'name' => '',
        'regular_price' => '',
        'description' => '',
        'short_description' => '',
        'type' => '',
        'status' => '',
        'featured' => '',
        'catalog_visibility' => '',
        'sku' => '',
        'sale_price' => '',
        'virtual' => '',
        'downloadable' => '',
        'download_limit' => '',
        'download_expiry' => '',
        'external_url' => '',
        'tax_status' => '',
        'manage_stock' => '',
        'stock_quantity' => '',
        'stock_status' => '',
        'images' => '',
        'backorders' => '',
        'sold_individually' => '',
        'weight' => '',
        'purchase_note' => '',
    ];

    /**
     * WooCommerceProductRestructureTransformer constructor.
     *
     * @param array                                                    $fields
     * @param \Mediact\VariableExpander\VariableExpanderInterface|null $expander
     */
    public function __construct(
        array $fields,
        VariableExpanderInterface $expander = null
    ) {
        $this->expander                     = $expander ?? new VariableExpander();
        $this->fields['name']               = $fields['name'];
        $this->fields['regular_price']      = $fields['regular_price'];
        $this->fields['description']        = $fields['description'];
        $this->fields['short_description']  = $fields['short_description'];
        $this->fields['type']               = $fields['type'];
        $this->fields['status']             = $fields['status'];
        $this->fields['featured']           = $fields['featured'];
        $this->fields['catalog_visibility'] = $fields['catalog_visibility'];
        $this->fields['sku']                = $fields['sku'];
        $this->fields['sale_price']         = $fields['sale_price'];
        $this->fields['virtual']            = $fields['virtual'];
        $this->fields['downloadable']       = $fields['downloadable'];
        $this->fields['download_limit']     = $fields['download_limit'];
        $this->fields['download_expiry']    = $fields['download_expiry'];
        $this->fields['external_url']       = $fields['external_url'];
        $this->fields['tax_status']         = $fields['tax_status'];
        $this->fields['manage_stock']       = $fields['manage_stock'];
        $this->fields['stock_quantity']     = $fields['stock_quantity'];
        $this->fields['stock_status']       = $fields['stock_status'];
        $this->fields['images']             = $fields['images'];
        $this->fields['backorders']         = $fields['backorders'];
        $this->fields['sold_individually']  = $fields['sold_individually'];
        $this->fields['weight']             = $fields['weight'];
        $this->fields['purchase_note']      = $fields['purchase_note'];
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
            'name' => 'wooCommerceProduct.name',
            'regular_price' => 'wooCommerceProduct.regular_price',
            'description' => 'wooCommerceProduct.description',
            'short_description' => 'wooCommerceProduct.short_description',
            'type' => 'wooCommerceProduct.type',
            'status' => 'wooCommerceProduct.status',
            'featured' => 'wooCommerceProduct.featured',
            'catalog_visibility' => 'wooCommerceProduct.catalog_visibility',
            'sku' => 'wooCommerceProduct.sku',
            'sale_price' => 'wooCommerceProduct.sale_price',
            'virtual' => 'wooCommerceProduct.virtual',
            'downloadable' => 'wooCommerceProduct.downloadable',
            'download_limit' => 'wooCommerceProduct.download_limit',
            'download_expiry' => 'wooCommerceProduct.download_expiry',
            'external_url' => 'wooCommerceProduct.external_url',
            'tax_status' => 'wooCommerceProduct.tax_status',
            'manage_stock' => 'wooCommerceProduct.manage_stock',
            'stock_quantity' => 'wooCommerceProduct.stock_quantity',
            'stock_status' => 'wooCommerceProduct.stock_status',
            'images' => 'wooCommerceProduct.images',
            'backorders' => 'wooCommerceProduct.backorders',
            'sold_individually' => 'wooCommerceProduct.sold_individually',
            'weight' => 'wooCommerceProduct.weight',
            'purchase_note' => 'wooCommerceProduct.purchase_note',

            ] as $alumioProp => $wooCommerceProp
        ) {
            $value = $this->expander->__invoke($this->fields[$alumioProp] ?? '', $container->all());
            if ($value) {
                $container->set($wooCommerceProp, $value);
            }
        }

        return $container;
    }
}
