<?php

declare(strict_types=1);

namespace Amaro\BlogExtensionAttributes\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Amaro\BlogExtensionAttributes\Api\Data\PostExtensionAttributesInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface PostExtensionAttributesRepositoryInterface
{

    /**
     * Save PostExtensionAttributes
     *
     * @param PostExtensionAttributesInterface $postExtensionAttributes
     * @return PostExtensionAttributesInterface
     * @throws LocalizedException
     */
    public function save(
        PostExtensionAttributesInterface $postExtensionAttributes
    );

    /**
     * Retrieve PostExtensionAttributes
     *
     * @param string $postextensionattributesId
     * @return PostExtensionAttributesInterface
     * @throws LocalizedException
     */
    public function get($postextensionattributesId);

    /**
     * Retrieve PostExtensionAttributes matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete PostExtensionAttributes
     *
     * @param PostExtensionAttributesInterface $postExtensionAttributes
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        PostExtensionAttributesInterface $postExtensionAttributes
    );

    /**
     * Delete PostExtensionAttributes by ID
     *
     * @param string $postextensionattributesId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($postextensionattributesId);
}
