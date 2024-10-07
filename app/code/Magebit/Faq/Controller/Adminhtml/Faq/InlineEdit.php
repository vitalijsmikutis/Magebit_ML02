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
use Magebit\Faq\Api\FaqManagementInterface;
use Magebit\Faq\Model\Faq;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Throwable;

/**
 * Class InlineEdit
 *
 * Handles the inline editing of FAQ entries in the admin panel.
 *
 * @package Magebit\Faq\Controller\Adminhtml\Faq
 */
class InlineEdit extends Action
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param FaqRepositoryInterface $faqRepository
     * @param FaqManagementInterface $faqManagement
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        private readonly Context $context,
        private readonly FaqRepositoryInterface $faqRepository,
        private readonly FaqManagementInterface $faqManagement,
        private readonly JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Execute action to handle inline edit requests
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the data sent.')],
                    'error' => true,
                ]
            );
        } else {
            try {
                foreach (array_keys($postItems) as $faqId) {
                    /** @var Faq $faq */
                    $faq = $this->faqRepository->getById((int)$faqId);

                    if (isset($postItems[$faqId]['status'])) {
                        if ($postItems[$faqId]['status'] == FaqInterface::STATUS_ENABLED) {
                            $this->faqManagement->enableQuestion((int)$faqId);
                        } else {
                            $this->faqManagement->disableQuestion((int)$faqId);
                        }
                    }

                    $faq->setData(array_merge($faq->getData(), $postItems[(int)$faqId]));
                    $this->faqRepository->save($faq);
                }
            } catch (Throwable $exception) {
                $messages[] = '[Faq ID: ' . $faqId . ']' . $exception->getMessage();
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
