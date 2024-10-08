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

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\FaqInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface for FAQ repository.
 *
 * Provides methods for saving, retrieving, and deleting FAQs.
 *
 * @api
 * @since 1.0.0
 */
interface FaqRepositoryInterface
{
    /**
     * Save an FAQ entity.
     *
     * @param FaqInterface $faq The FAQ entity to save.
     * @return void
     */
    public function save(FaqInterface $faq): void;

    /**
     * Get an FAQ entity by its ID.
     *
     * @param int $faqId The ID of the FAQ to retrieve.
     * @return FaqInterface
     */
    public function getById(int $faqId): FaqInterface;

    /**
     * Delete an FAQ entity.
     *
     * @param FaqInterface $faq The FAQ entity to delete.
     * @return void
     */
    public function delete(FaqInterface $faq): void;

    /**
     * Get all FAQ entities.
     *
     * @return FaqInterface[]
     */
    public function getEnabledFaqs(): array;
}
