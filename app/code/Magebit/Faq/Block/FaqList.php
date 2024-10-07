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

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\Data\FaqInterface;
use Magebit\Faq\Api\FaqRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;


class FaqList extends Template
{
    public function __construct(
        private readonly Context $context,
        private readonly FaqRepositoryInterface $faqRepository
    ) {
        parent::__construct($this->context);
    }

    /**
     * Get the enabled FAQ questions.
     *
     * @return FaqInterface[] The enabled FAQ questions.
     */
    public function getFaq(): array
    {
        return $this->faqRepository->getEnabledFaqs();
    }

    /**
     * Set the template variables for the FAQ list.
     */
    protected function _prepareLayout(): void
    {
        parent::_prepareLayout();
        $this->assign('faqList', $this->getFaq());
    }
}
