<?php

declare(strict_types=1);

namespace Amaro\Customer\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use \Magento\Customer\Model\Session;

/**
 * This customer class is responsible to process the data of the customer
 */
class Customer implements ArgumentInterface
{
    /**
     * @var Session
     */
    private Session $customer;

    /**
     * Inject dependencies
     *
     * @param Session $customer
     */
    public function __construct(
        Session $customer
    ) {
        $this->customer = $customer;
    }

    /**
     * This function gets the mobile phone of the customer
     *
     * @return string
     */
    public function getMobilePhone(): string
    {
        if (!$this->customer->isLoggedIn()) {
            return '';
        }

        return $this->customer->getCustomerData()->getCustomAttribute('mobile_number')->getValue();
    }
}
