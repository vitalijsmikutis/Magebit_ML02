<?php

/**
 * This file is part of the Magebit package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magebit Faq
 * to newer versions in the future.
 *
 * @copyright Copyright (c) 2022 Magebit, Ltd. (https://magebit.com/)
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Magebit\Faq\Model\Faq\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 * Provides options for FAQ status.
 *
 * @package Magebit\Faq\Model\Faq\Source
 */
class Status implements OptionSourceInterface
{
    private const ENABLED = 1;
    private const DISABLED = 0;

    /**
     * Retrieve options for FAQ status.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::DISABLED,
                'label' => __('Disabled')
            ],
            [
                'value' => self::ENABLED,
                'label' => __('Enabled')
            ]
        ];
    }
}
