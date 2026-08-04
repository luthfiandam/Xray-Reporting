<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Format date to Indonesian
     */
    public static function toIndonesian(Carbon|string|null $date): string
    {
        if (!$date) {
            return '-';
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $month = $months[$date->month - 1];
        return sprintf('%d %s %d', $date->day, $month, $date->year);
    }

    /**
     * Format datetime to Indonesian with time
     */
    public static function toIndonesianDateTime(Carbon|string|null $date): string
    {
        if (!$date) {
            return '-';
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return self::toIndonesian($date) . ' ' . $date->format('H:i');
    }

    /**
     * Get time difference in human readable format
     */
    public static function diffForHumans(Carbon|string|null $date): string
    {
        if (!$date) {
            return '-';
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        // Indonesian translation
        return $date->diffForHumans(locale: 'id');
    }

    /**
     * Get age in years
     */
    public static function getAge(Carbon|string|null $date): ?int
    {
        if (!$date) {
            return null;
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->diffInYears(now());
    }

    /**
     * Format time duration
     */
    public static function formatDuration(int $seconds): string
    {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Get month name in Indonesian
     */
    public static function getMonthName(int $month): string
    {
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return $months[$month - 1] ?? '';
    }

    /**
     * Get day name in Indonesian
     */
    public static function getDayName(Carbon|string|null $date): string
    {
        if (!$date) {
            return '-';
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return $days[$date->dayOfWeek];
    }
}