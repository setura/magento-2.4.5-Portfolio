<?php

declare(strict_types=1);

namespace Amaro\Blog\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Amaro\Blog\Api\Data\PostInterface;
use Amaro\Blog\Model\ResourceModel\Post as PostResource;

/**
 * amaro_blog_post model class
 */
class Post extends AbstractExtensibleModel implements PostInterface
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
     * This function sets the date of the post
     *
     * @param string|null $createdAt
     * @return void
     */
    public function setCreatedAt(?string $createdAt)
    {
        $this->setData('created_at', $createdAt);
    }

    /**
     * This function gets the date of the post
     *
     * @return mixed|string|null
     */
    public function getCreatedAt()
    {
        return $this->_getData('created_at');
    }

    /**
     * This function sets the title of the post
     *
     * @param string|null $title
     * @return void
     */
    public function setTitle(?string $title)
    {
        $this->setData('title', $title);
    }

    /**
     * This function gets the title of the post
     *
     * @return string|void
     */
    public function getTitle()
    {
        $this->_getData('title');
    }

    /**
     * This function sets the content of the post
     *
     * @param string|null $content
     * @return void
     */
    public function setContent(?string $content)
    {
        $this->setData('content', $content);
    }

    /**
     * This function gets the content of the post
     *
     * @return string|void
     */
    public function getContent()
    {
        $this->_getData('content');
    }

    /**
     * @inheritDoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(\Amaro\Blog\Api\Data\PostExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
