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
use InvalidArgumentException;
use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Faq as FaqResource;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

class FaqRepository implements FaqRepositoryInterface
{
    /**
     * @param FaqResource $faqResource
     * @param FaqFactory $factory
     */
    public function __construct(
        private readonly FaqResource $faqResource,
        private readonly FaqFactory $factory
    ) {
    }

    /**
     * Save FAQ entity.
     *
     * @param FaqInterface $faq
     * @return void
     * @throws InvalidArgumentException
     * @throws AlreadyExistsException
     */
    public function save(FaqInterface $faq): void
    {
        $this->faqResource->save($faq);
    }

    /**
     * Delete FAQ entity.
     *
     * @param FaqInterface $faq
     * @return void
     * @throws InvalidArgumentException|Exception
     */
    public function delete(FaqInterface $faq): void
    {

        $this->faqResource->delete($faq);
    }

    /**
     * Get FAQ by ID.
     *
     * @param int $faqId
     * @return FaqInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $faqId): FaqInterface
    {
        $faq = $this->factory->create();
        $this->faqResource->load($faq, $faqId);
        if (!$faq->getId()) {
            throw new NoSuchEntityException(
                __('FAQ with id "%1" does not exist.', $faqId)
            );
        }
        return $faq;
    }


    /**
     * Get all enabled FAQs.
     *
     * @return FaqInterface[]
     */
    public function getEnabledFaqs(): array
    {
        $faqCollection = $this->factory->create()->getCollection();
        $faqCollection->addFieldToFilter('status', FaqInterface::STATUS_ENABLED);

        return $faqCollection->getItems();
    }


}
