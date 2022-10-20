<?php

declare(strict_types=1);

namespace Amaro\Blog\Model\ResourceModel\Post\Grid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Amaro\Blog\Model\Post;
use Amaro\Blog\Model\ResourceModel\Post as PostResource;

/**
 * Collection class
 */
class Collection extends AbstractCollection
{
    /**
     * Inject dependencies
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init(
            Post::class,
            PostResource::class
        );
    }
}
