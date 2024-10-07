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

namespace Magebit\Faq\Api\Data;

/**
 * FAQ interface for managing FAQ entities.
 *
 * @api
 * @since 1.0.0
 */
interface FaqInterface
{
    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;

    /**
     * Get the FAQ ID.
     *
     * @return int|null The FAQ ID or null if not set.
     */
    public function getId(): ?int;

    /**
     * Get the FAQ question.
     *
     * @return string The FAQ question.
     */
    public function getQuestion(): string;

    /**
     * Set the FAQ question.
     *
     * @param string $question The FAQ question.
     * @return void
     */
    public function setQuestion(string $question): void;

    /**
     * Get the FAQ answer.
     *
     * @return string The FAQ answer.
     */
    public function getAnswer(): string;

    /**
     * Set the FAQ answer.
     *
     * @param string $answer The FAQ answer.
     * @return void
     */
    public function setAnswer(string $answer): void;

    /**
     * Get the FAQ status.
     *
     * @return int The FAQ status (enabled or disabled).
     */
    public function getStatus(): int;

    /**
     * Set the FAQ status.
     *
     * @param int $status The FAQ status (enabled or disabled).
     * @return void
     */
    public function setStatus(int $status): void;

    /**
     * Get the position of the FAQ.
     *
     * @return int The position of the FAQ.
     */
    public function getPosition(): int;

    /**
     * Set the position of the FAQ.
     *
     * @param int $position The position of the FAQ.
     * @return void
     */
    public function setPosition(int $position): void;

    /**
     * Get the timestamp of when the FAQ was last updated.
     *
     * @return string The date and time the FAQ was last updated.
     */
    public function getUpdatedAt(): string;
}
