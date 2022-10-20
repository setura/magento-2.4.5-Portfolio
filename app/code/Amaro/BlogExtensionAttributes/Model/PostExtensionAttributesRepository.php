<?php

declare(strict_types=1);

namespace Amaro\BlogExtensionAttributes\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Amaro\BlogExtensionAttributes\Api\Data\PostExtensionAttributesInterface;
use Amaro\BlogExtensionAttributes\Api\Data\PostExtensionAttributesInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterface;
use Amaro\BlogExtensionAttributes\Api\PostExtensionAttributesRepositoryInterface;
use Amaro\BlogExtensionAttributes\Model\ResourceModel\PostExtensionAttributes as ResourcePostExtensionAttributes;
use Amaro\BlogExtensionAttributes\Model\ResourceModel\PostExtensionAttributes\CollectionFactory
    as PostExtensionAttributesCollectionFactory;

/**
 * PostExtensionAttributesRepository Class
 */
class PostExtensionAttributesRepository implements PostExtensionAttributesRepositoryInterface
{
    /**
     * @var ResourcePostExtensionAttributes
     */
    private ResourcePostExtensionAttributes $resource;
    /**
     * @var PostExtensionAttributesInterfaceFactory
     */
    private PostExtensionAttributesInterfaceFactory $postExtensionAttributesFactory;
    /**
     * @var PostExtensionAttributesCollectionFactory
     */
    private PostExtensionAttributesCollectionFactory $postExtensionAttributesCollectionFactory;
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
     * @param ResourcePostExtensionAttributes $resource
     * @param PostExtensionAttributesInterfaceFactory $postExtensionAttributesFactory
     * @param PostExtensionAttributesCollectionFactory $postExtensionAttributesCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourcePostExtensionAttributes $resource,
        PostExtensionAttributesInterfaceFactory $postExtensionAttributesFactory,
        PostExtensionAttributesCollectionFactory $postExtensionAttributesCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->postExtensionAttributesFactory = $postExtensionAttributesFactory;
        $this->postExtensionAttributesCollectionFactory = $postExtensionAttributesCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Saves the Post extension attribute
     *
     * @param PostExtensionAttributesInterface $postExtensionAttributes
     * @return PostExtensionAttributesInterface
     * @throws CouldNotSaveException
     */
    public function save(
        PostExtensionAttributesInterface $postExtensionAttributes
    ) {
        try {
            $this->resource->save($postExtensionAttributes);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the postExtensionAttributes: %1',
                $exception->getMessage()
            ));
        }
        return $postExtensionAttributes;
    }

    /**
     * Get the postExtensionAttributes
     *
     * @param int $postExtensionAttributesId
     * @return PostExtensionAttributesInterface
     * @throws NoSuchEntityException
     */
    public function get($postExtensionAttributesId)
    {
        $postExtensionAttributes = $this->postExtensionAttributesFactory->create();
        $this->resource->load($postExtensionAttributes, $postExtensionAttributesId);
        if (!$postExtensionAttributes->getId()) {
            throw new NoSuchEntityException(
                __('PostExtensionAttributes with id "%1" does not exist.', $postExtensionAttributesId)
            );
        }
        return $postExtensionAttributes;
    }

    /**
     * Get list of post extension attributes
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->postExtensionAttributesCollectionFactory->create();

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
     * Delete the post extension attribute
     *
     * @param PostExtensionAttributesInterface $postExtensionAttributes
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(
        PostExtensionAttributesInterface $postExtensionAttributes
    ) {
        try {
            $postExtensionAttributesModel = $this->postExtensionAttributesFactory->create();
            $this->resource->load(
                $postExtensionAttributesModel,
                $postExtensionAttributes->getPostextensionattributesId()
            );
            $this->resource->delete($postExtensionAttributesModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the PostExtensionAttributes: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete the post extension attribute by ID
     *
     * @param int $postExtensionAttributesId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($postExtensionAttributesId)
    {
        return $this->delete($this->get($postExtensionAttributesId));
    }
}
