<?php
/**
 * Created by PhpStorm.
 * User: bohdan.sotnychuk
 * Date: 11/9/2017
 * Time: 4:12 AM
 */

namespace App\Traits;

trait AdminTraits
{

    public function setNotExistingChapter($filterDataWithAllDay, $chapters)
    {
        $filterDataWithNotExistingDayAndCategory = [];
        foreach ($filterDataWithAllDay as $month => $filterDataDay) {

            $filterDataWithNotExistingDayAndCategory[$month] = $filterDataDay;
            foreach ($chapters as $chapterName) {
                if (!array_key_exists($chapterName, $filterDataDay)) {
                    $monthData = reset($filterDataDay);
                    $filterDataWithNotExistingDayAndCategory[$month][$chapterName] = array_fill(0, count($monthData), 0);
                }
            }
        }

        return $filterDataWithNotExistingDayAndCategory;
    }

    public function addNotExistDayAndGroupByName($groupedPosts, $nameView, $filterDataWithNotExistingDay)
    {
        foreach ($groupedPosts as $yearMonth => $dayStatistic) {

            $dayStatistic = $dayStatistic->toArray();
            list($year, $month) = explode('-', $yearMonth);
            $countDayInMonth = cal_days_in_month(CAL_GREGORIAN, date($month), date($year));

            $startDay = 1;
            $fillDayStatistic = [];

            while ($startDay <= $countDayInMonth) {
                $fillDayStatistic[$startDay] = (!array_key_exists((int)$startDay,
                    $dayStatistic)) ? 0 : $dayStatistic[$startDay];
                $startDay++;
            }

            $filterDataWithNotExistingDay[$month][$nameView] = $fillDayStatistic;
            $filterDataWithNotExistingDay[$month][$nameView]['Total'] = array_sum($fillDayStatistic);
            $filterDataWithNotExistingDay[$month][$nameView]['year'] = $year;

        }

        return $filterDataWithNotExistingDay;
    }

}