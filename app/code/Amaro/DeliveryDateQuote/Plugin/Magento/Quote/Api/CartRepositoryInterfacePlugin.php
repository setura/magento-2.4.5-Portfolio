<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateQuote\Plugin\Magento\Quote\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartExtensionFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartSearchResultsInterface;
use Amaro\DeliveryDateQuote\Api\CartRepositoryInterface as DeliveryDateCartRepository;

/**
 * CartRepositoryInterfacePlugin class
 */
class CartRepositoryInterfacePlugin
{
    /**
     * Delivery date field name
     */
    public const FIELD_NAME = 'delivery_date';
    /**
     * @var CartExtensionFactory
     */
    private CartExtensionFactory $extensionFactory;
    /**
     * @var DeliveryDateCartRepository
     */
    private DeliveryDateCartRepository $deliveryDateCartRepository;

    /**
     * Dependency injection
     *
     * @param CartExtensionFactory $extensionFactory
     * @param DeliveryDateCartRepository $deliveryDateCartRepository
     */
    public function __construct(
        CartExtensionFactory $extensionFactory,
        DeliveryDateCartRepository $deliveryDateCartRepository
    ) {
        $this->extensionFactory = $extensionFactory;
        $this->deliveryDateCartRepository = $deliveryDateCartRepository;
    }

    /**
     * Load delivery date extension attribute after get
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $result
     * @param int $cartId
     * @return CartInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(
        CartRepositoryInterface $subject,
        CartInterface           $result,
        int                     $cartId
    ): CartInterface {
        $deliveryDate = $result->getData(self::FIELD_NAME);
        $extensionAttributes = $result->getExtensionAttributes() ?: $this->extensionFactory->create();
        $extensionAttributes->setDeliveryDate($deliveryDate ?? '');

        return $result;
    }

    /**
     * Load delivery date extension attribute after get list
     *
     * @param CartRepositoryInterface $subject
     * @param CartSearchResultsInterface $result
     * @param SearchCriteriaInterface $searchCriteria
     * @return CartSearchResultsInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetList(
        CartRepositoryInterface     $subject,
        CartSearchResultsInterface  $result,
        SearchCriteriaInterface     $searchCriteria
    ): CartSearchResultsInterface {
        $quotes = $result->getItems();
        foreach ($quotes as $quote) {
            $this->afterGet(
                $subject,
                $quote,
                $quote->getEntityId()
            );
        }
        return $result;
    }

    /**
     * Save the updated extension attribute
     *
     * @param CartRepositoryInterface $subject
     * @param mixed $result
     * @param CartInterface $quote
     * @return null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(
        CartRepositoryInterface $subject,
        $result,
        CartInterface           $quote
    ) {
        $extensionAttributes = $quote->getExtensionAttributes() ?: $this->extensionFactory->create();
        $deliveryDate = $extensionAttributes->getDeliveryDate();
        if (!empty($deliveryDate) && $deliveryDate !== $quote->getDeliveryDate()) {
            $deliveryDate = $extensionAttributes->getDeliveryDate();
            $this->deliveryDateCartRepository->saveDeliveryDate((int) $quote->getId(), $deliveryDate);
        }

        return $result;
    }

    /**
     * Save the updated extension attribute
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $quote
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSave(
        CartRepositoryInterface $subject,
        CartInterface           $quote
    ): array {
        $extensionAttributes = $quote->getExtensionAttributes() ?: $this->extensionFactory->create();
        $deliveryDate = $extensionAttributes->getDeliveryDate();

        if ((empty($deliveryDate) && $deliveryDate === $quote->getDeliveryDate())
            || !empty($quote->getDeliveryDate())
        ) {
            return [$quote];
        }

        $deliveryDate = $this->deliveryDateCartRepository->getDeliveryDate((int) $quote->getId());
        $quote->setDeliveryDate($deliveryDate);

        return [$quote];
    }
}
