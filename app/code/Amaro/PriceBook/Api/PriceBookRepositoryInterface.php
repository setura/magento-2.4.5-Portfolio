<?php

declare(strict_types=1);

namespace Amaro\PriceBook\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Amaro\PriceBook\Api\Data\PriceBookInterface;
use Magento\Framework\Api\SearchResultsInterface;
use \Exception;

interface PriceBookRepositoryInterface
{

    /**
     * Save priceBook
     *
     * @param PriceBookInterface $priceBook
     * @return PriceBookInterface
     * @throws LocalizedException
     */
    public function save(
        PriceBookInterface $priceBook
    );

    /**
     * Retrieve priceBook
     *
     * @param int $priceBookId
     * @return PriceBookInterface
     * @throws LocalizedException
     */
    public function get($priceBookId);

    /**
     * Retrieve priceBook by Sku
     *
     * @param string $sku
     * @return PriceBookInterface[]
     * @throws LocalizedException
     */
    public function getBySku($sku);

    /**
     * Retrieve priceBook matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete priceBook
     *
     * @param PriceBookInterface $priceBook
     * @return bool
     * @throws StateException
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function delete(PriceBookInterface $priceBook);

    /**
     * Delete pricebook by ID
     *
     * @param int $priceBookId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $priceBookId);
}
