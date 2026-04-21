<?php

namespace OGame\Exceptions;

use RuntimeException;

/**
 * Thrown when an item cannot be added to a build queue because the queue
 * has already reached its maximum capacity.
 */
class QueueFullException extends RuntimeException
{
}
