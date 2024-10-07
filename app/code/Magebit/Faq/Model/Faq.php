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

use Magebit\Faq\Api\Data\FaqInterface;
use Magento\Framework\Model\AbstractModel;
use Magebit\Faq\Model\ResourceModel\Faq as FaqResource;

/**
 * FAQ entity model.
 */
class Faq extends AbstractModel implements FaqInterface
{
    private const ID = 'faq_id';
    private const QUESTION = 'question';
    private const ANSWER = 'answer';
    private const STATUS = 'status';
    private const POSITION = 'position';
    private const UPDATED_AT = 'updated_at';

    /**
     * Initialize resource model.
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_eventPrefix = 'magebit_faq';
        $this->_eventObject = 'faq';
        $this->_idFieldName = self::ID;
        $this->_init(FaqResource::class);
    }

    /**
     * Get FAQ ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        $id = $this->getData(self::ID);
        return $id !== null ? (int) $id : null;
    }

    /**
     * Get FAQ question.
     *
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * Set FAQ question.
     *
     * @param string $question
     * @return void
     */
    public function setQuestion(string $question): void
    {
        $this->setData(self::QUESTION, $question);
    }

    /**
     * Get FAQ answer.
     *
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * Set FAQ answer.
     *
     * @param string $answer
     * @return void
     */
    public function setAnswer(string $answer): void
    {
        $this->setData(self::ANSWER, $answer);
    }

    /**
     * Get FAQ status.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int) $this->getData(self::STATUS);
    }

    /**
     * Set FAQ status.
     *
     * @param int $status
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * Get FAQ position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return (int) $this->getData(self::POSITION);
    }

    /**
     * Set FAQ position.
     *
     * @param int $position
     * @return void
     */
    public function setPosition(int $position): void
    {
        $this->setData(self::POSITION, $position);
    }

    /**
     * Get last updated time.
     *
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }
}
