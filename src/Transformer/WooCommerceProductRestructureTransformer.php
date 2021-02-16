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
     * @var string
     */
    private $name;

    /**
     * @var \Mediact\VariableExpander\VariableExpander|\Mediact\VariableExpander\VariableExpanderInterface
     */
    private $expander;

    private $regular_price;
    private $description;
    private $short_description;
    private $type;
    private $status;
    private $featured;
    private $catalog_visibility;
    private $sku;
    private $sale_price;
    private $virtual;
    private $downloadable;
    private $download_limit;
    private $download_expiry;
    private $external_url;
    private $tax_status;
    private $manage_stock;
    private $stock_quantity;
    private $stock_status;
    private $images;
    private $backorders;
    private $sold_individually;
    private $weight;
    private $purchase_note;
    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct(
        ?string $name,
        $regular_price,
        $description,
        $short_description,
        $type,
        $status,
        $featured,
        $catalog_visibility,
        $sku,
        $sale_price,
        $virtual,
        $downloadable,
        $download_limit,
        $download_expiry,
        $external_url,
        $tax_status,
        $manage_stock,
        $stock_quantity,
        $stock_status,
        $images,
        $backorders,
        $sold_individually,
        $weight,
        $purchase_note,
        VariableExpanderInterface $expander = null
    ) {
        $this->expander = $expander ?? new VariableExpander();
        $this->name     = $name;
        $this->regular_price = $regular_price;
        $this->description = $description;
        $this->short_description = $short_description;
        $this->type = $type;
        $this->status = $status;
        $this->featured = $featured;
        $this->catalog_visibility = $catalog_visibility;
        $this->sku = $sku;
        $this->sale_price = $sale_price;
        $this->virtual = $virtual;
        $this->downloadable = $downloadable;
        $this->download_limit = $download_limit;
        $this->download_expiry = $download_expiry;
        $this->external_url = $external_url;
        $this->tax_status = $tax_status;
        $this->manage_stock = $manage_stock;
        $this->stock_quantity = $stock_quantity;
        $this->stock_status = $stock_status;
        $this->images = $images;
        $this->backorders = $backorders;
        $this->sold_individually = $sold_individually;
        $this->weight = $weight;
        $this->purchase_note = $purchase_note;
    }

    public function __invoke(DataContainerInterface $container): DataContainerInterface
    {

        foreach ([
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

        ] as $alumioProp => $wooCommerceProp) {

            $value    = $this->expander->__invoke($this->{$alumioProp}, $container->all());
            if($value){

                $container->set($wooCommerceProp, $value);
            }
        }

        return $container;
    }
}