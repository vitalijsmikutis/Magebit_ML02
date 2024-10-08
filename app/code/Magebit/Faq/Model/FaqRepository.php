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
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Faq as FaqResource;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class FaqRepository implements FaqRepositoryInterface
{
    /**
     * @param FaqResource $faqResource
     * @param FaqFactory $factory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly FaqResource $faqResource,
        private readonly FaqFactory $factory,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(FaqInterface $faq): void
    {
        try {
            $this->faqResource->save($faq);
        } catch (Exception $e) {
            $this->logger->error('Error saving FAQ: ' . $e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(FaqInterface $faq): void
    {
        try {
            $this->faqResource->delete($faq);
        } catch (Exception $e) {
            $this->logger->error('Error deleting FAQ: ' . $e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function getById(int $faqId): FaqInterface
    {
        $faq = $this->factory->create();
        try {
            $this->faqResource->load($faq, $faqId);
        } catch (NoSuchEntityException $e) {
            $this->logger->error('FAQ not found for ID ' . $faqId . ': ' . $e->getMessage());
        } catch (Exception $e) {
            $this->logger->error('Error loading FAQ ID ' . $faqId . ': ' . $e->getMessage());
        }
        return $faq;
    }

    /**
     * @inheritDoc
     */
    public function getEnabledFaqs(): array
    {
        try {
            $faqCollection = $this->factory->create()->getCollection();
            $faqCollection->addFieldToFilter('status', FaqInterface::STATUS_ENABLED);
            return $faqCollection->getItems();
        } catch (Exception $e) {
            $this->logger->error('Error retrieving enabled FAQs: ' . $e->getMessage());
            return [];
        }
    }
}
