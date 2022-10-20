<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateSales\Api;

/**
 * Order resource
 */
interface OrderRepositoryInterface
{
    /**
     * Save delivery date on database
     *
     * @param int $orderId
     * @param string $deliveryDate
     * @return void
     */
    public function saveDeliveryDate(int $orderId, string $deliveryDate): void;

    /**
     * Get delivery date from database
     *
     * @param int $orderId
     * @return string|null
     */
    public function getDeliveryDate(int $orderId): ?string;
}
