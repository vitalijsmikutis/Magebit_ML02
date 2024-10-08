<?php

/**
 * This file is part of the Magebit package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magebit ProductAttributes
 * to newer versions in the future.
 *
 * @copyright Copyright (c) 2024 Magebit, Ltd. (https://magebit.com/)
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel\Faq;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magebit\Faq\Model\Faq;
use Magebit\Faq\Model\ResourceModel\Faq as FaqResource;

/**
 * Collection class for FAQ model.
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize collection.
     */
    protected function _construct()
    {
        $this->_init(Faq::class, FaqResource::class);
    }
}
