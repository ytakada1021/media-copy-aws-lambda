<?php

declare(strict_types=1);

/**
 * @param array $event
 * @return void
 */
function index(array $event): void
{
    Assert::notNull($event, '$event cannot be null.');

    /** @var array $records */
    $records = $event['Records'];
}
