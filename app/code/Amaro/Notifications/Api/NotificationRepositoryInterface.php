<?php

declare(strict_types=1);

namespace Amaro\Notifications\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Amaro\Notifications\Api\Data\NotificationInterface;
use Amaro\Notifications\Api\Data\NotificationSearchResultsInterface;

/**
 * NotificationRepository Interface
 */
interface NotificationRepositoryInterface
{
    /**
     * Save post
     *
     * @param NotificationInterface $notification
     * @return NotificationInterface
     * @throws LocalizedException
     */
    public function save(NotificationInterface $notification);

    /**
     * Retrieve post
     *
     * @param int $notificationId
     * @return NotificationInterface
     * @throws LocalizedException
     */
    public function get(int $notificationId): NotificationInterface;

    /**
     * Retrieve post matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return NotificationSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete post
     *
     * @param NotificationInterface $notification
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(NotificationInterface $notification): bool;

    /**
     * Delete notification by ID
     *
     * @param int $notificationId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $notificationId): bool;

    /**
     * Get all the notifications of the user
     *
     * @param int $customerId
     * @return NotificationSearchResultsInterface
     * @throws LocalizedException
     */
    public function getListByCustomerId(int $customerId);

    /**
     * Get a single notification from the user
     *
     * @param int $notificationId
     * @param int $customerId
     * @return NotificationInterface
     * @throws LocalizedException
     */
    public function getForCustomer(int $notificationId, int $customerId): NotificationInterface;

    /**
     * Update the notification if it belongs to the user
     *
     * @param NotificationInterface $notification
     * @param int $notificationId
     * @param int $customerId
     * @return NotificationInterface
     * @throws LocalizedException
     */
    public function saveForCustomer(
        NotificationInterface $notification,
        int $notificationId,
        int $customerId
    ): NotificationInterface;
}
