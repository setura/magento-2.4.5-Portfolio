<?php

declare(strict_types=1);

namespace Amaro\PriceBookCustomer\Model;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Http\Context;
use Magento\Setup\Exception;
use Magento\Store\Model\StoreManagerInterface;
use Amaro\PriceBookCustomer\Api\HttpContextInterface;
use Psr\Log\LoggerInterface;
use Amaro\PriceBookCustomer\Api\PriceBookInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * HttpContext class
 *
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 */
class HttpContext implements HttpContextInterface
{
    /**
     * @var Session
     */
    private Session $customerSession;
    /**
     * @var Context
     */
    private Context $context;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
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
     * @param Session $customerSession
     * @param Context $context
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Session $customerSession,
        Context $context,
        LoggerInterface $logger,
        ScopeConfigInterface  $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->customerSession = $customerSession;
        $this->context = $context;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Update customer pricebook attribute http context for caching purposes on get requests
     *
     * @return void
     */
    public function updatePriceBook(): void
    {
        $this->context->setValue(
            PriceBookInterface::HTTP_CONTEXT_PRICE_BOOK,
            $this->getPriceBookCodes(),
            false
        );
    }

    /**
     * Get the priceBook customer attribute
     *
     * @return ?string
     */
    private function getPriceBookCodes(): ?string
    {
        try {
            if ($this->customerSession->isLoggedIn()) {
                $priceBookValueCodeAttribute = $this->customerSession->getCustomer()->getData('price_book');

                if (!empty($priceBookValueCodeAttribute)) {
                    return $priceBookValueCodeAttribute;
                }
            }
        } catch (Exception $e) {
            $this->logger->error("An error occurred while getting custom attribute from customer.");
        }

        return $this->scopeConfig->getValue(
            "priceBook/general/defaultPriceCode",
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }
}
