<?php

namespace App\Helpers;


class GlobalHelper
{
    public static function getNumberFormat($number, int $decimal = 2): float
    {
        return (float)number_format($number, $decimal, '.', '');
    }

    public function calculateSuccessPercentage(int $total, int $earned): float|int
    {
        if ($total <= 0 || $earned < 0)
            $success_percentage = 0;
        else
            $success_percentage = round(($earned / $total) * 100, 2);
        return $success_percentage;
    }

    public function get_UI_URI()
    {
        return config('app.front_end_url');
    }

    public function get_Backend_Short_URI()
    {
        return config('app.admin_short_url');
    }

    public static function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));
        return number_format($bytes / (1024 ** $i), 2) . ' ' . $units[$i];
    }
}
