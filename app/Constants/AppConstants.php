<?php

namespace App\Constants;

class AppConstants
{
    // ===== APPLICATION =====
    const APP_NAME = 'Xray Reporting App';
    const APP_VERSION = '1.0.0';
    const TIMEZONE = 'Asia/Jakarta';

    // ===== PAGINATION =====
    const PAGINATION_PER_PAGE = 15;
    const PAGINATION_PER_PAGE_SMALL = 10;
    const PAGINATION_PER_PAGE_LARGE = 25;

    // ===== FILE UPLOAD =====
    const MAX_FILE_SIZE = 20480; // 20MB in KB
    const MAX_IMAGE_SIZE = 5120; // 5MB in KB
    const ALLOWED_IMAGE_TYPES = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
    const ALLOWED_DOCUMENT_TYPES = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
    const ALLOWED_VIDEO_TYPES = ['mp4', 'avi', 'mov', 'mkv', 'webm'];

    // ===== STORAGE PATHS =====
    const STORAGE_PATH_EVIDENCES = 'evidences';
    const STORAGE_PATH_REPORTS = 'reports';
    const STORAGE_PATH_TEMP = 'temp';
    const STORAGE_PATH_CACHE = 'cache';

    // ===== RETENTION POLICIES =====
    const TEMP_FILE_RETENTION_DAYS = 7;
    const CACHE_FILE_RETENTION_DAYS = 30;
    const LOG_RETENTION_DAYS = 90;

    // ===== WORK ORDER =====
    const WORK_ORDER_NUMBER_PREFIX = 'WO';
    const WORK_ORDER_DRAFT_TIMEOUT_HOURS = 24;

    // ===== MAINTENANCE =====
    const DEFAULT_MAINTENANCE_FREQUENCY_DAYS = 30;
    const OVERDUE_WARNING_DAYS = 7;

    // ===== CHECKLIST =====
    const CHECKLIST_COMPLETION_WARNING_PERCENTAGE = 80;
    const CHECKLIST_ITEM_SEQUENCE_INCREMENT = 10;

    // ===== MEASUREMENT =====
    const MEASUREMENT_DECIMAL_PRECISION = 2;
    const MEASUREMENT_OUT_OF_RANGE_THRESHOLD = 5; // percentage

    // ===== OCR =====
    const OCR_ENGINE_DEFAULT = 'tesseract';
    const OCR_CONFIDENCE_THRESHOLD = 0.75;
    const OCR_PROCESSING_TIMEOUT_SECONDS = 30;
    const OCR_MAX_RETRIES = 3;

    // ===== NOTIFICATION =====
    const NOTIFICATION_QUEUE_NAME = 'default';
    const NOTIFICATION_TIMEOUT_SECONDS = 60;

    // ===== SESSION =====
    const SESSION_TIMEOUT_MINUTES = 240; // 4 hours
    const SESSION_WARNING_MINUTES = 15;

    // ===== CACHE =====
    const CACHE_DEFAULT_TTL_MINUTES = 60;
    const CACHE_EQUIPMENT_TTL_MINUTES = 1440; // 24 hours
    const CACHE_TEMPLATE_TTL_MINUTES = 1440; // 24 hours

    // ===== REGEX PATTERNS =====
    const PATTERN_PHONE_INDONESIA = '/^(\+62|0|62)[0-9]{9,12}$/';
    const PATTERN_USERNAME = '/^[a-zA-Z0-9_.-]{3,50}$/';
    const PATTERN_EQUIPMENT_CODE = '/^[A-Z]{3,10}-\d{3,5}$/';
    const PATTERN_QR_CODE = '/^QR-[A-Z0-9]{8,}$/';

    // ===== ROLE NAMES =====
    const ROLE_SUPER_ADMIN = 'Super Admin';
    const ROLE_TEKNISI = 'Teknisi';
    const ROLE_SUPERVISOR = 'Supervisor';

    // ===== EQUIPMENT VIEW MODES =====
    const VIEW_MODE_SINGLE = 'single_view';
    const VIEW_MODE_DUAL = 'dual_view';
    const VIEW_MODE_NA = 'not_applicable';
}