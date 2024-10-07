<?php

declare(strict_types=1);

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

namespace Magebit\Faq\Model\ResourceModel\Faq\Grid;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * FAQ Grid Collection Class
 *
 * Provides a collection for the FAQ grid in the admin panel.
 */
class Collection extends SearchResult
{
    /**
     * Constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     * @throws LocalizedException
     */
    public function __construct(
        private readonly EntityFactoryInterface $entityFactory,
        private readonly LoggerInterface $logger,
        private readonly FetchStrategyInterface $fetchStrategy,
        private readonly ManagerInterface $eventManager,
        private readonly string $mainTable = 'magebit_faq',
        private readonly string $resourceModel = 'Magebit\Faq\Model\ResourceModel\Faq'
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }
}
