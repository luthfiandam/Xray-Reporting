<?php

namespace App\Enums;

enum EvidenceType: string
{
    case PHOTO = 'photo';
    case VIDEO = 'video';
    case DOCUMENT = 'document';

    /**
     * Get label in Indonesian
     */
    public function label(): string
    {
        return match($this) {
            self::PHOTO => 'Foto',
            self::VIDEO => 'Video',
            self::DOCUMENT => 'Dokumen',
        };
    }

    /**
     * Get icon class
     */
    public function iconClass(): string
    {
        return match($this) {
            self::PHOTO => 'fas fa-image',
            self::VIDEO => 'fas fa-video',
            self::DOCUMENT => 'fas fa-file',
        };
    }

    /**
     * Get all values
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}