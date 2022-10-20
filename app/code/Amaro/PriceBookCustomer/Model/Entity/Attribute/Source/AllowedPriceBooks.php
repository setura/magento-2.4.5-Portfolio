<?php

declare(strict_types=1);

namespace Amaro\PriceBookCustomer\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * AllowedPriceBooks class
 */
class AllowedPriceBooks extends AbstractSource
{
    /**
     * Get the options for the customer pricebook attribute
     *
     * @return \string[][]
     */
    public function getAllOptions()
    {
        return [
            'option1' => [
                'label' => 'DEFAULT',
                'value' => 'default'
            ],
            'option2' => [
                'label' => 'IRISH_PUB',
                'value' => 'irish_pub'
            ],
            'option3' => [
                'label' => 'COFFEE_SHOP',
                'value' => 'coffee_shop'
            ]
        ];
    }
}
