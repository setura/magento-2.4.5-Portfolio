<?php

declare(strict_types=1);

namespace Amaro\SimpleForm\Model\Form\Validation;

use Magento\Framework\Exception\LocalizedException;
use Amaro\SimpleForm\Api\ValidatorInterface;
use Amaro\SimpleForm\Api\ValidatorResultInterfaceFactory;
use Amaro\SimpleForm\Api\ValidatorResultInterface;

/**
 * Class LengthValidator
 */
class LengthValidator implements ValidatorInterface
{
    /**
     * @var ValidatorResultInterfaceFactory
     */
    private ValidatorResultInterfaceFactory $validatorResultInterfaceFactory;
    /**
     * @var array
     */
    private array $validationRules;

    /**
     * Inject dependencies
     *
     * @param ValidatorResultInterfaceFactory $validatorResultInterfaceFactory
     * @param array $validationRules
     */
    public function __construct(
        ValidatorResultInterfaceFactory $validatorResultInterfaceFactory,
        array $validationRules = []
    ) {
        $this->validatorResultInterfaceFactory = $validatorResultInterfaceFactory;
        $this->validationRules = $validationRules;
    }

    /**
     * @inheritdoc
     */
    public function validate(array $data) : ValidatorResultInterface
    {
        $validatorResult = $this->validatorResultInterfaceFactory->create();

        foreach ($this->validationRules as $fieldName => $rule) {
            if (!isset($data[$fieldName])) {
                continue;
            }

            if (!$this->validateLength($data[$fieldName], $rule)) {
                $validatorResult->addMessage(__('Invalid field %1 length', $fieldName));
            }
        }

        return $validatorResult;
    }

    /**
     * Validate length of the fields, returns true if the value is acceptable.
     *
     * @param string $value
     * @param array $fieldConfiguration
     * @return bool
     */
    private function validateLength(string $value, array $fieldConfiguration): bool
    {
        return !(
            (isset($fieldConfiguration['max']) && strlen($value) > (int)$fieldConfiguration['max']) ||
            (isset($fieldConfiguration['min']) && strlen($value) < (int)$fieldConfiguration['min'])
        );
    }
}
