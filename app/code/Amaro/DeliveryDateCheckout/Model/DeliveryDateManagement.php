<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateCheckout\Model;

use DateTime;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Amaro\DeliveryDateQuote\Api\CartRepositoryInterface as DeliveryDateCartRepository;
use Magento\Quote\Api\Data\CartInterface;
use Amaro\DeliveryDateCheckout\Api\DeliveryDateManagementInterface;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * DeliveryDateManagement class
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class DeliveryDateManagement implements DeliveryDateManagementInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private CartRepositoryInterface $cartRepository;
    /**
     * @var CustomerSession
     */
    private CustomerSession $customerSession;
    /**
     * @var DeliveryDateCartRepository
     */
    private DeliveryDateCartRepository $deliveryDateCartRepository;

    /**
     * Dependency injection
     *
     * @param CartRepositoryInterface $cartRepository
     * @param CustomerSession $customerSession
     * @param DeliveryDateCartRepository $deliveryDateCartRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        CustomerSession $customerSession,
        DeliveryDateCartRepository $deliveryDateCartRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->customerSession = $customerSession;
        $this->deliveryDateCartRepository = $deliveryDateCartRepository;
    }

    /**
     * Save delivery date in quote
     *
     * @param string $deliveryDate
     * @param int $customerId
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function save(string $deliveryDate, int $customerId): void
    {
        $cart = $this->cartRepository->getActiveForCustomer($customerId);
        $this->saveDeliveryDate($cart, $deliveryDate);
    }

    /**
     * Save delivery date in quote
     *
     * @param string $deliveryDate
     * @param int $cartId
     * @return void
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function saveGuest(string $deliveryDate, int $cartId): void
    {
        if ($this->customerSession->isLoggedIn()) {
            throw new NoSuchEntityException(__('Cart not found.'));
        }
        $cart = $this->cartRepository->getActive($cartId);
        $this->saveDeliveryDate($cart, $deliveryDate);
    }

    /**
     * Save the delivery date
     *
     * @param CartInterface $cart
     * @param string $deliveryDate
     * @return void
     * @throws LocalizedException
     */
    private function saveDeliveryDate(CartInterface $cart, string $deliveryDate): void
    {
        if (!DateTime::createFromFormat('Y-m-d', $deliveryDate) ||
            (!empty($cart->getDeliveryDate) && substr($cart->getDeliveryDate(), 0, 10) === $deliveryDate)
        ) {
            throw new LocalizedException(__('Delivery Date can\'t be rewritten.'. $deliveryDate));
        }

        $extensionAttributes = $cart->getExtensionAttributes();
        $extensionAttributes->setDeliveryDate($deliveryDate);
        $this->deliveryDateCartRepository->saveDeliveryDate((int) $cart->getId(), $deliveryDate);
    }
}
