<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateQuote\Api;

/**
 * Order resource
 */
interface CartRepositoryInterface
{
    /**
     * Save delivery date on database
     *
     * @param int $cartId
     * @param string $deliveryDate
     * @return void
     */
    public function saveDeliveryDate(int $cartId, string $deliveryDate): void;

    /**
     * Get delivery date from database
     *
     * @param int $cartId
     * @return string|null
     */
    public function getDeliveryDate(int $cartId): ?string;
}
