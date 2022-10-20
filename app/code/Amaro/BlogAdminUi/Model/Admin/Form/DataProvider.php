<?php

declare(strict_types=1);

namespace Amaro\BlogAdminUi\Model\Admin\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Amaro\Blog\Model\ResourceModel\Post\Grid\CollectionFactory;

/**
 * Provides data to the form field
 */
class DataProvider extends AbstractDataProvider
{

    /**
     * @var array
     */
    private array $loadedData;

    /**
     * Inject dependencies
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $postCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $postCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Provides data to the form field when editing.
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $this->joinExtensionAttributesData();
        $items = $this->collection->getItems();
        $this->loadedData = [];

        foreach ($items as $post) {
            $this->loadedData[$post->getId()]['post'] = $post->getData();
        }

        return $this->loadedData;
    }

    /**
     * Join left the main table with the extension attributes table
     *
     * @return void
     */
    private function joinExtensionAttributesData()
    {
        $this->collection->getSelect()
            ->joinLeft(
                ['ba'=>'amaro_blog_posts_extension_attributes'],
                "ba.post_id = main_table.entity_id",
                [
                    'seo_title' => 'ba.seo_title',
                    'seo_description' => 'ba.seo_description',
                    'seo_keywords' => 'ba.seo_keywords',
                ]
            );
    }
}
