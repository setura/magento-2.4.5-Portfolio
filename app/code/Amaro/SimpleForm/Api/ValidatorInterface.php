<?php

declare(strict_types=1);

namespace Amaro\SimpleForm\Api;

use Magento\Framework\Exception\LocalizedException;

/**
 * Interface ValidatorInterface
 */
interface ValidatorInterface
{
    /**
     * Validator method
     *
     * @param string[] $data
     * @return ValidatorResultInterface
     * @throws LocalizedException
     */
    public function validate(array $data):ValidatorResultInterface;
}
