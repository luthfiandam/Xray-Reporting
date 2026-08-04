<?php

namespace App\Constants;

class Messages
{
    // ===== SUCCESS MESSAGES =====
    const SUCCESS_CREATE = ':resource berhasil dibuat';
    const SUCCESS_UPDATE = ':resource berhasil diperbarui';
    const SUCCESS_DELETE = ':resource berhasil dihapus';
    const SUCCESS_SUBMIT = 'Work order berhasil diajukan';
    const SUCCESS_APPROVE = 'Work order berhasil disetujui';
    const SUCCESS_CLOSE = 'Work order berhasil ditutup';
    const SUCCESS_UPLOAD = 'File berhasil diunggah';

    // ===== ERROR MESSAGES =====
    const ERROR_NOT_FOUND = ':resource tidak ditemukan';
    const ERROR_UNAUTHORIZED = 'Anda tidak memiliki izin untuk melakukan tindakan ini';
    const ERROR_INVALID_STATUS = 'Status tidak valid untuk operasi ini';
    const ERROR_INVALID_FILE = 'Format file tidak didukung';
    const ERROR_FILE_TOO_LARGE = 'Ukuran file terlalu besar';
    const ERROR_PROCESSING = 'Terjadi kesalahan saat memproses permintaan';

    // ===== VALIDATION MESSAGES =====
    const VALIDATION_REQUIRED = ':field harus diisi';
    const VALIDATION_EMAIL = ':field harus berupa email yang valid';
    const VALIDATION_UNIQUE = ':field sudah terdaftar';
    const VALIDATION_NUMERIC = ':field harus berupa angka';
    const VALIDATION_DATE = ':field harus berupa tanggal yang valid';

    // ===== WORK ORDER MESSAGES =====
    const WO_NOT_FOUND = 'Work order tidak ditemukan';
    const WO_INVALID_STATUS_TRANSITION = 'Transisi status tidak valid';
    const WO_ALREADY_CLOSED = 'Work order sudah ditutup dan tidak dapat diubah';
    const WO_NOT_READY_SUBMIT = 'Work order belum siap diajukan. Pastikan semua checklist dan measurement sudah selesai';

    // ===== CHECKLIST MESSAGES =====
    const CHECKLIST_INCOMPLETE = 'Checklist masih belum lengkap';
    const CHECKLIST_ITEM_REQUIRED = 'Item checklist ini harus diisi';

    // ===== MEASUREMENT MESSAGES =====
    const MEASUREMENT_OUT_OF_RANGE = 'Nilai pengukuran di luar rentang yang diizinkan';
    const MEASUREMENT_INVALID_VALUE = 'Nilai pengukuran tidak valid';

    // ===== EQUIPMENT MESSAGES =====
    const EQUIPMENT_OUT_OF_SERVICE = 'Peralatan sedang tidak beroperasi';
    const EQUIPMENT_UNDER_MAINTENANCE = 'Peralatan sedang dalam perbaikan';

    // ===== OCR MESSAGES =====
    const OCR_PROCESSING = 'Sedang memproses gambar...';
    const OCR_FAILED = 'Gagal memproses gambar. Silakan coba lagi';
    const OCR_NO_TEXT_DETECTED = 'Tidak ada teks yang terdeteksi dalam gambar';
    const OCR_LOW_CONFIDENCE = 'Tingkat kepercayaan hasil OCR rendah. Silakan periksa kembali';
}