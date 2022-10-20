<?php

declare(strict_types=1);

namespace Amaro\PriceBook\Api\Data;

/**
 * PriceBookInterface
 */
interface PriceBookInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Sku attribute
     */
    public const SKU = 'sku';

    /**
     * PriceBook code attribute
     */
    public const PRICE_BOOK_CODE = 'price_book_code';

    /**
     * This function sets the row_id
     *
     * @param int $id
     * @return void
     */
    public function setId(int $id);

    /**
     * This function gets the row_id
     *
     * @return mixed
     */
    public function getId();

    /**
     * This function sets the Sku
     *
     * @param string|null $sku
     * @return void
     */
    public function setSku(?string $sku);

    /**
     * This function gets the Sku
     *
     * @return string
     */
    public function getSku();

    /**
     * This function sets the PriceBookCode
     *
     * @param string|null $priceBookCode
     * @return void
     */
    public function setPriceBookCode(?string $priceBookCode);

    /**
     * This function gets the PriceBookCode
     *
     * @return string
     */
    public function getPriceBookCode();
}
