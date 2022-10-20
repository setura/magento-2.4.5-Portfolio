<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateQuote\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Order resource
 */
class Quote extends AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('quote', 'entity_id');
    }

    /**
     * Save delivery date on database
     *
     * @param int $quoteId
     * @param string $deliveryDate
     * @return void
     */
    public function saveDeliveryDate(int $quoteId, string $deliveryDate): void
    {
        $this->getConnection()->update(
            $this->getTable('quote'),
            ['delivery_date' => $deliveryDate],
            ['entity_id = ?' => $quoteId]
        );
    }

    /**
     * Get delivery date from database
     *
     * @param int $quoteId
     * @return string|null
     */
    public function getDeliveryDate(int $quoteId): ?string
    {
        $select = $this->getConnection()->select()
            ->from(['sales_order' => $this->getTable('quote')], ['delivery_date'])
            ->where('entity_id = ?', $quoteId);

        return $this->getConnection()->fetchCol($select)[0];
    }
}
