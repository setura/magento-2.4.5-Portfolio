<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateSales\Plugin\Magento\Sales\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Amaro\DeliveryDateSales\Api\OrderRepositoryInterface as DeliveryDateOrderRepository;
use Magento\Sales\Model\ResourceModel\GridInterface;

/**
 * OrderRepositoryInterfacePlugin class
 */
class OrderRepositoryInterfacePlugin
{
    /**
     * Delivery date field name
     */
    public const FIELD_NAME = 'delivery_date';
    /**
     * @var OrderExtensionFactory
     */
    private OrderExtensionFactory $extensionFactory;
    /**
     * @var DeliveryDateOrderRepository
     */
    private DeliveryDateOrderRepository $orderRepository;
    /**
     * @var GridInterface
     */
    private GridInterface $entityGrid;

    /**
     * Dependency injection
     *
     * @param OrderExtensionFactory $extensionFactory
     * @param DeliveryDateOrderRepository $orderRepository
     * @param GridInterface $entityGrid
     */
    public function __construct(
        OrderExtensionFactory $extensionFactory,
        DeliveryDateOrderRepository $orderRepository,
        GridInterface $entityGrid
    ) {
        $this->extensionFactory = $extensionFactory;
        $this->orderRepository = $orderRepository;
        $this->entityGrid = $entityGrid;
    }

    /**
     * Load delivery date extension attribute
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $result
     * @param int $id
     * @return OrderInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface           $result,
        int                         $id
    ): OrderInterface {
        $deliveryDate = $result->getData(self::FIELD_NAME);
        $extensionAttributes = $result->getExtensionAttributes() ?: $this->extensionFactory->create();
        $extensionAttributes->setDeliveryDate($deliveryDate ?? '');

        return $result;
    }

    /**
     * Load delivery date extension attribute after get list
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $result
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderSearchResultInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetList(
        OrderRepositoryInterface   $subject,
        OrderSearchResultInterface $result,
        SearchCriteriaInterface    $searchCriteria
    ): OrderSearchResultInterface {
        $orders = $result->getItems();
        foreach ($orders as $order) {
            $this->afterGet(
                $subject,
                $order,
                $order->getEntityId()
            );
        }
        return $result;
    }

    /**
     * Save the updated extension attribute
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $result
     * @param OrderInterface $entity
     * @return OrderInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(
        OrderRepositoryInterface $subject,
        OrderInterface           $result,
        OrderInterface           $entity
    ): OrderInterface {
        $extensionAttributes = $entity->getExtensionAttributes() ?: $this->extensionFactory->create();
        if ($extensionAttributes->getDeliveryDate() !== null) {
            $deliveryDate = $extensionAttributes->getDeliveryDate();
            $this->orderRepository->saveDeliveryDate((int)$entity->getEntityId(), $deliveryDate);
            $this->entityGrid->refresh($result->getId());
        }

        return $result;
    }
}
