<?php

declare(strict_types=1);

namespace Amaro\Customer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Amaro\Customer\Model\Attribute\Backend\IrishMobileValidator;

/**
 * In this Data pacth we are creating the irish mobile number for the customer
 */
class MobileNumberAttribute implements DataPatchInterface
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
     * @param ModuleDataSetupInterface $setup
     * @param Config $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        Config $eavConfig,
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->setup = $setup;
        $this->eavConfig = $eavConfig;
    }

    /**
     * Creating the mobile number customer attribute
     *
     * @return MobileNumberAttribute|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerSetup->getDefaultAttributeSetId($customerEntity->getEntityTypeId());
        $attributeGroup = $customerSetup
                            ->getDefaultAttributeGroupId(
                                $customerEntity->getEntityTypeId(),
                                $attributeSetId
                            );

        $customerSetup->addAttribute(Customer::ENTITY, 'mobile_number', [
            'type' => 'varchar',
            'input' => 'text',
            'label' => 'Mobile Number',
            'required' => true,
            'frontend_class' => 'validate-phone-number',
            'backend' => IrishMobileValidator::class,
            'default' => "",
            'visible' => true,
            'user_defined' => true,
            'system' => false,
            'is_visible_in_grid' => true,
            'is_used_in_grid' => true,
            'is_filterable_in_grid' => true,
            'is_searchable_in_grid' => true,
            'position' => 50,
            'sort_order' => 50,
            'unique' => false
        ]);
        $newAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'mobile_number');
        $newAttribute->addData([
            'used_in_forms' => ['customer_account_edit','customer_account_create','adminhtml_customer'],
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroup
        ]);
        $newAttribute->save();
    }

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
