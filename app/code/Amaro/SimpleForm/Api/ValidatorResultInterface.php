<?php

declare(strict_types=1);

namespace Amaro\SimpleForm\Api;

/**
 * Interface ValidatorResultInterface
 */
interface ValidatorResultInterface
{
    /**
     * Add message to the result
     *
     * @param string $message
     * @return void
     */
    public function addMessage($message);

    /**
     * Verifies if any message exists
     *
     * @return bool
     */
    public function hasMessages();

    /**
     * Get message from the result
     *
     * @return string[]
     */
    public function getMessages();
}
