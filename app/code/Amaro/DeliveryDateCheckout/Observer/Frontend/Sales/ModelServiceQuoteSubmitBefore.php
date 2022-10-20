<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateCheckout\Observer\Frontend\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Api\CartRepositoryInterface;

/**
 * ModelServiceQuoteSubmitBefore
 */
class ModelServiceQuoteSubmitBefore implements ObserverInterface
{

    /**
     * @var CartRepositoryInterface
     */
    private CartRepositoryInterface $cartRepository;

    /**
     * Dependency injection
     *
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(
        Observer $observer
    ) {
        $order = $observer->getOrder();
        $quote = $this->cartRepository->get($order->getQuoteId());
        $deliveryDate = $quote->getExtensionAttributes()->getDeliveryDate();
        $order->getExtensionAttributes()->setDeliveryDate($deliveryDate);
    }
}
