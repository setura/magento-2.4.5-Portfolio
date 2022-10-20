<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateQuote\Model;

use Amaro\DeliveryDateQuote\Api\CartRepositoryInterface;
use Amaro\DeliveryDateQuote\Model\ResourceModel\Quote;

/**
 * Order resource
 */
class QuoteRepository implements CartRepositoryInterface
{
    /**
     * @var Quote
     */
    private Quote $quote;

    /**
     * Dependency injection
     *
     * @param Quote $quote
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * Save delivery date on database
     *
     * @param int $cartId
     * @param string $deliveryDate
     * @return void
     */
    public function saveDeliveryDate(int $cartId, string $deliveryDate): void
    {
        $this->quote->saveDeliveryDate($cartId, $deliveryDate);
    }

    /**
     * Get delivery date from database
     *
     * @param int $cartId
     * @return string|null
     */
    public function getDeliveryDate(int $cartId): ?string
    {
        return $this->quote->getDeliveryDate($cartId);
    }
}
