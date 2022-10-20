<?php

declare(strict_types=1);

namespace Amaro\Example\Plugin\Magento\Framework\App\Action;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\AttributeValue;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Amaro\Example\Api\CustomerPermissionInterface;

/**
 * Class GetUpdateContextPlugin
 */
class GetRequestUpdateContextPlugin
{
    /**
     * @var Session
     */
    private Session $customerSession;
    /**
     * @var HttpContext
     */
    private HttpContext $context;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Dependency injection
     *
     * @param Session $customerSession
     * @param HttpContext $context
     * @param LoggerInterface $logger
     */
    public function __construct(
        Session $customerSession,
        HttpContext $context,
        LoggerInterface $logger
    ) {
        $this->customerSession = $customerSession;
        $this->context = $context;
        $this->logger = $logger;
    }

    /**
     * Update customer hide prices attribute cache context for caching purposes on get requests
     *
     * @param Action $subject
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeDispatch(Action $subject)
    {
        $customer = $this->customerSession->getCustomer();

        if ($customer->getEntityId() == null) {
            return;
        }

        $hidePricesValue = $this->getHidePriceAttribute();

        if (!$hidePricesValue) {
            return;
        }

        $this->context->setValue(
            CustomerPermissionInterface::HTTP_CONTEXT_HIDE_PRICES,
            $hidePricesValue,
            false
        );
    }

    /**
     * Get the hide_prices customer attribute
     *
     * @return int
     */
    public function getHidePriceAttribute(): int
    {
        try {
            $hidePricesCodeAttribute = $this->customerSession->getCustomerData()
                ->getCustomAttribute(CustomerPermissionInterface::ATTRIBUTE_CODE_CUSTOMER_HIDE_PRICES);
            if (!($hidePricesCodeAttribute instanceof AttributeValue)) {
                return 0;
            }
            return (int) $hidePricesCodeAttribute->getValue();
        } catch (NoSuchEntityException|LocalizedException $e) {
            $this->logger->error("An error occurred while getting custom attribute from customer.");
            return 0;
        }
    }
}
