<?php

use TestOndoc\Piller;

class PillerTest extends PHPUnit_Framework_TestCase
{

    public function nextDateProvider()
    {
        return [
            // start  consume skip   now        next date
            ['2016-01-01', 2, 3, '2016-01-04', '2016-01-06'],

            ['2016-01-01', 2, 3, '2015-12-13', '2016-01-01'],
            ['2016-01-01', 2, 3, '2016-01-01', '2016-01-02'],
            ['2016-01-01', 2, 3, '2016-01-02', '2016-01-06'],
            ['2016-01-01', 2, 3, '2016-01-03', '2016-01-06'],
            ['2016-01-01', 2, 3, '2016-01-05', '2016-01-06'],
            ['2016-01-01', 2, 3, '2016-01-06', '2016-01-07'],
            ['2016-01-01', 2, 3, '2016-01-07', '2016-01-11'],

            ['2016-01-01', 1, 1, '2016-01-01', '2016-01-03'],
            ['2016-01-01', 1, 1, '2016-01-02', '2016-01-03'],
            ['2016-01-01', 1, 1, '2016-01-03', '2016-01-05'],

            ['2016-01-01', 1, 0, '2016-01-03', '2016-01-04'],
        ];
    }

    /**
     * @dataProvider nextDateProvider
     */
    public function testGetNextDate($start, $consume, $skip, $now, $expected)
    {
        $startDate = new DateTime($start);
        $consumeDays = $consume;
        $skipDays = $skip;

        $piller = new Piller($startDate, $consumeDays, $skipDays);

        $now = new DateTime($now);
        $nextDate = $piller->getNextConsumeDate($now);

        $this->assertEquals($expected, $nextDate->format('Y-m-d'));
    }

}
