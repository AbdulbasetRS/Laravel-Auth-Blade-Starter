<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Convert a UTC datetime to a specific timezone.
     *
     * Example usage:
     * ```php
     * $utcTime = '2025-11-09 02:00:00';
     * $cairoTime = DateHelper::toTimezone($utcTime, 'Africa/Cairo');
     * echo $cairoTime; // Carbon instance in 'Africa/Cairo' timezone
     * ```
     *
     * @param  string|Carbon|null  $utcDateTime  The datetime in UTC or a Carbon instance.
     * @param  string  $timezone  The target timezone (default: 'Africa/Cairo').
     * @return Carbon|null Returns a Carbon instance in the target timezone or null if input is empty.
     */
    public static function toTimezone($utcDateTime, $timezone = 'Africa/Cairo')
    {
        if (empty($utcDateTime)) {
            return null;
        }

        return Carbon::parse($utcDateTime, 'UTC')->setTimezone($timezone);
    }

    /**
     * Format a datetime to a custom format.
     * Accepts both UTC strings or Carbon instances.
     *
     * Example usage:
     * ```php
     * $utcTime = '2025-11-09 02:00:00';
     * $cairoTime = DateHelper::toTimezone($utcTime, 'Africa/Cairo');
     * $formatted = DateHelper::formatDateTime($cairoTime, 'd M Y - h:i A');
     * echo $formatted; // "09 Nov 2025 - 04:00 AM"
     * ```
     *
     * @param  string|Carbon|null  $dateTime  The datetime to format.
     * @param  string  $format  The desired format (default: 'd M Y - h:i A').
     * @return string|null Returns the formatted datetime as a string or null if input is empty.
     */
    public static function formatDateTime($dateTime, $format = 'd M Y - h:i A')
    {
        if (empty($dateTime)) {
            return null;
        }

        if (! ($dateTime instanceof Carbon)) {
            $dateTime = Carbon::parse($dateTime);
        }

        return $dateTime->translatedFormat($format);
    }

    /**
     * Get the difference between the given datetime and now in a human-readable format.
     *
     * Example usage:
     * ```php
     * $utcTime = '2025-11-09 02:00:00';
     * echo DateHelper::diffForHumans($utcTime, 'Africa/Cairo'); // "3 hours ago" or similar
     * ```
     *
     * @param  string|Carbon|null  $dateTime  The datetime to compare with now.
     * @param  string  $timezone  The timezone to convert to before calculating the difference (default: 'Africa/Cairo').
     * @return string|null Returns the difference in human-readable format or null if input is empty.
     */
    public static function diffForHumans($dateTime, $timezone = 'Africa/Cairo')
    {
        $dateTime = self::toTimezone($dateTime, $timezone);
        if (! $dateTime) {
            return null;
        }

        return $dateTime->diffForHumans();
    }

    /**
     * Convert a UTC datetime to a specific timezone and format it in one step.
     *
     * Example usage:
     * ```php
     * $utcTime = '2025-11-09 02:00:00';
     * $formatted = DateHelper::convertAndFormat($utcTime, 'Africa/Cairo', 'Y-m-d H:i:s');
     * echo $formatted; // "2025-11-09 04:00:00"
     * ```
     *
     * @param  string|Carbon|null  $utcDateTime  The datetime in UTC or a Carbon instance.
     * @param  string  $timezone  The target timezone (default: 'Africa/Cairo').
     * @param  string  $format  The desired format after conversion (default: 'Y-m-d H:i:s').
     * @return string|null Returns the converted and formatted datetime as a string or null if input is empty.
     */
    public static function convertAndFormat($utcDateTime, $timezone = 'Africa/Cairo', $format = 'Y-m-d H:i:s')
    {
        $dateTime = self::toTimezone($utcDateTime, $timezone);
        if (! $dateTime) {
            return null;
        }

        return self::formatDateTime($dateTime, $format);
    }
}
