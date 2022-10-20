<?php

declare(strict_types=1);

namespace Amaro\BlogExtensionAttributes\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Post resource model
 */
class PostExtensionAttributes extends AbstractDb
{
    /**
     * Inject dependencies
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('amaro_blog_posts_extension_attributes', 'post_id');
        $this->_isPkAutoIncrement = false;
    }
}
