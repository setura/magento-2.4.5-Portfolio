<?php

declare(strict_types=1);

namespace Amaro\PriceBookCustomer\Plugin\Magento\Framework\App\Action;

use Magento\Framework\App\Action\Action;
use Amaro\PriceBookCustomer\Api\HttpContextInterface;

/**
 * Class GetUpdateContextPlugin
 */
class GetRequestUpdateContextPlugin
{
    /**
     * @var HttpContextInterface
     */
    private HttpContextInterface $pricebookIntoHttpContext;

    /**
     * Dependency injection
     *
     * @param HttpContextInterface $pricebookIntoHttpContext
     */
    public function __construct(HttpContextInterface $pricebookIntoHttpContext)
    {
        $this->pricebookIntoHttpContext = $pricebookIntoHttpContext;
    }

    /**
     * Update customer pricebook attribute cache context for caching purposes on get requests
     *
     * @param Action $subject
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeDispatch(Action $subject)
    {
        $this->pricebookIntoHttpContext->updatePriceBook();
    }
}
