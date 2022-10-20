<?php

declare(strict_types=1);

namespace Amaro\BlogAdminUi\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Amaro\BlogExtensionAttributes\Api\Data\PostExtensionAttributesInterface;
use Amaro\BlogExtensionAttributes\Api\PostExtensionAttributesRepositoryInterface;
use Amaro\Blog\Api\PostRepositoryInterface;
use Amaro\Blog\Api\Data\PostInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;

/**
 * Edit class
 */
class Edit extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;
    /**
     * @var PostInterface
     */
    private PostInterface $postInterface;
    /**
     * @var PostExtensionAttributesRepositoryInterface
     */
    private PostExtensionAttributesRepositoryInterface $postExtensionAttributesRepositoryInterface;
    /**
     * @var PostExtensionAttributesInterface
     */
    private PostExtensionAttributesInterface $postExtensionAttributesInterface;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $criteria;
    /**
     * @var SortOrderBuilder
     */
    private SortOrderBuilder $sortOrderBuilder;

    /**
     * Inject dependencies
     *
     * @param Context $context
     * @param PostInterface $postInterface
     * @param PostRepositoryInterface $postRepository
     * @param PostExtensionAttributesInterface $postExtensionAttributesInterface
     * @param PostExtensionAttributesRepositoryInterface $postExtensionAttributesRepositoryInterface
     * @param SearchCriteriaBuilder $criteria
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Context $context,
        PostInterface $postInterface,
        PostRepositoryInterface $postRepository,
        PostExtensionAttributesInterface $postExtensionAttributesInterface,
        PostExtensionAttributesRepositoryInterface $postExtensionAttributesRepositoryInterface,
        SearchCriteriaBuilder $criteria,
        SortOrderBuilder $sortOrderBuilder
    ) {
        parent::__construct($context);

        $this->postInterface = $postInterface;
        $this->postRepository = $postRepository;
        $this->postExtensionAttributesInterface = $postExtensionAttributesInterface;
        $this->postExtensionAttributesRepositoryInterface = $postExtensionAttributesRepositoryInterface;
        $this->criteria = $criteria;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * Create and Edit the post
     *
     * @return Redirect
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
        $resultRedirect = $this->resultRedirectFactory->create();

        $postData = $this->getRequest()->getParam('post');

        if (!is_array($postData)) {
            return;
        }

        if (!isset($postData['entity_id'])) {
            $this->createPost($postData);
            return $resultRedirect->setPath('*/*/index');
        }

        $this->updatePost($postData);
        return $resultRedirect->setPath('*/*/index');
    }

    /**
     * Creates the post
     *
     * @param array $postData
     * @return void
     */
    public function createPost(array $postData)
    {
        try {
            $this->setPostContent($postData);
            $this->postRepository->save($this->postInterface);
            $this->updateExtensionAttributes($postData);
            $this->messageManager->addSuccessMessage(__('The post has been created!'));
        } catch (Exception $e) {
            $this->messageManager->addWarningMessage(__('The post couldn\'t be created !'));
        }
    }

    /**
     * Edits the post
     *
     * @param array $postData
     * @return void
     */
    public function updatePost(array $postData)
    {
        try {
            $this->setPostContent($postData);
            $this->postInterface->setId($postData['entity_id']);
            $this->postRepository->save($this->postInterface);
            $this->updateExtensionAttributes($postData);
            $this->messageManager->addSuccessMessage(__('The post has been updated!'));
        } catch (Exception $e) {
            $this->messageManager->addWarningMessage(__('The post couldn\'t be updated !'));
        }
    }

    /**
     * Saves the extensions attributes of the post
     *
     * @param array $postData
     * @return void
     * @throws LocalizedException
     */
    public function updateExtensionAttributes(array $postData)
    {
        if (!isset($postData['entity_id'])) {
            $sortOrder = $this->sortOrderBuilder->setField('entity_id')->setDirection('DESC')->create();
            $searchCriteria = $this->criteria
                ->setSortOrders([$sortOrder])
                ->setPageSize(1)
                ->setCurrentPage(1)
                ->create();
            $item = current($this->postRepository->getList($searchCriteria)->getItems());
            $this->postExtensionAttributesInterface->setPostId((int)$item['entity_id']);
        } else {
            $this->postExtensionAttributesInterface->setPostId((int)$postData['entity_id']);
        }

        $this->postExtensionAttributesInterface->setSeoTitle($postData['seo_title']);
        $this->postExtensionAttributesInterface->setSeoDescription($postData['seo_description']);
        $this->postExtensionAttributesInterface->setSeoKeyWords($postData['seo_keywords']);
        $this->postExtensionAttributesRepositoryInterface->save($this->postExtensionAttributesInterface);
    }

    /**
     * Sets the title and content of the post
     *
     * @param array $postData
     * @return void
     */
    public function setPostContent(array $postData)
    {
        $this->postInterface->setTitle($postData['title']);
        $this->postInterface->setContent($postData['content']);
        $this->postInterface->setCreatedAt(date("Y-m-d H:i:s"));
    }
}
