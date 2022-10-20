<?php

declare(strict_types=1);

namespace Amaro\Example\Plugin\Magento\Catalog\Pricing\Render;

use Magento\Catalog\Pricing\Render\FinalPriceBox as FinalPriceBoxAlias;
use Magento\Framework\App\Http\Context as HttpContext;
use Amaro\Example\Api\CustomerPermissionInterface;

/**
 * FinalPriceBoxPlugin class
 */
class FinalPriceBoxPlugin
{

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
     * Check if product may show price
     *
     * @param FinalPriceBoxAlias $subject
     * @param string $result
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterToHtml(
        FinalPriceBoxAlias $subject,
        string $result
    ): string {

        if ((int)$this->httpContext->getValue(CustomerPermissionInterface::HTTP_CONTEXT_HIDE_PRICES) === 1) {
            return '';
        }

        return $result;
    }
}
