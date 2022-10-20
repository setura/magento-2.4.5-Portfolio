<?php

declare(strict_types=1);

namespace Amaro\Notifications\Model\ResourceModel\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Amaro\Notifications\Model\Notification;
use Amaro\Notifications\Model\ResourceModel\Notification as NotificationResource;

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
            Notification::class,
            NotificationResource::class
        );
    }
}
