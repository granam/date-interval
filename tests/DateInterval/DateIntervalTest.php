<?php declare(strict_types=1);

namespace Granam\Tests\DateInterval;

use Granam\DateInterval\DateInterval;
use PHPUnit\Framework\TestCase;

class DateIntervalTest extends TestCase
{
    public function getDiffs()
    {
        $fromMonth = new \DateTime('2010-02-01 00:00:00');
        $toMonth = new \DateTime('2010-01-01 00:00:00');
        $month = $fromMonth->diff($toMonth);
        $monthDays = $month->days * DateInterval::SECONDS_DAY;

        $fromYear = new \DateTime('2011-01-01 00:00:00');
        $toYear = new \DateTime('2010-01-01 00:00:00');
        $year = $fromYear->diff($toYear);
        $yearDays = $year->days * DateInterval::SECONDS_DAY;
        $list = [
            [
                '1',
                new \DateTime('2010-01-01 00:00:01'),
                new \DateTime('2010-01-01 00:00:00'),
            ],
            [
                '60',
                new \DateTime('2010-01-01 00:01:00'),
                new \DateTime('2010-01-01 00:00:00'),
            ],
            [
                '3600',
                new \DateTime('2010-01-01 01:00:00'),
                new \DateTime('2010-01-01 00:00:00'),
            ],
            [
                '86400',
                new \DateTime('2010-01-02 00:00:00'),
                new \DateTime('2010-01-01 00:00:00'),
            ],
            [
                $monthDays,
                $fromMonth,
                $toMonth,
            ],
            [
                $yearDays,
                $fromYear,
                $toYear,
            ],
        ];

        return $list;
    }

    public function provideSeconds()
    {
        return [
            ['1', 'PT1S'],
            ['60', 'PT1M'],
            ['3600', 'PT1H'],
            ['86400', 'P1D'],
            ['2629740', 'P1M'],
            ['31556874', 'P1Y'],
            ['34276675', 'P1Y1M1DT1H1M1S'],
            ['2056600500', 'P65Y2M1DT16H3M30S'],
        ];
    }

    public function provideSpec()
    {
        return [
            ['PT1S'],
            ['PT1M'],
            ['PT1H'],
            ['P1D'],
            ['P1M'],
            ['P1Y'],
            ['P1Y1M1DT1H1M1S'],
        ];
    }

    /**
     * @dataProvider provideSeconds
     * @param int $seconds
     * @param string $spec
     */
    public function testFromSeconds($seconds, $spec)
    {
        $interval = DateInterval::fromSeconds($seconds);

        self::assertEquals($spec, $interval->toSpec());
    }

    public function testFromSecondsCompare()
    {
        $seconds = DateInterval::fromSeconds('2056600500');
        $interval = new DateInterval('P60Y60M60DT60H60M60S');

        self::assertEquals($seconds->toSeconds(), $interval->toSeconds());
    }

    public function testToString()
    {
        self::assertEquals('PT1S', (string)new DateInterval('PT1S'));
    }

    /**
     * @dataProvider provideSeconds
     * @param int $seconds
     * @param string $spec
     */
    public function testToSeconds($seconds, $spec)
    {
        $interval = new DateInterval($spec);

        self::assertEquals($seconds, $interval->toSeconds());
    }

    /**
     * @dataProvider getDiffs
     * @param string $seconds
     * @param \DateTime $left
     * @param \DateTime $right
     */
    public function testToSecondsUsingDays($seconds, $left, $right)
    {
        self::assertEquals(
            $seconds,
            DateInterval::toSecondsUsingDays($left->diff($right))
        );
    }

    public function testToSecondsUsingDaysNotSet()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The "days" property is not set.');
        $interval = new DateInterval('PT0S');
        DateInterval::toSecondsUsingDays($interval);
    }

    /**
     * @dataProvider provideSpec
     * @param string $spec
     */
    public function testToSpec($spec)
    {
        $interval = new DateInterval($spec);

        self::assertEquals($spec, $interval->toSpec());
    }
}
