<?php

declare(strict_types=1);

namespace Amaro\PriceBookElasticsearch\Plugin\Magento\Catalog\Model\ResourceModel\Product;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\App\Http\Context as HttpContext;
use Amaro\PriceBookCustomer\Api\PriceBookInterface;

/**
 * CollectionPlugin class
 */
class CollectionPlugin
{
    public const PRICEBOOK_FILTER_ADDED_FLAG = "pricebook_filter_added";

    /**
     * @var HttpContext
     */
    private HttpContext $httpContext;

    /**
     * Dependency injection
     *
     * @param HttpContext $httpContext
     */
    public function __construct(HttpContext $httpContext)
    {
        $this->httpContext = $httpContext;
    }

    /**
     * Add pricebook filter to collection.
     *
     * @param Collection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @return array
     */
    public function beforeLoad(
        Collection $subject,
        bool       $printQuery = false,
        bool       $logQuery = false
    ) {
        if ($subject->getFlag(self::PRICEBOOK_FILTER_ADDED_FLAG)) {
            return [$printQuery, $logQuery];
        }

        $userPriceBook = explode(
            ",",
            $this->httpContext->getValue(PriceBookInterface::HTTP_CONTEXT_PRICE_BOOK)
        );

        $subject->addFieldToFilter('pricebook', $userPriceBook);
        $subject->setFlag(self::PRICEBOOK_FILTER_ADDED_FLAG, true);
        return [$printQuery, $logQuery];
    }
}
