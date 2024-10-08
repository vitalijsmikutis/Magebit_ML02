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
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action\Context;
use Psr\Log\LoggerInterface;
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
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param FaqRepositoryInterface $faqRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly FaqRepositoryInterface $faqRepository,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($this->context);
    }

    /**
     * Execute action to handle mass delete requests
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        /** @var Redirect $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            /** @var FaqInterface $faq */
            foreach ($collection as $faq) {
                $this->faqRepository->delete($faq);
            }
            $this->messageManager->addSuccessMessage(__(
                'A total of %1 record(s) have been deleted.',
                $collectionSize
            ));
        } catch (Throwable $exception) {
            $this->logger->error('Error occurred during mass delete', ['exception' => $exception->getMessage()]);
            $this->messageManager->addErrorMessage(__('An error occurred while deleting the FAQ records.'));

            return $result->setPath('magebit_faq/faq/index');
        }

        return $result->setPath('magebit_faq/faq/index');
    }
}
