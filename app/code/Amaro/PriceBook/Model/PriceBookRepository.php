<?php

declare(strict_types=1);

namespace Amaro\PriceBook\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Amaro\PriceBook\Api\Data\PriceBookInterface;
use Amaro\PriceBook\Api\Data\PriceBookInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Amaro\PriceBook\Api\PriceBookRepositoryInterface;
use Amaro\PriceBook\Model\ResourceModel\PriceBook as ResourcePriceBook;
use Amaro\PriceBook\Model\ResourceModel\PriceBook\CollectionFactory as PriceBookCollectionFactory;

/**
 * PriceBookRepository class
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PriceBookRepository implements PriceBookRepositoryInterface
{
    /**
     * @var ResourcePriceBook
     */
    private ResourcePriceBook $resource;
    /**
     * @var PriceBookInterfaceFactory
     */
    private PriceBookInterfaceFactory $priceBookFactory;
    /**
     * @var PriceBookCollectionFactory
     */
    private PriceBookCollectionFactory $priceBookCollectionFactory;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private SearchResultsInterfaceFactory $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * Inject dependencies
     *
     * @param ResourcePriceBook $resource
     * @param PriceBookInterfaceFactory $priceBookFactory
     * @param PriceBookCollectionFactory $priceBookCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ResourcePriceBook $resource,
        PriceBookInterfaceFactory $priceBookFactory,
        PriceBookCollectionFactory $priceBookCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resource = $resource;
        $this->priceBookFactory = $priceBookFactory;
        $this->priceBookCollectionFactory = $priceBookCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Save the priceBook
     *
     * @param PriceBookInterface $priceBook
     * @return PriceBookInterface
     * @throws CouldNotSaveException
     */
    public function save(PriceBookInterface $priceBook)
    {
        try {
            $this->resource->save($priceBook);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the priceBook: %1',
                $exception->getMessage()
            ));
        }
        return $priceBook;
    }

    /**
     * Get priceBook by ID
     *
     * @param int $priceBookId
     * @return PriceBookInterface
     * @throws NoSuchEntityException
     */
    public function get($priceBookId)
    {
        $priceBook = $this->priceBookFactory->create();
        $this->resource->load($priceBook, $priceBookId);
        if (!$priceBook->getId()) {
            throw new NoSuchEntityException(__('priceBook with id "%1" does not exist.', $priceBookId));
        }
        return $priceBook;
    }

    /**
     * Get list of priceBooks based on search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->priceBookCollectionFactory->create();

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
     * Delete PriceBook
     *
     * @param PriceBookInterface $priceBook
     * @return bool
     * @throws StateException
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function delete(PriceBookInterface $priceBook)
    {
        $this->resource->delete($priceBook);
        return true;
    }

    /**
     * Delete priceBook by ID
     *
     * @param int $priceBookId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $priceBookId)
    {
        return $this->delete($this->get($priceBookId));
    }

    /**
     * @inheritDoc
     */
    public function getBySku($sku)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(
                PriceBookInterface::SKU,
                $sku,
                'eq'
            )->create();

        return $this->getList($searchCriteria)->getItems();
    }
}
