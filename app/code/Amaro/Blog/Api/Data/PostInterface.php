<?php

declare(strict_types=1);

namespace Amaro\Blog\Api\Data;

/**
 * This is the amaro_post extension attribute interface
 */
interface PostInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * This function sets the post_Id of the post
     *
     * @param int $id
     * @return void
     */
    public function setId(int $id);

    /**
     * This function gets the post_Id of the post
     *
     * @return mixed
     */
    public function getId();

    /**
     * This function sets the date of the post
     *
     * @param string|null $createdAt
     * @return void
     */
    public function setCreatedAt(?string $createdAt);

    /**
     * This function gets the date of the post
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * This function sets the title of the post
     *
     * @param string|null $title
     * @return void
     */
    public function setTitle(?string $title);

    /**
     * This function gets the title of the post
     *
     * @return string
     */
    public function getTitle();

    /**
     * This function sets the content of the post
     *
     * @param string|null $content
     * @return void
     */
    public function setContent(?string $content);

    /**
     * This function gets the content of the post
     *
     * @return string
     */
    public function getContent();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Amaro\Blog\Api\Data\PostExtensionInterface
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Amaro\Blog\Api\Data\PostExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Amaro\Blog\Api\Data\PostExtensionInterface $extensionAttributes);
}
