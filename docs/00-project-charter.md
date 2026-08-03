# 00-project-charter.md

# Xray Reporting App

**Version:** 1.0 Draft
**Status:** Draft
**Document Owner:** Luthfi & ChatGPT
**Last Updated:** 03 Agustus 2026

---

# 1. Project Overview

Xray Reporting App merupakan aplikasi yang dirancang untuk membantu teknisi dalam melakukan kegiatan Preventive Maintenance (PM) pada mesin X-Ray secara digital.

Aplikasi ini bertujuan menghilangkan proses administrasi yang masih dilakukan secara manual, sehingga teknisi dapat lebih fokus pada pekerjaan maintenance dibandingkan pembuatan laporan.

Aplikasi akan digunakan sebagai media utama untuk melakukan checklist, dokumentasi, pencatatan hasil pengukuran, serta menghasilkan laporan secara otomatis.

---

# 2. Background

Saat ini proses Preventive Maintenance masih memiliki banyak pekerjaan yang dilakukan secara manual, antara lain:

* Mengambil foto evidence.
* Mengirim laporan melalui WhatsApp.
* Mengetik ulang hasil pengukuran dari foto.
* Memindahkan foto ke komputer.
* Mengganti nama file satu per satu.
* Mengelompokkan foto berdasarkan lokasi.
* Membuat kolase secara manual.
* Menyusun laporan PDF.
* Mengisi rekap Excel bulanan.

Seluruh proses tersebut membutuhkan waktu yang cukup lama dan memiliki potensi kesalahan pencatatan.

---

# 3. Problem Statement

Permasalahan utama yang ingin diselesaikan:

* Proses pelaporan terlalu banyak dilakukan secara manual.
* Data maintenance tersebar di berbagai media (WhatsApp, Excel, Folder Foto, PDF).
* Sulit mencari histori maintenance mesin.
* Penginputan hasil pengukuran masih dilakukan secara manual dari foto.
* Pembuatan laporan membutuhkan waktu hampir sama lamanya dengan proses maintenance.

---

# 4. Vision

Menjadi sistem reporting Preventive Maintenance yang sederhana, cepat, dan terintegrasi untuk membantu teknisi melakukan inspeksi, dokumentasi, serta pembuatan laporan secara digital dengan meminimalkan pekerjaan administratif.

---

# 5. Mission

* Mengurangi proses pelaporan manual.
* Mempercepat proses Preventive Maintenance.
* Menjadikan database sebagai sumber utama seluruh laporan.
* Mengurangi kesalahan input data.
* Memudahkan pencarian histori maintenance.
* Membantu teknisi melalui OCR yang dapat membaca hasil pengukuran dari foto.

---

# 6. Project Objectives

Tujuan utama proyek:
* Digitalisasi seluruh proses Preventive Maintenance.
* Menghilangkan proses input data berulang.
* Menghasilkan laporan WhatsApp secara otomatis.
* Menghasilkan laporan PDF secara otomatis.
* Menghasilkan rekap Excel secara otomatis.
* Membuat histori maintenance tersimpan dalam database.
* Membantu pembacaan hasil Generator Test menggunakan OCR dengan tetap memberikan kesempatan teknisi untuk melakukan koreksi sebelum data disimpan.

---

# 7. Target Users

Pengguna utama:
* Teknisi Maintenance X-Ray

Pengguna pendukung:
* Supervisor Maintenance

Pengguna masa depan (opsional):
* Manager
* Administrator Sistem

---

# 8. Project Scope (V1)

Fitur utama pada versi pertama:

## Authentication
* Login
* Logout
* Role User

## Master Data
* Teknisi
* Lokasi
* Equipment
* Jenis Preventive Maintenance

## Preventive Maintenance
* Scan QR Code
* Checklist
* Measurement Manual
* Foto Evidence
* Watermark Otomatis
* Submit PM

## OCR Assist
* Mengambil foto Generator Test.
* Melakukan preprocessing gambar.
* Membaca nilai menggunakan OCR.
* Menampilkan hasil OCR kepada teknisi.
* Teknisi dapat mengedit hasil OCR.
* Menyimpan nilai final yang telah dikonfirmasi.

## Reporting
* Generate WhatsApp Report.
* Generate PDF.
* Export Excel.

## Dashboard
* PM Hari Ini.
* Histori Maintenance.
* Detail PM.

---

# 9. Out of Scope (V1)

Fitur berikut tidak termasuk pada versi pertama:
* Predictive Maintenance
* AI Analysis
* Integrasi WhatsApp API
* Push Notification
* Reminder PM
* KPI Dashboard
* GPS Tracking
* Inventory Sparepart
* Corrective Maintenance
* Work Order
* Asset Management
* Multi Site
* Multi Project

---

# 10. Success Criteria

## Functional
* Teknisi dapat menyelesaikan PM melalui aplikasi.
* Laporan WhatsApp dibuat otomatis.
* PDF dibuat otomatis.
* Excel dibuat otomatis.
* Histori maintenance dapat dicari dengan mudah.

## Technical
* OCR mampu membaca hasil Generator Test.
* Sistem melakukan preprocessing gambar sebelum OCR.
* Teknisi dapat mengoreksi hasil OCR.
* Data yang tersimpan merupakan hasil konfirmasi teknisi.
* Aplikasi tetap memiliki performa yang baik saat jumlah data bertambah.

---

# 11. Initial Technology Stack

Backend
* PHP Native (OOP)

Frontend
* HTML
* Bootstrap
* JavaScript
* AJAX

Database
* MySQL

Storage
* Local Storage (Server)

Platform
* Mobile Web / PWA (Tahap Awal)
* Web Dashboard Admin

---

# 12. Version Roadmap

## V1

Digitalisasi proses Preventive Maintenance.

Fokus:
* Checklist
* Evidence
* OCR Assist
* Watermark
* WA Report
* PDF
* Excel
* Dashboard

## V2

Peningkatan produktivitas teknisi.
* Akurasi OCR
* Validasi otomatis
* Trend Measurement
* Offline Draft & Sinkronisasi
* Dukungan lebih banyak model mesin

## V3

Pengembangan manajemen.
* Reminder PM
* KPI Dashboard
* Analytics
* Audit Log
* Multi Site
* Multi Project

---

# 13. Guiding Principle

> **Teknisi fokus pada maintenance, sistem fokus pada administrasi.**
Seluruh keputusan desain dan pengembangan aplikasi harus mengacu pada prinsip ini.

---

# 14. Current Status

Status proyek saat dokumen ini dibuat:
* Analisis kebutuhan: Berjalan
* Desain sistem: Belum dimulai
* Database: Belum dirancang
* Pengembangan: Belum dimulai

---

# 15. Next Document

Dokumen selanjutnya:
**01-vision-scope.md**
