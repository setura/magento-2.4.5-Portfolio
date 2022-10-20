<?php

declare(strict_types=1);

namespace Amaro\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Post resource model
 */
class Post extends AbstractDb
{
    /**
     * Inject dependencies
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('amaro_blog_post', 'entity_id');
    }
}
