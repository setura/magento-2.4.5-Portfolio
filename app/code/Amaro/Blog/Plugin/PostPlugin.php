<?php

declare(strict_types=1);

namespace Amaro\Blog\Plugin;

use Exception;
use Amaro\Blog\Api\PostRepositoryInterface;
use Amaro\BlogExtensionAttributes\Api\PostExtensionAttributesRepositoryInterface;
use Amaro\Blog\Api\Data\PostInterface;
use Magento\Framework\Api\SearchResults;

/**
 * This Plugin is responsible to populate the customer entity with the extension attributes.
 */
class PostPlugin
{
    /**
     * @var PostExtensionAttributesRepositoryInterface
     */
    private PostExtensionAttributesRepositoryInterface $postExtensionAttributesRepository;

    /**
     * Inject dependencies
     *
     * @param PostExtensionAttributesRepositoryInterface $postExtensionAttributesRepository
     */
    public function __construct(PostExtensionAttributesRepositoryInterface $postExtensionAttributesRepository)
    {
        $this->postExtensionAttributesRepository = $postExtensionAttributesRepository;
    }

    /**
     * Intercepts the get customer and populates his extension attributes
     *
     * @param PostRepositoryInterface $subject
     * @param PostInterface $result
     * @return PostInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(PostRepositoryInterface $subject, PostInterface $result)
    {
        try {
            $extensionAttributesData = $this->postExtensionAttributesRepository->get((int)$result->getId());
        } catch (Exception $exception) {
            return $result;
        }

        $extensionAttributes = $result->getExtensionAttributes();
        if (null == $extensionAttributes->getAmaroBlogPostExtensionAttributes()) {
            $extensionAttributes->setAmaroBlogPostExtensionAttributes($extensionAttributesData);
        }
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    /**
     * When retrieving customers which match a specified criteria we load the extension attributes into each customer.
     *
     * @param PostRepositoryInterface $subject
     * @param SearchResults $result
     * @return SearchResults
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetList(
        PostRepositoryInterface $subject,
        SearchResults $result
    ) {
        $posts = [];
        foreach ($result->getItems() as $entity) {
            $posts[] = $this->afterGet($subject, $entity);
        }
        $result->setItems($posts);
        return $result;
    }

    /**
     * When retrieving customers which match a specified criteria we load the extension attributes into each customer.
     *
     * @param PostRepositoryInterface $subject
     * @param PostInterface $result
     * @return PostInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(PostRepositoryInterface $subject, PostInterface $result)
    {
        $extensionAttributes = $result->getExtensionAttributes();
        if (null != $extensionAttributes->getAmaroBlogPostExtensionAttributes()) {
            $amaroBlogPostExtensionAttributes = $extensionAttributes->getAmaroBlogPostExtensionAttributes();
            $this->postExtensionAttributesRepository->save($amaroBlogPostExtensionAttributes);
        }
        return $result;
    }
}
