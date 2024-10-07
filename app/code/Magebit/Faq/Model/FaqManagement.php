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

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqManagementInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class FaqManagement implements FaqManagementInterface
{
    /**
     * @param FaqRepositoryInterface $faqRepository
     */
    public function __construct(
        private readonly FaqRepositoryInterface $faqRepository
    ) {
    }

    /**
     * Enable FAQ question.
     *
     * @param int $faqId
     * @return void
     * @throws NoSuchEntityException
     */
    public function enableQuestion(int $faqId): void
    {
        $faq = $this->faqRepository->getById($faqId);
        $faq->setStatus(FaqInterface::STATUS_ENABLED);
        $this->faqRepository->save($faq);
    }

    /**
     * Disable FAQ question.
     *
     * @param int $faqId
     * @return void
     * @throws NoSuchEntityException
     */
    public function disableQuestion(int $faqId): void
    {
        $faq = $this->faqRepository->getById($faqId);
        $faq->setStatus(FaqInterface::STATUS_DISABLED);
        $this->faqRepository->save($faq);
    }

    /**
     * Get all FAQ questions.
     *
     * @return FaqInterface[]
     */

    public function getApplicableFaq(): array
    {
        return array_filter($this->faqRepository->getList(), function (FaqInterface $faq) {
            return $faq->getStatus() === FaqInterface::STATUS_ENABLED;
        });
    }
}
