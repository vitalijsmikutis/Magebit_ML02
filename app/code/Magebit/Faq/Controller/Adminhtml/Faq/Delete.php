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

use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Psr\Log\LoggerInterface;
use Throwable;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Class Delete
 *
 * Handles the deletion of FAQs in the admin panel.
 *
 * @package Magebit\Faq\Controller\Adminhtml\Faq
 */
class Delete extends Action
{
    /**
     * @param Context $context
     * @param FaqRepositoryInterface $faqRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly Context $context,
        private readonly FaqRepositoryInterface $faqRepository,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($this->context);
    }

    /**
     * Execute action to delete the FAQ
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $faqId = (int)$this->getRequest()->getParam('faq_id');

        /** @var Redirect $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (!$faqId) {
            $this->logger->error('FAQ ID is missing.');
            $this->messageManager->addWarningMessage(__('FAQ with provided id was not found.'));

            return $result->setPath('magebit_faq/faq/index');
        }

        try {
            $faq = $this->faqRepository->getById($faqId);

            if (!$faq->getId()) {
                $this->logger->error('FAQ with ID ' . $faqId . ' was not found.');
                $this->messageManager->addWarningMessage(__('FAQ with provided id was not found.'));

                return $result->setPath('magebit_faq/faq/index');
            }

            $this->faqRepository->delete($faq);
            $this->messageManager->addSuccessMessage(__('The FAQ has been deleted.'));

        } catch (Throwable $e) {
            $this->logger->error('Error while deleting FAQ with ID ' . $faqId . ': ' . $e->getMessage());
            $this->messageManager->addErrorMessage(__('An error occurred while deleting the FAQ.'));

            return $result->setPath('magebit_faq/faq/index');
        }

        return $result->setPath('magebit_faq/faq/index');
    }
}
