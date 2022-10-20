<?php

declare(strict_types=1);

namespace Amaro\SimpleForm\Model;

use Amaro\SimpleForm\Api\ValidatorResultInterface;

/**
 * Validation result messages class
 */
class ValidatorResult implements ValidatorResultInterface
{
    /**
     * @var string[]
     */
    private $messages;

    /**
     * Inject Dependencies
     *
     * @param array $messages
     */
    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

    /**
     * @inheritdoc
     */
    public function addMessage($message)
    {
        $this->messages[] = (string)$message;
    }

    /**
     * @inheritdoc
     */
    public function hasMessages()
    {
        return count($this->messages) > 0;
    }

    /**
     * @inheritdoc
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
