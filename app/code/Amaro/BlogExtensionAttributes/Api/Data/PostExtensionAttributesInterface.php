<?php

declare(strict_types=1);

namespace Amaro\BlogExtensionAttributes\Api\Data;

/**
 * amaro_post extension attribute class
 */
interface PostExtensionAttributesInterface
{
    /**
     * This function sets the post_Id of the post
     *
     * @param int $postId
     * @return void
     */
    public function setPostId($postId);

    /**
     * This function gets the post_Id
     *
     * @return int|null
     */
    public function getPostId();

    /**
     * This function sets the seo title of the post
     *
     * @param string|null $title
     * @return void
     */
    public function setSeoTitle(?string $title);

    /**
     * This function gets the seo title of the post
     *
     * @return string|void
     */
    public function getSeoTitle();

    /**
     * This function sets the seo description of the post
     *
     * @param string|null $description
     * @return void
     */
    public function setSeoDescription(?string $description);

    /**
     * This function gets the seo description of the post
     *
     * @return string|void
     */
    public function getSeoDescription();

    /**
     * This function sets the seo SeoKeyWords of the post
     *
     * @param string|null $keywords
     * @return void
     */
    public function setSeoKeyWords(?string $keywords);

    /**
     * This function gets the seo SeoKeyWords of the post
     *
     * @return string|void
     */
    public function getSeoKeyWords();
}
