<?php

declare(strict_types=1);

namespace Amaro\SimpleForm\Model\Form\Validation;

use Magento\Framework\Exception\LocalizedException;
use Amaro\SimpleForm\Api\ValidatorInterface;
use Amaro\SimpleForm\Api\ValidatorResultInterface;
use Amaro\SimpleForm\Api\ValidatorResultInterfaceFactory;

/**
 * Class RequiredFieldsValidator
 */
class RequiredFieldsValidator implements ValidatorInterface
{
    /**
     * @var ValidatorResultInterfaceFactory
     */
    protected ValidatorResultInterfaceFactory $validatorResultFactory;
    /**
     * @var array
     */
    protected array $validationRules;

    /**
     * Inject dependencies
     *
     * @param ValidatorResultInterfaceFactory $validatorResultFactory
     * @param array $validationRules
     */
    public function __construct(
        ValidatorResultInterfaceFactory $validatorResultFactory,
        array $validationRules = []
    ) {
        $this->validatorResultFactory = $validatorResultFactory;
        $this->validationRules = $validationRules;
    }

    /**
     * @inheritdoc
     */
    public function validate(array $data) : ValidatorResultInterface
    {
        $validatorResult = $this->validatorResultFactory->create();

        foreach ($this->validationRules as $field) {
            try {
                $this->validateRequiredField($field, $data[$field]);
            } catch (LocalizedException $e) {
                $validatorResult->addMessage($e->getMessage());
            }
        }

        return $validatorResult;
    }

    /**
     * Validate required fields
     *
     * @param string $field
     * @param string $value
     * @return void
     * @throws LocalizedException
     */
    private function validateRequiredField(string $field, string $value)
    {
        if (empty($value)) {
            throw new LocalizedException(__('The field %1 is required.', $field));
        }
    }
}
