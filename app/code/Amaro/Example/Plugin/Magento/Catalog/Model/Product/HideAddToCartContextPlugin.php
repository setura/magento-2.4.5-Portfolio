<?php

declare(strict_types=1);

namespace Amaro\Example\Plugin\Magento\Catalog\Model\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\Http\Context as HttpContext;
use Amaro\Example\Api\CustomerPermissionInterface;

/**
 * HideAddToCartContextPlugin class
 */
class HideAddToCartContextPlugin
{
    /**
     * @var HttpContext
     */
    private HttpContext $context;

    /**
     * Dependency injection
     *
     * @param HttpContext $context
     */
    public function __construct(HttpContext $context)
    {
        $this->context = $context;
    }

    /**
     * Check if product may show add to cart button
     *
     * @param Product $subject
     * @param bool $result
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterIsSaleable(
        Product $subject,
        bool $result
    ): bool {
        if ((int)$this->context->getValue(CustomerPermissionInterface::HTTP_CONTEXT_HIDE_PRICES) === 1) {
            return false;
        }

        return $result;
    }
}
