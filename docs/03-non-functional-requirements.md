# Non Functional Requirements

---

# Performance

- Waktu buka halaman maksimal 3 detik.
- Generate WA < 2 detik.
- Generate PDF < 10 detik.
- OCR diproses secepat mungkin tanpa mengganggu alur teknisi.

---

# Availability

- Sistem dapat digunakan selama jam operasional.
- Jika koneksi terputus, data PM dapat disimpan sebagai draft lokal dan disinkronkan saat koneksi kembali tersedia.

---

# Reliability

- Data tidak boleh hilang saat submit.
- Upload foto harus tervalidasi.
- OCR tidak langsung menyimpan hasil tanpa konfirmasi teknisi.

---

# Security

- Password dienkripsi.
- Session memiliki timeout.
- Role Based Access.
- Validasi seluruh input.

---

# Maintainability

- Tidak boleh ada hardcode.
- Business Logic dipisahkan dari View.
- Struktur modular.
- Mudah menambah equipment baru.

---

# Scalability

Harus mendukung:

- Penambahan lokasi.
- Penambahan teknisi.
- Penambahan equipment.
- Penambahan template checklist.

tanpa perubahan besar pada arsitektur.

---

# Usability

- Mobile First.
- Tombol mudah dijangkau.
- Form sederhana.
- Maksimal tiga langkah untuk membuat PM.

---

# Compatibility

Mendukung:

- Android
- Google Chrome
- Microsoft Edge

---

# Backup

Database dapat dibackup.

Foto dapat dibackup.

---

# Logging

Semua aktivitas penting dicatat.

Contoh:

- Login
- Submit PM
- OCR dijalankan
- Edit hasil OCR
- Generate PDF

---

# Auditability

Supervisor dapat mengetahui:

- Siapa membuat PM.
- Siapa mengubah data.
- Waktu perubahan.
- Riwayat perubahan.

---

# OCR Requirements

OCR harus:

- Melakukan preprocessing gambar.
- Mendukung crop area tertentu.
- Menampilkan confidence (jika tersedia).
- Memberikan hasil yang dapat diedit teknisi.
- Menyimpan hasil akhir yang telah dikonfirmasi.

---

# Design Principles

- Single Source of Truth.
- DRY (Don't Repeat Yourself).
- Reusable Component.
- Separation of Concern.
- Service Layer.
- Repository Pattern.