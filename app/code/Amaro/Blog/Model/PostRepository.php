<?php

declare(strict_types=1);

namespace Amaro\Blog\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Amaro\Blog\Api\Data\PostInterface;
use Amaro\Blog\Api\Data\PostInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Amaro\Blog\Api\PostRepositoryInterface;
use Amaro\Blog\Model\ResourceModel\Post as ResourcePost;
use Amaro\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * PostRepository class
 */
class PostRepository implements PostRepositoryInterface
{

    /**
     * @var ResourcePost
     */
    private ResourcePost $resource;
    /**
     * @var PostInterfaceFactory
     */
    private PostInterfaceFactory $postFactory;
    /**
     * @var PostCollectionFactory
     */
    private PostCollectionFactory $postCollectionFactory;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private SearchResultsInterfaceFactory $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * Inject dependencies
     *
     * @param ResourcePost $resource
     * @param PostInterfaceFactory $postFactory
     * @param PostCollectionFactory $postCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourcePost $resource,
        PostInterfaceFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save the post
     *
     * @param PostInterface $post
     * @return PostInterface
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post)
    {
        try {
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the post: %1',
                $exception->getMessage()
            ));
        }
        return $post;
    }

    /**
     * Get post by ID
     *
     * @param int $postId
     * @return PostInterface
     * @throws NoSuchEntityException
     */
    public function get($postId)
    {
        $post = $this->postFactory->create();
        $this->resource->load($post, $postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('post with id "%1" does not exist.', $postId));
        }
        return $post;
    }

    /**
     * Get list of posts based on search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->postCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Post
     *
     * @param PostInterface $post
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PostInterface $post)
    {
        try {
            $postModel = $this->postFactory->create();
            $this->resource->load($postModel, $post->getId());
            $this->resource->delete($postModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the post: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete post by ID
     *
     * @param int $postId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($postId)
    {
        return $this->delete($this->get($postId));
    }
}
