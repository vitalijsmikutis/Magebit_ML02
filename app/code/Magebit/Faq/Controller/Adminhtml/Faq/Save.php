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

use Magebit\Faq\Api\FaqManagementInterface;
use Magebit\Faq\Model\FaqFactory;
use Magebit\Faq\Model\FaqRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * Handles saving an FAQ in the admin panel.
 *
 * @package Magebit\Faq\Controller\Adminhtml\Faq
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Save constructor.
     *
     * @param Context $context
     * @param FaqRepository $faqRepository
     * @param FaqFactory $faqFactory
     * @param DataPersistorInterface $dataPersistor
     * @param FaqManagementInterface $faqManagement
     */
    public function __construct(
        private readonly Context $context,
        private readonly FaqRepository $faqRepository,
        private readonly FaqFactory $faqFactory,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly FaqManagementInterface $faqManagement
    ) {
        parent::__construct($this->context);
    }

    /**
     * Executes the FAQ save action.
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        $data = $this->getRequest()->getPostValue();

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if ($data) {
            // Initialize FAQ ID
            if (empty($data['faq_id'])) {
                $data['faq_id'] = null;
            }

            $model = $this->faqFactory->create();

            $id = (int)$this->getRequest()->getParam('faq_id');
            if ($id) {
                try {
                    $model = $this->faqRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This FAQ no longer exists.'));
                    return $resultRedirect->setPath('magebit_faq/faq/index');
                }
            }

            $model->setData($data);

            try {
                $this->faqRepository->save($model);

                if (isset($data['status']) && $data['status'] === '1') {
                    $this->faqManagement->enableQuestion($model->getId());
                } else {
                    $this->faqManagement->disableQuestion($model->getId());
                }

                $this->messageManager->addSuccessMessage(__('You saved the FAQ.'));
                $this->dataPersistor->clear('magebit_faq_faq');
                return $resultRedirect->setPath('magebit_faq/faq/index', ['faq_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error while saving the FAQ: ' . $e->getMessage()));
            }
        } else {
            $this->messageManager->addErrorMessage(__('No data found to save the FAQ.'));
            return $resultRedirect->setPath('magebit_faq/faq/index');
        }

        $this->dataPersistor->set('magebit_faq_faq', $data);
        return $resultRedirect->setPath('magebit_faq/faq/index');
    }
}
