<?php

declare(strict_types=1);

namespace Amaro\BlogExtensionAttributes\Model;

use Magento\Framework\Model\AbstractModel;
use Amaro\BlogExtensionAttributes\Api\Data\PostExtensionAttributesInterface;
use Amaro\BlogExtensionAttributes\Model\ResourceModel\PostExtensionAttributes as PostResource;

/**
 * amaro_post extension attribute class
 */
class PostExtensionAttributes extends AbstractModel implements PostExtensionAttributesInterface
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
     * This function sets the post_Id of the post
     *
     * @param int $postId
     * @return void
     */
    public function setPostId($postId)
    {
        $this->setData('post_id', $postId);
    }

    /**
     * This function gets the post_Id
     *
     * @return int|null
     */
    public function getPostId()
    {
        $postId = $this->_getData('post_id');

        return $postId ? (int) $postId : null;
    }

    /**
     * This function sets the seo title of the post
     *
     * @param string|null $title
     * @return void
     */
    public function setSeoTitle(?string $title)
    {
        $this->setData('seo_title', $title);
    }

    /**
     * This function gets the seo title of the post
     *
     * @return string|void
     */
    public function getSeoTitle()
    {
        $this->_getData('seo_title');
    }

    /**
     * This function sets the seo description of the post
     *
     * @param string|null $description
     * @return void
     */
    public function setSeoDescription(?string $description)
    {
        $this->setData('seo_description', $description);
    }

    /**
     * This function gets the seo description of the post
     *
     * @return string|void
     */
    public function getSeoDescription()
    {
        $this->_getData('seo_description');
    }

    /**
     * This function sets the seo SeoKeyWords of the post
     *
     * @param string|null $keywords
     * @return void
     */
    public function setSeoKeyWords(?string $keywords)
    {
        $this->setData('seo_keywords', $keywords);
    }

    /**
     * This function gets the seo SeoKeyWords of the post
     *
     * @return string|void
     */
    public function getSeoKeyWords()
    {
        $this->_getData('seo_keywords');
    }
}
