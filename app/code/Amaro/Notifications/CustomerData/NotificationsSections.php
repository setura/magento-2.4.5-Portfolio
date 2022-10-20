<?php

declare(strict_types=1);

namespace Amaro\Notifications\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\Exception\LocalizedException;
use Amaro\Notifications\Api\NotificationRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Amaro\Notifications\Api\Data\NotificationInterface;
use Psr\Log\LoggerInterface;
use Magento\Authorization\Model\UserContextInterface;

/**
 * NotificationsSections class
 */
class NotificationsSections implements SectionSourceInterface
{
    /**
     * @var NotificationRepositoryInterface
     */
    private NotificationRepositoryInterface $notificationRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var UserContextInterface
     */
    private UserContextInterface $userContext;

    /**
     * Dependency injection
     *
     * @param NotificationRepositoryInterface $notificationRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param LoggerInterface $logger
     * @param UserContextInterface $userContext
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        LoggerInterface $logger,
        UserContextInterface $userContext
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->logger = $logger;
        $this->userContext = $userContext;
    }

    /**
     * @inheritdoc
     */
    public function getSectionData(): array
    {
        if (!$this->userContext->getUserId()) {
            return [];
        }

        $customerId = (int)$this->userContext->getUserId();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(
                NotificationInterface::CUSTOMER_ID,
                $customerId,
                'eq'
            )->create();

        try {
            $items = $this->notificationRepository->getList($searchCriteria)->getItems();
        } catch (LocalizedException $e) {
            $this->logger->error('Trying to get notification section data for the customer. -> '.$e->getMessage());
            return [];
        }

        $messages = [];
        foreach ($items as $item) {
            $messages[] = $item->getMessage();
        }

        return [
            'notifications' => $messages
        ];
    }
}
