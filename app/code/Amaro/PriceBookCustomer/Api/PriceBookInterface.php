<?php

declare(strict_types=1);

namespace Amaro\PriceBookCustomer\Api;

interface PriceBookInterface
{
    public const HTTP_CONTEXT_PRICE_BOOK            = 'customer_price_book';
    public const ATTRIBUTE_CODE_CUSTOMER_PRICE_BOOK = 'price_book';
}
