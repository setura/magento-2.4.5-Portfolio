<?php

declare(strict_types=1);

namespace Amaro\Customer\Model\Attribute\Backend;

/**
 * In this model we are creating the validation for the mobile input on the admin panel
 */
class IrishMobileValidator extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * @var int
     */
    protected int $minimumValueLength = 12;

    /**
     * Before saving the value we call the validate func
     *
     * @param \Magento\Framework\DataObject $object
     * @return $this
     */
    public function beforeSave($object)
    {
        $this->validate($object);

        return parent::beforeSave($object);
    }

    /**
     * This function validates if the input is an Irish mobile number
     *
     * @param \Magento\Framework\DataObject $object
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validate($object)
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $value = $object->getData($attributeCode);
        $minimumValueLength = $this->getMinimumValueLength();

        if (!preg_match('/\+353\d{9}$/', $value)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The mobile number should start with +353 and have a total of %1 digits', $minimumValueLength)
            );
        }
        return true;
    }

    /**
     * Get minimum attribute value length
     *
     * @return int
     */
    public function getMinimumValueLength()
    {
        return $this->minimumValueLength;
    }
}
