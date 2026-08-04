<?php

namespace App\Helpers;

class FileHelper
{
    /**
     * Format file size to human readable
     */
    public static function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Get file extension
     */
    public static function getExtension(string $filename): string
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }

    /**
     * Check if file is image
     */
    public static function isImage(string $filename): bool
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        $extension = self::getExtension($filename);

        return in_array($extension, $imageExtensions);
    }

    /**
     * Check if file is PDF
     */
    public static function isPdf(string $filename): bool
    {
        return self::getExtension($filename) === 'pdf';
    }

    /**
     * Check if file is video
     */
    public static function isVideo(string $filename): bool
    {
        $videoExtensions = ['mp4', 'avi', 'mov', 'mkv', 'flv', 'wmv', 'webm'];
        $extension = self::getExtension($filename);

        return in_array($extension, $videoExtensions);
    }

    /**
     * Get mime type by extension
     */
    public static function getMimeType(string $filename): string
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'mp4' => 'video/mp4',
            'mov' => 'video/quicktime',
            'txt' => 'text/plain',
        ];

        $extension = self::getExtension($filename);
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    /**
     * Clean filename for storage
     */
    public static function cleanFilename(string $filename): string
    {
        // Remove special characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);

        // Remove multiple dots
        $filename = preg_replace('/\.+/', '.', $filename);

        return $filename;
    }
}