<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateCheckout\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * DeliveryDateManagementInterface class
 */
interface DeliveryDateManagementInterface
{
    /**
     * Save delivery date in quote
     *
     * @param string $deliveryDate
     * @param int $customerId
     * @return void
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function save(string $deliveryDate, int $customerId): void;

    /**
     * Save delivery date in quote
     *
     * @param string $deliveryDate
     * @param int $cartId
     * @return string
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function saveGuest(string $deliveryDate, int $cartId): void;
}
