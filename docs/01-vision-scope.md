# Vision & Scope

**Version:** 1.0 Draft
**Status:** Draft

---

# 1. Vision

Menjadi sistem reporting Preventive Maintenance yang sederhana, cepat, dan terintegrasi untuk membantu teknisi melakukan inspeksi, dokumentasi, serta pembuatan laporan secara digital dengan meminimalkan pekerjaan administratif.

---

# 2. Mission

- Mengurangi proses pelaporan manual.
- Mempercepat proses Preventive Maintenance.
- Menjadikan database sebagai sumber utama seluruh laporan.
- Mengurangi kesalahan input data.
- Memudahkan pencarian histori maintenance.
- Membantu teknisi melalui OCR yang dapat membaca hasil pengukuran dari foto.

---

# 3. Core Philosophy

> Teknisi fokus pada maintenance, sistem fokus pada administrasi.

Sistem dibuat untuk menghilangkan pekerjaan yang berulang, bukan menggantikan keputusan teknisi.

---

# 4. Problem Statement

Saat ini proses Preventive Maintenance masih bergantung pada berbagai media seperti WhatsApp, Excel, PDF, dan folder foto sehingga:

- Data tersebar di banyak tempat.
- Laporan dibuat berulang.
- Sulit mencari histori.
- Memerlukan waktu administrasi yang tinggi.
- Berpotensi terjadi human error.

---

# 5. Proposed Solution

Membangun satu aplikasi yang menjadi pusat seluruh aktivitas Preventive Maintenance.

Workflow utama:

Scan QR

↓

Checklist

↓

Foto Evidence

↓

OCR Assist

↓

Submit

↓

Database

↓

Generate WA / PDF / Excel

---

# 6. In Scope

## Authentication

- Login
- Logout

## Master Data

- Teknisi
- Lokasi
- Equipment
- PM Type

## Preventive Maintenance

- QR Code
- Checklist
- Measurement
- Evidence
- OCR Assist

## Reporting

- WA Report
- PDF
- Excel

## Dashboard

- History
- Monitoring
- Detail PM

---

# 7. Out of Scope

- Predictive Maintenance
- AI Analysis
- Corrective Maintenance
- Work Order
- Inventory
- WhatsApp API
- GPS Tracking
- Push Notification
- Multi Project

---

# 8. Project Boundary

Aplikasi hanya menangani proses Preventive Maintenance X-Ray pada tahap awal.

---

# 9. Success Indicator

- PM dapat dilakukan tanpa Excel.
- Laporan WA otomatis.
- PDF otomatis.
- OCR membantu teknisi.
- Histori tersimpan dalam database.

---

# 10. Future Expansion

Arsitektur harus memungkinkan penambahan:

- WTMD
- HHMD
- ETD
- Multi Site
- Multi Project

tanpa mengubah struktur utama sistem.