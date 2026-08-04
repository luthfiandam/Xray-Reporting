<?php

namespace App\Helpers;

class ValidationHelper
{
    /**
     * Check if value is within range
     */
    public static function isWithinRange($value, $min, $max): bool
    {
        if ($value === null) {
            return false;
        }

        if ($min !== null && $value < $min) {
            return false;
        }

        if ($max !== null && $value > $max) {
            return false;
        }

        return true;
    }

    /**
     * Validate IP address
     */
    public static function isValidIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Validate phone number (Indonesia)
     */
    public static function isValidPhoneNumber(string $phone): bool
    {
        // Accept various formats: +62, 0, 62
        return preg_match('/^(\+62|0|62)[0-9]{9,12}$/', str_replace('-', '', $phone)) === 1;
    }

    /**
     * Validate email
     */
    public static function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate URL
     */
    public static function isValidUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Sanitize string input
     */
    public static function sanitize(string $input): string
    {
        return trim(strip_tags($input));
    }

    /**
     * Validate field against pattern
     */
    public static function matchesPattern(string $value, string $pattern): bool
    {
        return preg_match($pattern, $value) === 1;
    }
}