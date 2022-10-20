<?php

declare(strict_types=1);

namespace Amaro\PriceBookCustomer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Amaro\PriceBookCustomer\Model\Entity\Attribute\Source\AllowedPriceBooks;
use Zend_Validate_Exception;
use Amaro\PriceBookCustomer\Api\PriceBookInterface;

/**
 * Creating the pricebook attribute for the customer
 */
class PriceBookAttribute implements DataPatchInterface
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
     * Creating the pricebook customer attribute
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
            PriceBookInterface::ATTRIBUTE_CODE_CUSTOMER_PRICE_BOOK,
            [
                'type' => 'text',
                'input' => 'multiselect',
                'label' => 'Allowed PricesBook codes',
                'required' => false,
                'backend' => ArrayBackend::class,
                'source' =>AllowedPriceBooks::class,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 75,
                'sort_order' => 50,
                'unique' => false
            ]
        );

        $newAttribute = $customerSetup->getEavConfig()->getAttribute(
            Customer::ENTITY,
            PriceBookInterface::ATTRIBUTE_CODE_CUSTOMER_PRICE_BOOK
        );
        $newAttribute->addData([
            'used_in_forms' => ['adminhtml_customer'],
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroup
        ]);

        $this->attributeResource->save($newAttribute);
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
