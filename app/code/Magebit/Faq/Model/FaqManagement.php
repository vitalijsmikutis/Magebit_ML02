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

use Exception;
use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqManagementInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class FaqManagement implements FaqManagementInterface
{
    /**
     * @param FaqRepositoryInterface $faqRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly FaqRepositoryInterface $faqRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function enableQuestion(int $faqId): void
    {try {
        $faq = $this->faqRepository->getById($faqId);
        $faq->setStatus(FaqInterface::STATUS_ENABLED);
        $this->faqRepository->save($faq);
    } catch (NoSuchEntityException $e) {
        $this->logger->error('FAQ not found for ID ' . $faqId . ': ' . $e->getMessage());
    } catch (Exception $e) {
        $this->logger->error('Error enabling FAQ ID ' . $faqId . ': ' . $e->getMessage());
    }
    }

    /**
     * @inheritDoc
     */
    public function disableQuestion(int $faqId): void
    {
        try {
            $faq = $this->faqRepository->getById($faqId);
            $faq->setStatus(FaqInterface::STATUS_DISABLED);
            $this->faqRepository->save($faq);
        } catch (NoSuchEntityException $e) {
            $this->logger->error('FAQ not found for ID ' . $faqId . ': ' . $e->getMessage());
        } catch (Exception $e) {
            $this->logger->error('Error disabling FAQ ID ' . $faqId . ': ' . $e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function getApplicableFaq(): array
    {
        try {
            return array_filter($this->faqRepository->getList(), function (FaqInterface $faq) {
                return $faq->getStatus() === FaqInterface::STATUS_ENABLED;
            });
        } catch (Exception $e) {
            $this->logger->error('Error retrieving applicable FAQs: ' . $e->getMessage());
            return [];
        }
    }
}
