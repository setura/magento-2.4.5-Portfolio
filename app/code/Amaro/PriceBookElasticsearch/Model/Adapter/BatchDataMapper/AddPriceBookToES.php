<?php

declare(strict_types=1);

namespace Amaro\PriceBookElasticsearch\Model\Adapter\BatchDataMapper;

use Magento\AdvancedSearch\Model\Adapter\DataMapper\AdditionalFieldsProviderInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Amaro\PriceBookCatalog\Model\ResourceModel\PriceBook as PriceBookResource;

/**
 * Provide data mapping for pricebook field
 */
class AddPriceBookToES implements AdditionalFieldsProviderInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    /**
     * @var PriceBookResource
     */
    private PriceBookResource $priceBookResource;

    /**
     * Dependency injection
     *
     * @param ProductRepositoryInterface $productRepository
     * @param PriceBookResource $priceBookResource
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        PriceBookResource $priceBookResource
    ) {
        $this->productRepository = $productRepository;
        $this->priceBookResource = $priceBookResource;
    }

    /**
     * @inheritdoc
     */
    public function getFields(array $productIds, $storeId)
    {
        $fields = [];
        foreach ($productIds as $productId) {
            $productPriceBook = $this->priceBookResource->getPriceBookByProductId($productId);
            $fields[$productId] = ["pricebook" => $productPriceBook];
        }

        return $fields;
    }
}
