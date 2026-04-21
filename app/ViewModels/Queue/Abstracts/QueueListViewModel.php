<?php

namespace OGame\ViewModels\Queue\Abstracts;

class QueueListViewModel
{
    /**
     * Maximum number of items allowed in the building queue
     * (1 currently building + 4 waiting = 5 total).
     *
     * This is the single source of truth for the queue size limit.
     * Reference this constant from any other class that needs to know the limit
     * instead of hard-coding the value.
     *
     * TODO: refactor into a global constant setting configurable by admin.
     */
    public const BUILDING_QUEUE_SLOT_LIMIT = 5;

    /**
     * Constructor.
     *
     * @param array<QueueViewModel> $queue
     */
    public function __construct(
        /**
         * List of queue items.
         */
        public array $queue
    ) {
    }

    /**
     * Get amount of items in the queue.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->queue);
    }

    /**
     * Get amount of items in the queue.
     *
     * @return bool
     */
    public function isQueueFull(): bool
    {
        return count($this->queue) >= self::BUILDING_QUEUE_SLOT_LIMIT;
    }
}
