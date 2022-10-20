<?php

declare(strict_types=1);

namespace Amaro\BlogFrontendUi\ViewModel;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Amaro\Blog\Api\PostRepositoryInterface;

/**
 * BlogPosts Class
 */
class BlogPosts implements ArgumentInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $criteria;

    /**
     * Inject dependencies
     *
     * @param PostRepositoryInterface $postRepository
     * @param SearchCriteriaBuilder $criteria
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        SearchCriteriaBuilder $criteria
    ) {
        $this->postRepository = $postRepository;
        $this->criteria = $criteria;
    }

    /**
     * This function gets all the posts
     *
     * @return array
     */
    public function getAllPosts(): array
    {

        $filter = $this->criteria->create();

        return $this->postRepository->getList($filter)->getItems() ;
    }
}
