<?php

namespace TestOndoc;

use DateInterval;
use DateTime;

class Piller
{
    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var int
     */
    private $consumeDays;

    /**
     * @var int
     */
    private $skipDays;

    /**
     * Piller constructor.
     *
     * @param DateTime $startDate
     * @param int $consumeDays
     * @param int $skipDays
     */
    public function __construct(DateTime $startDate, $consumeDays, $skipDays)
    {
        $this->startDate = $startDate;
        $this->consumeDays = $consumeDays;
        $this->skipDays = $skipDays;
    }

    /**
     * Get next consume date
     *
     * @param DateTime $now
     * @return DateTime
     */
    public function getNextConsumeDate(DateTime $now)
    {
        // Starting date in future
        if ($now < $this->startDate) {
            return $this->startDate;
        }

        $dayInterval = $this->getDateInterval(1);

        // Consuming everyday
        if ($this->skipDays == 0) {
            $currentDate = clone $now;
            $currentDate->add($dayInterval);
            return $currentDate;
        }


        $currentDate = clone $this->startDate;

        // Add past cycles
        $cycle = $this->consumeDays + $this->skipDays;
        $diff = $currentDate->diff($now);
        if ($diff->days > $cycle) {
            $currentDate->add($this->getDateInterval($diff->days - $diff->days % $cycle));
        }

        $skipInterval = $this->getDateInterval($this->skipDays);

        // On first day of consuming cycle
        $counter = $this->consumeDays - 1;
        while ($currentDate <= $now) {
            if ($counter <= 0) {
                // Skipping days
                $currentDate->add($skipInterval);
                $counter = $this->consumeDays;
            }
            // Consume
            $currentDate->add($dayInterval);
            $counter -= 1;
        }
        return $currentDate;
    }

    /**
     * Get DateInterval for a number of days
     *
     * @param int $days
     * @return DateInterval
     */
    private function getDateInterval($days)
    {
        return new DateInterval(sprintf('P%dD', $days));
    }
}
