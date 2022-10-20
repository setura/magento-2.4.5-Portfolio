<?php

declare(strict_types=1);

namespace Amaro\BlogAdminUi\Controller\Adminhtml\Index;

use Magento\Framework\Controller\Result\Redirect;
use Amaro\Blog\Api\PostRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use \Exception;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpDeleteActionInterface;

/**
 * Delete action
 */
class Delete extends Action implements HttpGetActionInterface, HttpDeleteActionInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;

    /**
     * Inject dependencies
     *
     * @param PostRepositoryInterface $postRepository
     * @param Context $context
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        Context $context
    ) {
        parent::__construct($context);
        $this->postRepository = $postRepository;
    }

    /**
     * This function deletes the post
     *
     * @return Redirect
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');

        if (!($this->postRepository->get($id))) {
            $this->messageManager->addError(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }
        try {
            $this->postRepository->deleteById($id);
            $this->messageManager->addSuccess(__('Your post has been deleted !'));
        } catch (Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete post: '));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
