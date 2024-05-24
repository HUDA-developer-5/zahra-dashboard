<?php

namespace App\Helpers;


use Illuminate\Support\Str;

class GlobalHelper
{
    public static function getNumberFormat($number, int $decimal = 2): float
    {
        return (float)number_format($number, $decimal, '.', '');
    }

    public static function convertToSmallestDenomination(float $amount)
    {
        return (int)str_replace('.', '', $amount * 100);
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

    public static function setMetaTagsAttributes($share_title = null, $share_description = null, $share_image = null)
    {
        session()->flash('share_title', $share_title);
        session()->flash('share_description', strip_tags(Str::limit($share_description, 200)));
        session()->flash('share_image', $share_image);
    }
}
