<?php

declare(strict_types=1);

namespace Amaro\BlogExtensionAttributes\Model\ResourceModel\PostExtensionAttributes;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Amaro\BlogExtensionAttributes\Model\PostExtensionAttributes;
use Amaro\BlogExtensionAttributes\Model\ResourceModel\PostExtensionAttributes as PostExtensionAttributesResource;

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
            PostExtensionAttributes::class,
            PostExtensionAttributesResource::class
        );
    }
}
