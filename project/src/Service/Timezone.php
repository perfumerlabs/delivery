<?php

namespace Delivery\Service;

class Timezone
{
    private $timezone;

    public function __construct($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @param $date_time
     * @return \DateTime|mixed
     */
    public function formatDate($date_time)
    {
        if ($this->timezone && $this->timezone !== 'Delivery_TIMEZONE') {
            if ($date_time instanceof \DateTime) {
                $date_time->setTimezone(new \DateTimeZone($this->timezone));
            }
        }

        return $date_time;
    }
}