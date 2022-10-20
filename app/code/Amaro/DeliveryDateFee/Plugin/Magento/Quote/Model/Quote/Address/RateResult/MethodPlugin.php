<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateFee\Plugin\Magento\Quote\Model\Quote\Address\RateResult;

use DateTime;
use Exception;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

/**
 * MethodPlugin class
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class MethodPlugin
{
    /**
     * Default DELIVERY_DATE_FEE
     */
    private const XML_PATH_DELIVERY_DATE_FEE = 'deliverydatefee/general/saturdayfee';

    /**
     * @var CheckoutSession
     */
    private CheckoutSession $checkoutSession;
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Dependency injection
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param CheckoutSession $checkoutSession
     * @param LoggerInterface $logger
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CheckoutSession $checkoutSession,
        LoggerInterface $logger
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->logger = $logger;
    }

    /**
     * Add extra delivery cost if the delivery Date is set to a saturday
     *
     * @param Method $subject
     * @param float|int|string $price
     * @return float[]
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSetPrice(
        Method $subject,
        float|int|string $price
    ): array {
        $deliveryDate = $this->checkoutSession->getQuote()->getExtensionAttributes()->getDeliveryDate();

        if (empty($deliveryDate)) {
            return [$price];
        }

        try {
            $date = new DateTime($deliveryDate);
            $day =  $date->format("w");
            if ((int)$day !== 6) {
                return [$price];
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
        $storeScope = ScopeInterface::SCOPE_STORE;
        $extraDeliveryCost = (double) $this->scopeConfig->getValue($this::XML_PATH_DELIVERY_DATE_FEE, $storeScope);
        return [(double)$price + $extraDeliveryCost];
    }
}
