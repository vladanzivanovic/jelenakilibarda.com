<?php

declare(strict_types=1);

namespace App\Services;

final class DateTimeService
{
    public function getOffsetOfCurrentDate(\DateTimeInterface $date, $callback = null)
    {
        $now = new \DateTime();

        $diff = $now->diff($date);

        switch($callback){
            case "D":
                $result = $diff->format("%R%a");
                break;
            case "H":
                $result = $this->getHoursOffset($diff);
                break;
            default:
                $result = $diff;
                break;
        }
        return $result;
    }

    private function getHoursOffset(\DateInterval $dateInterval): int
    {
        if($dateInterval->days == 0){
            return $dateInterval->h;
        }

        return ($dateInterval->days * 24) + $dateInterval->h;
    }
}
