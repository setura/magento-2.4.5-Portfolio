<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateSales\Model;

use Amaro\DeliveryDateSales\Api\OrderRepositoryInterface;
use Amaro\DeliveryDateSales\Model\ResourceModel\Order;

/**
 * Order resource
 */
class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var Order
     */
    private Order $order;

    /**
     * Dependency injection
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Save delivery date on database
     *
     * @param int $orderId
     * @param string $deliveryDate
     * @return void
     */
    public function saveDeliveryDate(int $orderId, string $deliveryDate): void
    {
        $this->order->saveDeliveryDate($orderId, $deliveryDate);
    }

    /**
     * Get delivery date from database
     *
     * @param int $orderId
     * @return string|null
     */
    public function getDeliveryDate(int $orderId): ?string
    {
        return $this->order->getDeliveryDate($orderId);
    }
}
