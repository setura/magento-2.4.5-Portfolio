<?php

declare(strict_types=1);

namespace Amaro\PriceBookCatalog\Plugin\Magento\Catalog\Api;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Amaro\PriceBook\Api\Data\PriceBookInterface;
use Amaro\PriceBook\Api\PriceBookRepositoryInterface;

/**
 * ProductRepositoryInterfacePlugin class
 */
class ProductRepositoryInterfacePlugin
{
    /**
     * @var PriceBookRepositoryInterface
     */
    private PriceBookRepositoryInterface $priceBookRepository;

    /**
     * Inject dependencies
     *
     * @param PriceBookRepositoryInterface $priceBookRepository
     */
    public function __construct(PriceBookRepositoryInterface $priceBookRepository)
    {
        $this->priceBookRepository = $priceBookRepository;
    }

    /**
     * Inject the extension attributes after getting a product
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductSearchResultsInterface $result
     * @return ProductSearchResultsInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetList(
        ProductRepositoryInterface    $subject,
        ProductSearchResultsInterface $result
    ): ProductSearchResultsInterface {
        foreach ($result as $item) {
            $this->afterGet($subject, $item);
        }

        return $result;
    }

    /**
     * Inject the extension attributes after getting a product
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $result
     * @return ProductInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetById(
        ProductRepositoryInterface $subject,
        ProductInterface           $result
    ): ProductInterface {
        $this->afterGet($subject, $result);
        return $result;
    }

    /**
     * After a product is retrieved we inject the extension attribute in it
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $result
     * @return ProductInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface           $result
    ): ProductInterface {
        $priceBookAttribute = $this->priceBookRepository->getBySku($result->getSku());
        $extensionAttributes = $result->getExtensionAttributes();
        $extensionAttributes->setAmaroPricebookExtensionAttributes($priceBookAttribute);

        return $result;
    }
}
