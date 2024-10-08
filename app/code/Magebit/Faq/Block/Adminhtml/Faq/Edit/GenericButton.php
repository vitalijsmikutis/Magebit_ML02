<?php
/**
 * This file is part of the Magebit package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magebit Faq
 * to newer versions in the future.
 *
 * @copyright Copyright (c) 2024 Magebit, Ltd. (https://magebit.com/)
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Magebit\Faq\Block\Adminhtml\Faq\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Class GenericButton
 *
 * Provides generic button functionalities for the FAQ edit form, including generating URLs and retrieving block IDs.
 *
 * @package Magebit\Faq\Block\Adminhtml\Faq\Edit
 */
class GenericButton
{
    /**
     * @param Context $context
     * @param UrlInterface $url
     * @param BlockRepositoryInterface $blockRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly Context $context,
        private readonly UrlInterface $url,
        private readonly BlockRepositoryInterface $blockRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Return the CMS block ID
     *
     * @return int|null
     * @throws LocalizedException
     */
    public function getBlockId(): ?int
    {
        try {
            $blockId = $this->context->getRequest()->getParam('block_id');
            $block = $this->blockRepository->getById($blockId);

            return $block->getId();
        } catch (NoSuchEntityException $e) {
            $this->logger->error(__('Block not found: %1', $e->getMessage()));

            return null;
        }
    }

    /**
     * Generate URL by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->url->getUrl($route, $params);
    }
}
