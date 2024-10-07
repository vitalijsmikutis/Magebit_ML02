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

use Magento\Backend\App\Action\Context;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Edit
 *
 * Handles the editing of FAQs in the admin panel.
 *
 * @package Magebit\Faq\Controller\Adminhtml\Faq
 */
class Edit extends Action
{
    /**
     * @param Context $context
     * @param FaqRepositoryInterface $faqRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        private readonly Context $context,
        private readonly FaqRepositoryInterface $faqRepository,
        private readonly DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($this->context);
    }

    /**
     * Execute action to edit the FAQ
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Page $page */
        $page = $this->resultFactory->create($this->resultFactory::TYPE_PAGE);
        $faq_id = $this->getRequest()->getParam('faq_id');

        if ($faq_id === null) {
            $this->dataPersistor->set('magebit_faq_faq', []);
            $page->setActiveMenu('Magebit_Faq::faq');

            $page->addBreadcrumb(__('FAQ'), __('FAQ'));
            $page->addBreadcrumb(__('New FAQ'), __('New FAQ'));
            $page->getConfig()->getTitle()->prepend(__('New FAQ'));
            return $page;
        }

        try {
            $faq = $this->faqRepository->getById((int)$faq_id);
            $this->dataPersistor->set('magebit_faq_faq', $faq->getData());
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This FAQ with the given ID doesn\'t exist.'));
            return $page->setPath('magebit_faq/faq/index');
        }

        $page->setActiveMenu('Magebit_Faq::faq');

        $page->addBreadcrumb(__('FAQ'), __('FAQ'));
        $page->addBreadcrumb($faq->getQuestion(), $faq->getQuestion());
        $page->getConfig()->getTitle()->prepend($faq->getQuestion());

        return $page;
    }
}
