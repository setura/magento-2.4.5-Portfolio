<?php

declare(strict_types=1);

namespace Amaro\PriceBook\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Amaro\PriceBook\Api\Data\PriceBookInterface;
use Amaro\PriceBook\Model\ResourceModel\PriceBook as PriceBookResource;

/**
 * PriceBook model class
 */
class PriceBook extends AbstractExtensibleModel implements PriceBookInterface
{
    /**
     * Inject dependencies
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(PriceBookResource::class);
    }

    /**
     * @inheritDoc
     */
    public function setSku(?string $sku)
    {
        $this->setData(self::SKU, $sku);
    }

    /**
     * @inheritDoc
     */
    public function getSku()
    {
        return $this->_getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function setPriceBookCode(?string $priceBookCode)
    {
        $this->setData(self::PRICE_BOOK_CODE, $priceBookCode);
    }

    /**
     * @inheritDoc
     */
    public function getPriceBookCode()
    {
        return $this->_getData(self::PRICE_BOOK_CODE);
    }
}
