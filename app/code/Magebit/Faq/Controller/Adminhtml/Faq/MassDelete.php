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

namespace Magebit\Faq\Controller\Adminhtml\Faq;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action\Context;
use Throwable;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class MassDelete
 *
 * Handles mass deletion of FAQ entries in the admin panel.
 *
 * @package Magebit\Faq\Controller\Adminhtml\Faq
 */
class MassDelete extends Action
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param FaqRepositoryInterface $faqRepository
     */
    public function __construct(
        private readonly Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly FaqRepositoryInterface $faqRepository,
    ) {
        parent::__construct($context);
    }

    /**
     * Execute action to handle mass delete requests
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        try {
            /** @var FaqInterface $faq */
            foreach ($collection as $faq) {
                $this->faqRepository->delete($faq);
            }
            $this->messageManager->addSuccessMessage(__("A total of %1 record(s) have been deleted.", $collectionSize));
        } catch (Throwable $exception) {
            $this->messageManager->addErrorMessage(__("An error occurred while deleting the FAQ records."));
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('magebit_faq/faq/index');
        }

        /** @var Redirect $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $result->setPath('magebit_faq/faq/index');
    }
}
