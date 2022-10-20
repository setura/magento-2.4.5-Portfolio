<?php

declare(strict_types=1);

namespace Amaro\PriceBook\Model\ResourceModel\PriceBook;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Amaro\PriceBook\Model\PriceBook;
use Amaro\PriceBook\Model\ResourceModel\PriceBook as PriceBookResource;

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
            PriceBook::class,
            PriceBookResource::class
        );
    }
}
