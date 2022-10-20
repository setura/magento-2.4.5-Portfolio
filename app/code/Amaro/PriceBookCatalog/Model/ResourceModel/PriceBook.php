<?php

declare(strict_types=1);

namespace Amaro\PriceBookCatalog\Model\ResourceModel;

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

    /**
     * Get the pricebook based on the product ID
     *
     * @param int $productId
     * @return array
     */
    public function getPriceBookByProductId(int $productId)
    {
        $connection = $this->getConnection();

        $select = $connection->select()
            ->from(['pricebook' => $this->getMainTable()], ['price_book_code'])
            ->joinRight(
                ['product' => $this->getTable('catalog_product_entity')],
                'product.sku = pricebook.sku'
            )->where('product.entity_id = ?', (string)$productId);

        return array_values($connection->fetchCol($select));
    }
}
