<?php

declare(strict_types=1);

namespace Amaro\Example\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Amaro\Example\Api\CustomerPermissionInterface;

/**
 * Class CustomerHidePricesContextObserver
 */
class CustomerHidePricesContextObserver implements ObserverInterface
{
    /**
     * @var HttpContext
     */
    private HttpContext $context;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Dependency injection
     *
     * @param HttpContext $context
     * @param LoggerInterface $logger
     */
    public function __construct(
        HttpContext $context,
        LoggerInterface $logger
    ) {
        $this->context = $context;
        $this->logger = $logger;
    }

    /**
     * This will ensure that the context is updated when lodging into an account
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $hidePricesValue = $this->getHidePriceAttribute($observer);

        if (!$hidePricesValue) {
            return;
        }

        $this->context->setValue(
            CustomerPermissionInterface::HTTP_CONTEXT_HIDE_PRICES,
            $hidePricesValue,
            false
        );
    }

    /**
     * Get the hide_prices customer attribute
     *
     * @param Observer $observer
     * @return int
     */
    public function getHidePriceAttribute(Observer $observer): int
    {
        try {
            return (int) $observer->getEvent()->getCustomer()
                ->getData(CustomerPermissionInterface::ATTRIBUTE_CODE_CUSTOMER_HIDE_PRICES);
        } catch (NoSuchEntityException|LocalizedException $e) {
            $this->logger->error("An error occurred while getting custom attribute from customer.");
            return 0;
        }
    }
}
