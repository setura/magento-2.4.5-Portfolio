<?php

declare(strict_types=1);

namespace Amaro\DeliveryDateSales\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Order resource
 */
class Order extends AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('sales_order', 'entity_id');
    }

    /**
     * Save delivery date on database
     *
     * @param int $orderId
     * @param string $deliveryDate
     * @return void
     */
    public function saveDeliveryDate(int $orderId, string $deliveryDate): void
    {
        $this->getConnection()->update(
            $this->getTable('sales_order'),
            ['delivery_date' => $deliveryDate],
            ['entity_id = ?' => $orderId]
        );
    }

    /**
     * Get delivery date from database
     *
     * @param int $orderId
     * @return string|null
     */
    public function getDeliveryDate(int $orderId): ?string
    {
        $select = $this->getConnection()->select()
            ->from(['sales_order' => $this->getTable('sales_order')], ['delivery_date'])
            ->where('entity_id = ?', $orderId);

        return $this->getConnection()->fetchCol($select)[0];
    }
}
