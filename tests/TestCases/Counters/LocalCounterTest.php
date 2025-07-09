<?php

namespace Silencenjoyer\RateLimit\Tests\TestCases\Counters;

use Silencenjoyer\RateLimit\Counters\LocalCounter;
use Silencenjoyer\RateLimit\Intervals\Interval;
use Silencenjoyer\RateLimit\Rates\Rate;

/**
 * Class LocalCounterTest
 *
 * @package Counters
 */
class LocalCounterTest extends AbstractCounterTest
{
    /**
     * {@inheritDoc}
     * @return string
     */
    public function getClassName(): string
    {
        return LocalCounter::class;
    }

    /**
     * @return array[]
     */
    public function incrementProvider(): array
    {
        return [
            [
                [],
                new Rate(5, new Interval('PT1S')),
                1,
            ],
            [
                [],
                new Rate(5, new Interval('PT1S')),
                3,
            ],
        ];
    }
}
