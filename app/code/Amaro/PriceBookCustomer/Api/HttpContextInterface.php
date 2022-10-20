<?php

declare(strict_types=1);

namespace Amaro\PriceBookCustomer\Api;

/**
 * HttpContextInterface class
 */
interface HttpContextInterface
{
    /**
     * Update customer pricebook attribute http context for caching purposes on get requests
     *
     * @return void
     */
    public function updatePriceBook(): void;
}
