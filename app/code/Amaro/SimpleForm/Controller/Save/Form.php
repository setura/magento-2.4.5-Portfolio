<?php

declare(strict_types=1);

namespace Amaro\SimpleForm\Controller\Save;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Amaro\SimpleForm\Model\Form\ValidatorPool;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Psr\Log\LoggerInterface;

/**
 * Form Controller
 */
class Form implements HttpPostActionInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var ValidatorPool
     */
    private ValidatorPool $validatorPool;
    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $resultRedirectFactory;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var UrlInterface
     */
    private UrlInterface $url;

    /**
     * Inject Dependencies
     *
     * @param RequestInterface $request
     * @param ValidatorPool $validatorPool
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $resultRedirectFactory
     * @param LoggerInterface $logger
     * @param UrlInterface $url
     */
    public function __construct(
        RequestInterface $request,
        ValidatorPool $validatorPool,
        ManagerInterface $messageManager,
        RedirectFactory $resultRedirectFactory,
        LoggerInterface $logger,
        UrlInterface $url
    ) {
        $this->request = $request;
        $this->validatorPool = $validatorPool;
        $this->messageManager = $messageManager;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->logger = $logger;
        $this->url = $url;
    }

    /**
     * Execute action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $post = $this->request->getParams();

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($this->url->getUrl('*/index/form', ['_secure' => true]));

        try {
            $validatorResult = $this->validatorPool->validate($post);
            if ($validatorResult->hasMessages()) {
                foreach ($validatorResult->getMessages() as $message) {
                    $this->messageManager->addWarningMessage(__($message));
                }
            } else {
                $this->messageManager->addSuccessMessage(__("Successfully submitted."));
            }
        } catch (LocalizedException $e) {
            $this->logger->error("An error occurred while validating the simpleform/save/form");
            $this->messageManager->addErrorMessage(__('There was an unexpected error while validating the form.'));
        }

        return $resultRedirect;
    }
}
