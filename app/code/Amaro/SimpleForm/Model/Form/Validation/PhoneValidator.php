<?php

declare(strict_types=1);

namespace Amaro\SimpleForm\Model\Form\Validation;

use Magento\Framework\Exception\LocalizedException;
use Amaro\SimpleForm\Api\ValidatorInterface;
use Amaro\SimpleForm\Api\ValidatorResultInterface;
use Amaro\SimpleForm\Api\ValidatorResultInterfaceFactory;

/**
 * Class PhoneValidator
 */
class PhoneValidator implements ValidatorInterface
{
    /**
     * @var ValidatorResultInterfaceFactory
     */
    private ValidatorResultInterfaceFactory $validatorResultFactory;
    /**
     * @var array
     */
    private array $validationRules;

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
            if (!isset($data[$field])) {
                continue;
            }
            try {
                $this->validatePhone($data[$field]);
            } catch (LocalizedException $e) {
                $validatorResult->addMessage($e->getMessage());
            }
        }

        return $validatorResult;
    }

    /**
     * Validate Phone
     *
     * @param string $value
     * @return void
     * @throws LocalizedException
     */
    private function validatePhone(string $value)
    {
        if (!preg_match('/\+\d+$/', $value)) {
            throw new LocalizedException(
                __('Your phone need to start with the \'+\' symbol and have only numbers following.')
            );
        }
    }
}
