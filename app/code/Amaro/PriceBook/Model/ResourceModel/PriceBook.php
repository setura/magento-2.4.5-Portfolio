<?php

declare(strict_types=1);

namespace Amaro\PriceBook\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * PriceBook resource model
 */
class PriceBook extends AbstractDb
{
    /**
     * Inject dependencies
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('amaro_product_pricebook', 'row_id');
    }
}
