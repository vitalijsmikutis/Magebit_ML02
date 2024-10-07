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

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\FaqInterface;

/**
 * Interface for managing FAQ questions.
 *
 * @api
 * @since 1.0.0
 */
interface FaqManagementInterface
{
    /**
     * Enable a FAQ question by its ID.
     *
     * @param int $faqId The ID of the FAQ question to enable.
     * @return void
     */
    public function enableQuestion(int $faqId): void;

    /**
     * Disable a FAQ question by its ID.
     *
     * @param int $faqId The ID of the FAQ question to disable.
     * @return void
     */
    public function disableQuestion(int $faqId): void;

    /**
     * Get all FAQ questions.
     *
     * @return FaqInterface[] An array of FAQ questions.
     */
    public function getApplicableFaq(): array;


}
