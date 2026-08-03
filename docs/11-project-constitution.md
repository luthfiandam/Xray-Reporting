# Project Constitution

Version: 1.0

Dokumen ini adalah aturan utama pengembangan proyek.

Seluruh implementasi wajib mengikuti dokumen ini.

---

# 1. General Principles

- Jangan mengubah arsitektur tanpa persetujuan.
- Jangan membuat fitur di luar requirement.
- Jangan melakukan hardcode.
- Hindari duplikasi kode.
- Selalu gunakan reusable component.

---

# 2. Architecture

Gunakan Layer:

Controller

↓

Service

↓

Repository

↓

Database

Business Logic tidak boleh berada di Controller.

---

# 3. Single Source of Truth

Database adalah sumber utama data.

WA

PDF

Excel

harus dibuat dari database.

Tidak boleh membuat laporan dari input form secara langsung.

---

# 4. PM Session

PM Session adalah root entity.

Checklist

Measurement

Evidence

Report

harus memiliki PM Session.

---

# 5. OCR

OCR adalah Assist.

Bukan sumber data utama.

Seluruh hasil OCR wajib dikonfirmasi teknisi.

---

# 6. Database

Gunakan Foreign Key.

Gunakan Migration.

Tidak boleh query langsung di View.

---

# 7. Coding

Gunakan OOP.

Pisahkan:

Validation

Business Logic

Storage

OCR

Report

---

# 8. Reusable

Checklist tidak boleh hardcode.

Measurement tidak boleh hardcode.

Equipment tidak boleh hardcode.

Semua menggunakan Template.

---

# 9. Naming Convention

Class

PascalCase

Method

camelCase

Variable

camelCase

Database

snake_case

API

kebab-case

---

# 10. Error Handling

Semua error harus:

- jelas
- mudah dipahami
- tercatat di log

---

# 11. Upload

Seluruh upload melalui Storage Service.

Tidak boleh upload langsung dari Controller.

---

# 12. Security

Password di-hash.

Validasi seluruh input.

Role Based Access.

---

# 13. Logging

Catat:

Login

Logout

Submit PM

OCR

Generate Report

Export

---

# 14. Performance

Jangan query berulang.

Gunakan eager loading bila diperlukan.

Optimalkan upload gambar.

---

# 15. Future Proof

Semua fitur harus mudah dikembangkan.

Tidak boleh membuat kode yang hanya berlaku untuk satu mesin.

Gunakan Template.

Gunakan Konfigurasi.

Gunakan Parameter.