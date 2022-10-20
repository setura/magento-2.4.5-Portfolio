<?php

declare(strict_types=1);

namespace Amaro\PriceBookCustomer\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Amaro\PriceBookCustomer\Api\HttpContextInterface;

/**
 * Class CustomerHidePricesContextObserver
 */
class CustomerPriceBookContextObserver implements ObserverInterface
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
     * This will ensure that the context is updated when lodging into an account
     *
     * @param Observer $observer
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(Observer $observer)
    {
        $this->pricebookIntoHttpContext->updatePriceBook();
    }
}
