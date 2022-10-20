<?php

declare(strict_types=1);

namespace Amaro\BlogAdminUi\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Add post action
 */
class NewAction extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var ForwardFactory
     */
    private ForwardFactory $forwardFactory;

    /**
     * Inject dependencies
     *
     * @param Context $context
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $forwardFactory
    ) {
        parent::__construct($context);

        $this->forwardFactory = $forwardFactory;
    }

    /**
     * Create post
     *
     * @return Forward
     */
    public function execute()
    {
        $resultForward = $this->forwardFactory->create();
        return $resultForward->forward('edit');
    }
}
