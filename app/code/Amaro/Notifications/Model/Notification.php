<?php

declare(strict_types=1);

namespace Amaro\Notifications\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Amaro\Notifications\Api\Data\NotificationInterface;
use Amaro\Notifications\Model\ResourceModel\Notification as PostResource;

/**
 * amaro_blog_post model class
 */
class Notification extends AbstractExtensibleModel implements NotificationInterface
{
    /**
     * Inject dependencies
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(PostResource::class);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId(int $id)
    {
        $this->setData(self::CUSTOMER_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId(): int
    {
        return (int) $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setMessage(string $message)
    {
        $this->setData(self::MESSAGE, $message);
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        return $this->_getData(self::MESSAGE);
    }
}
