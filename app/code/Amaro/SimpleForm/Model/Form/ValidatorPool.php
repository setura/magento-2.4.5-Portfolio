<?php

declare(strict_types=1);

namespace Amaro\SimpleForm\Model\Form;

use Magento\Framework\Exception\ConfigurationMismatchException;
use Amaro\SimpleForm\Api\ValidatorInterface;
use Amaro\SimpleForm\Api\ValidatorResultInterface;
use Amaro\SimpleForm\Api\ValidatorResultInterfaceFactory;
use Psr\Log\LoggerInterface;

/**
 * Requested shipment items validation interface
 */
class ValidatorPool implements ValidatorInterface
{
    /**
     * @var \Amaro\SimpleForm\Api\ValidatorInterface[]
     */
    private array $validators;
    /**
     * @var ValidatorResultInterfaceFactory
     */
    private ValidatorResultInterfaceFactory $validatorResultFactory;
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Inject dependencies
     *
     * @param ValidatorResultInterfaceFactory $validatorResultFactory
     * @param LoggerInterface $logger
     * @param \Amaro\SimpleForm\Api\ValidatorInterface[] $validators
     */
    public function __construct(
        ValidatorResultInterfaceFactory $validatorResultFactory,
        LoggerInterface $logger,
        array $validators = []
    ) {
        $this->validatorResultFactory = $validatorResultFactory;
        $this->validators = $validators;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function validate(array $items): ValidatorResultInterface
    {
        $messages = [];

        foreach ($this->validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new ConfigurationMismatchException(
                    __(
                        'The "%1" validator is not an instance of the general validator interface.',
                        get_class($validator)
                    )
                );
            }
            $validatorStackMessages = $validator->validate($items)->getMessages();
            foreach ($validatorStackMessages as $message) {
                $messages[] = $message;
            }
        }

        return $this->validatorResultFactory->create(['messages' => $messages]);
    }
}
