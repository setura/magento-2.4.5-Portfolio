<?php

declare(strict_types=1);

namespace Amaro\Notifications\Api\Data;

/**
 * NotificationsSearchResultsInterface
 */
interface NotificationSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Notification list.
     *
     * @return \Amaro\Notifications\Api\Data\NotificationInterface[]
     */
    public function getItems();

    /**
     * Set notification_id list.
     *
     * @param \Amaro\Notifications\Api\Data\NotificationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
