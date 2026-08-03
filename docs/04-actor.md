# Actor

**Version:** 1.0 Draft

---

# 1. Overview

Actor adalah pihak yang berinteraksi langsung dengan sistem.

Pada versi pertama terdapat tiga actor utama.

```
Administrator

Supervisor

Teknisi
```

---

# 2. Teknisi

## Deskripsi

Pengguna utama aplikasi yang melakukan Preventive Maintenance.

## Hak Akses

- Login
- Scan QR Code
- Melihat data equipment
- Membuat PM Session
- Mengisi Checklist
- Mengambil foto evidence
- Menggunakan OCR
- Mengedit hasil OCR
- Submit PM
- Melihat histori PM miliknya

---

# 3. Supervisor

## Deskripsi

Mengawasi seluruh aktivitas Preventive Maintenance.

## Hak Akses

- Login
- Dashboard Monitoring
- Melihat seluruh PM
- Review hasil PM
- Download PDF
- Export Excel
- Melihat histori semua equipment

---

# 4. Administrator

## Deskripsi

Mengelola master data aplikasi.

## Hak Akses

- Login
- CRUD User
- CRUD Equipment
- CRUD Lokasi
- CRUD Checklist Template
- CRUD PM Type
- Generate QR Code
- Backup Database

---

# 5. Future Actor

Belum digunakan pada V1.

- Manager
- Auditor
- Vendor
- Owner

---

# 6. Permission Matrix

| Fitur | Teknisi | Supervisor | Admin |
|--------|----------|------------|-------|
| Login | ✅ | ✅ | ✅ |
| Scan QR | ✅ | ❌ | ❌ |
| PM | ✅ | ❌ | ❌ |
| OCR | ✅ | ❌ | ❌ |
| Review PM | ❌ | ✅ | ❌ |
| Dashboard | ❌ | ✅ | ✅ |
| Export PDF | ✅ | ✅ | ✅ |
| Export Excel | ❌ | ✅ | ✅ |
| CRUD User | ❌ | ❌ | ✅ |
| CRUD Equipment | ❌ | ❌ | ✅ |
| Backup Database | ❌ | ❌ | ✅ |