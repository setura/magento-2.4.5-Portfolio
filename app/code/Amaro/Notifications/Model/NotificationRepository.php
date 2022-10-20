<?php

declare(strict_types=1);

namespace Amaro\Notifications\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Amaro\Notifications\Api\Data\NotificationInterface;
use Amaro\Notifications\Api\Data\NotificationInterfaceFactory;
use Amaro\Notifications\Api\Data\NotificationSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Amaro\Notifications\Api\NotificationRepositoryInterface;
use Amaro\Notifications\Model\ResourceModel\Notification as ResourceNotification;
use Amaro\Notifications\Model\ResourceModel\Notification\CollectionFactory as NotificationCollectionFactory;

/**
 * NotificationRepository class
 */
class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * @var ResourceNotification
     */
    private ResourceNotification $resource;
    /**
     * @var NotificationInterfaceFactory
     */
    private NotificationInterfaceFactory $notificationFactory;
    /**
     * @var NotificationCollectionFactory
     */
    private NotificationCollectionFactory $notificationCollectionFactory;
    /**
     * @var NotificationSearchResultsInterfaceFactory
     */
    private NotificationSearchResultsInterfaceFactory $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * Inject dependencies
     *
     * @param ResourceNotification $resource
     * @param NotificationInterfaceFactory $notificationFactory
     * @param NotificationCollectionFactory $notificationCollectionFactory
     * @param NotificationSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ResourceNotification $resource,
        NotificationInterfaceFactory $notificationFactory,
        NotificationCollectionFactory $notificationCollectionFactory,
        NotificationSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resource = $resource;
        $this->notificationFactory = $notificationFactory;
        $this->notificationCollectionFactory = $notificationCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function save(NotificationInterface $notification): NotificationInterface
    {
        try {
            $this->resource->save($notification);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the notification: %1',
                $exception->getMessage()
            ));
        }
        return $notification;
    }

    /**
     * @inheritDoc
     */
    public function get($notificationId): NotificationInterface
    {
        $notification = $this->notificationFactory->create();
        $this->resource->load($notification, $notificationId);
        if (!$notification->getId()) {
            throw new NoSuchEntityException(__('notification with id "%1" does not exist.', $notificationId));
        }
        return $notification;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->notificationCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(NotificationInterface $notification): bool
    {
        try {
            $this->resource->delete($notification);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $notificationId): bool
    {
        return $this->delete($this->get($notificationId));
    }

    /**
     * @inheritDoc
     */
    public function getListByCustomerId(int $customerId)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(
                NotificationInterface::CUSTOMER_ID,
                $customerId,
                'eq'
            )->create();

        return $this->getList($searchCriteria);
    }

    /**
     * @inheritDoc
     */
    public function getForCustomer(int $notificationId, int $customerId) : NotificationInterface
    {
        $notification = $this->get($notificationId);
        if ($notification->getCustomerId() != $customerId) {
            throw new NoSuchEntityException(__('Notification not found.'));
        }

        return $notification;
    }

    /**
     * @inheritDoc
     */
    public function saveForCustomer(
        NotificationInterface $notification,
        int $notificationId,
        int $customerId
    ): NotificationInterface {
        $previousNotification = $this->get($notification->getId());
        if ($previousNotification->getCustomerId() !== $customerId) {
            throw new NoSuchEntityException(__('Coudn\'t save the notification.'));
        }

        $notification->setCustomerId($customerId);

        return $this->save($notification);
    }
}
