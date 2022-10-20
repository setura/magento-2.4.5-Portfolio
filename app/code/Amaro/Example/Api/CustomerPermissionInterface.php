<?php

declare(strict_types=1);

namespace Amaro\Example\Api;

/**
 * CustomerPermissionInterface class
 */
interface CustomerPermissionInterface
{
    public const HTTP_CONTEXT_HIDE_PRICES            = 'customer_hide_prices';
    public const ATTRIBUTE_CODE_CUSTOMER_HIDE_PRICES = 'hide_prices';
}
