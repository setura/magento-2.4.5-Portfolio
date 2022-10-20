<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateEmail\Observer\Frontend\Email;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrderSetTemplateVarsBefore implements ObserverInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * Dependency injection
     *
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
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
        $transport = $observer->getTransport();
        $order = $transport->getData('order');
        $deliveryDate = $order->getExtensionAttributes()->getDeliveryDate();

        if ($deliveryDate !== null) {
            $transport['delivery_date'] = $deliveryDate;
        }
    }
}
