<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateCheckout\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use \Magento\Store\Model\StoreManagerInterface;

/**
 * AdditionalConfigVars
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class AdditionalConfigVars implements ConfigProviderInterface
{
    /**
     * Enable status
     */
    private const XML_PATH_DELIVERY_DATE_FEE_ENABLED = 'deliverydatefee/general/enable';
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
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * Dependency injection
     *
     * @param CheckoutSession $checkoutSession
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Adds deliveryDate var to window.checkoutConfig
     *
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getConfig()
    {
        $deliveryDate=[];
        $storeScope = ScopeInterface::SCOPE_STORE;
        $extraDeliveryEnabled = $this->scopeConfig->getValue($this::XML_PATH_DELIVERY_DATE_FEE_ENABLED, $storeScope);
        $extraDeliveryCost = (double) $this->scopeConfig->getValue($this::XML_PATH_DELIVERY_DATE_FEE, $storeScope);
        $currency = $this->storeManager->getStore()->getCurrentCurrency()->getCode();

        $warningsData =[
            [
                'enabled' => $extraDeliveryEnabled,
                'warnings' => [],
                'cssClass' => [],
                'label' => __('Sunday'),
                'price' => 0
            ],
            [
                'enabled' => $extraDeliveryEnabled,
                'warnings' => [],
                'cssClass' => [],
                'label' => __('Monday'),
                'price' => 0
            ],
            [
                'enabled' => $extraDeliveryEnabled,
                'warnings' => [],
                'cssClass' => [],
                'label' => __('Tuesday'),
                'price' => 0
            ],
            [
                'enabled' => $extraDeliveryEnabled,
                'warnings' => [],
                'cssClass' => [],
                'label' => __('Wednesday'),
                'price' => 0
            ],
            [
                'enabled' => $extraDeliveryEnabled,
                'warnings' => [],
                'cssClass' => [],
                'label' => __('Thursdays'),
                'price' => 0
            ],
            [
                'enabled' => $extraDeliveryEnabled,
                'warnings' => [],
                'cssClass' => [],
                'label' => __('Friday'),
                'price' => 0
            ],
            [
                'enabled' => $extraDeliveryEnabled,
                'warnings' =>
                    [
                    'Delivers on saturdays will increase the cost of the shipment by '.
                    $extraDeliveryCost.
                    $currency
                ],
                'cssClass' => ['delivery-saturday-highlight'],
                'label' => __('Saturdays'),
                'price' => $extraDeliveryCost
            ]
        ];

        $deliveryDateValue = $this->checkoutSession->getQuote()->getExtensionAttributes()->getDeliveryDate();

        if (empty($deliveryDateValue)) {
            return $deliveryDate;
        }

        $deliveryDate['deliveryData'] = $warningsData;
        $deliveryDate['deliveryDate'] = substr($deliveryDateValue, 0, 10);
        return $deliveryDate;
    }
}
