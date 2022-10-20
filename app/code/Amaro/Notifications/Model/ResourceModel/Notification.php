<?php

declare(strict_types=1);

namespace Amaro\Notifications\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Post resource model
 */
class Notification extends AbstractDb
{
    /**
     * Inject dependencies
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('amaro_notifications', 'notification_id');
    }
}
