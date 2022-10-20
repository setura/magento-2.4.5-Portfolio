<?php

declare(strict_types=1);

namespace Amaro\Notifications\Api\Data;

/**
 * Notification Interface
 */
interface NotificationInterface
{
    /**
     * Customer id attribute
     */
    public const CUSTOMER_ID = 'customer_id';
    /**
     * Message attribute
     */
    public const MESSAGE = 'message';

    /**
     * This function sets the notification_Id of the notification
     *
     * @param int $id
     * @return void
     */
    public function setId(int $id);

    /**
     * This function gets the notification_Id of the notification
     *
     * @return mixed
     */
    public function getId();

    /**
     * This function sets the CustomerId of the notification
     *
     * @param int $id
     * @return void
     */
    public function setCustomerId(int $id);

    /**
     * This function gets the CustomerId of the notification
     *
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * This function sets the message of the notification
     *
     * @param string $message
     * @return void
     */
    public function setMessage(string $message);

    /**
     * This function gets the message of the notification
     *
     * @return string
     */
    public function getMessage();
}
