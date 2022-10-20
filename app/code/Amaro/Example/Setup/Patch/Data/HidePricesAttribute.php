<?php

declare(strict_types=1);

namespace Amaro\Example\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Customer\Model\Attribute\Backend\Data\Boolean;
use Zend_Validate_Exception;
use Amaro\Example\Api\CustomerPermissionInterface;

/**
 * In this Data pacth we are creating the hide_prices attribute for the customer
 *
 * @SuppressWarnings(PHPCPD-START)
 */
class HidePricesAttribute implements DataPatchInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private CustomerSetupFactory $customerSetupFactory;
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $setup;
    /**
     * @var Config
     */
    private Config $eavConfig;
    /**
     * @var Attribute
     */
    private Attribute $attributeResource;

    /**
     * Dependency injection
     *
     * @param ModuleDataSetupInterface $setup
     * @param Config $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     * @param Attribute $attributeResource
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        Config $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        Attribute $attributeResource
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->setup = $setup;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
    }

    /**
     * Creating the hide_prices customer attribute
     *
     * @return void
     * @throws LocalizedException|Zend_Validate_Exception
     */
    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerSetup->getDefaultAttributeSetId($customerEntity->getEntityTypeId());
        $attributeGroup = $customerSetup->getDefaultAttributeGroupId(
            $customerEntity->getEntityTypeId(),
            $attributeSetId
        );

        $customerSetup->addAttribute(
            Customer::ENTITY,
            CustomerPermissionInterface::ATTRIBUTE_CODE_CUSTOMER_HIDE_PRICES,
            [
                'type' => 'int',
                'input' => 'boolean',
                'label' => 'Hide Prices',
                'required' => true,
                'backend' => Boolean::class,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 70,
                'sort_order' => 50,
                'unique' => false
            ]
        );

        $newAttribute = $customerSetup->getEavConfig()->getAttribute(
            Customer::ENTITY,
            CustomerPermissionInterface::ATTRIBUTE_CODE_CUSTOMER_HIDE_PRICES
        );
        $newAttribute->addData([
            'used_in_forms' => ['adminhtml_customer'],
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroup
        ]);

        $this->attributeResource->save($newAttribute);
    }

    /**
     * @SuppressWarnings(PHPCPD-END)
     */
    
    /**
     * This function gets the dependencies for the attribute
     *
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * This function gets the aliases for the attribute
     *
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }
}
