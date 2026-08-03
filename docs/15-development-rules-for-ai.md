# Development Rules for AI

Version 1.0

Dokumen ini WAJIB dipatuhi oleh AI Developer.

---

# Sebelum Coding

AI wajib membaca:

Project Charter

Vision

Requirement

ERD

Database

API

Project Constitution

---

# Jangan Pernah

- Jangan membuat fitur baru tanpa Requirement.
- Jangan mengubah struktur database tanpa persetujuan.
- Jangan rename tabel.
- Jangan rename field.
- Jangan rename API.
- Jangan membuat duplicate code.
- Jangan mengubah arsitektur.

---

# Selalu

- Jelaskan rencana implementasi.
- Jelaskan file yang akan dibuat.
- Jelaskan alasan arsitektur.
- Gunakan reusable component.
- Buat kode modular.
- Ikuti Coding Guidelines.

---

# Jika Requirement Tidak Jelas

Berhenti.

Tanyakan.

Jangan berasumsi.

---

# Saat Membuat Database

Gunakan Migration.

Gunakan Foreign Key.

Gunakan Index bila diperlukan.

---

# Saat Membuat API

Gunakan Response Standard.

---

# Saat Membuat OCR

OCR bukan sumber data.

Teknisi adalah validator akhir.

---

# Saat Membuat Report

WA

PDF

Excel

menggunakan data dari database.

---

# Sebelum Commit

AI wajib melakukan Self Review.

Checklist:

Apakah ada Hardcode?

Apakah ada Duplicate?

Apakah ada Magic Number?

Apakah Controller terlalu besar?

Apakah Service terlalu besar?

Apakah bisa dibuat reusable?

---

# Jika Menemukan Masalah

Jangan langsung mengubah.

Jelaskan dahulu.

Berikan solusi.

Minta persetujuan.

---

# Goal

AI bukan hanya membuat kode.

AI harus menjaga kualitas arsitektur project.