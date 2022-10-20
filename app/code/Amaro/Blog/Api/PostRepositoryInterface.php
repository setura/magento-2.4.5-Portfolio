<?php

declare(strict_types=1);

namespace Amaro\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Amaro\Blog\Api\Data\PostInterface;
use \Magento\Framework\Api\SearchResultsInterface;

interface PostRepositoryInterface
{

    /**
     * Save post
     *
     * @param PostInterface $post
     * @return PostInterface
     * @throws LocalizedException
     */
    public function save(
        PostInterface $post
    );

    /**
     * Retrieve post
     *
     * @param string $postId
     * @return PostInterface
     * @throws LocalizedException
     */
    public function get($postId);

    /**
     * Retrieve post matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete post
     *
     * @param PostInterface $post
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        PostInterface $post
    );

    /**
     * Delete post by ID
     *
     * @param string $postId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($postId);
}
