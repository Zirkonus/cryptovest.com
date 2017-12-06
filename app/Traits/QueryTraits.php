<?php
/**
 * Created by PhpStorm.
 * User: bohdan.sotnychuk
 * Date: 11/9/2017
 * Time: 4:12 AM
 */

namespace App\Traits;

trait QueryTraits
{

    public static function getGroupedByMonthAndDay($model)
    {
        return $model::latest()
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('Y-m');
            })->map(function ($monthStatistic) {
                return $monthStatistic->groupBy(function ($date) {
                    return (int)$date->created_at->format('d');
                })->map(function ($dayStatistic) {
                    return $dayStatistic->count();
                });
            });
    }

}