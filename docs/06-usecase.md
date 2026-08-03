# Use Case

---

# UC-001 Login

Actor

- Teknisi
- Supervisor
- Admin

Tujuan

Masuk ke aplikasi.

---

# UC-002 Scan QR

Actor

- Teknisi

Tujuan

Membuka data equipment.

---

# UC-003 Membuat PM

Actor

- Teknisi

Tujuan

Membuat Preventive Maintenance Session.

---

# UC-004 Mengisi Checklist

Actor

- Teknisi

Tujuan

Mengisi checklist sesuai template.

---

# UC-005 Menambahkan Measurement

Actor

- Teknisi

Tujuan

Menginput hasil pengukuran.

---

# UC-006 OCR Generator Test

Actor

- Teknisi

Tujuan

Membaca hasil Generator Test menggunakan OCR.

Main Flow

1. Ambil Foto.
2. Sistem melakukan preprocessing.
3. OCR membaca data.
4. Sistem menampilkan hasil.
5. Teknisi melakukan konfirmasi.
6. Data disimpan.

Alternative Flow

OCR gagal.

↓

Teknisi input manual.

---

# UC-007 Upload Evidence

Actor

- Teknisi

Tujuan

Menambahkan foto evidence.

---

# UC-008 Submit PM

Actor

- Teknisi

Tujuan

Menyelesaikan PM Session.

---

# UC-009 Dashboard

Actor

- Supervisor

Tujuan

Melihat progress PM.

---

# UC-010 History

Actor

- Supervisor

- Teknisi

Tujuan

Melihat histori maintenance.

---

# UC-011 Generate PDF

Actor

- Teknisi

- Supervisor

Tujuan

Menghasilkan laporan PDF.

---

# UC-012 Generate WA

Actor

- Teknisi

Tujuan

Membuat laporan WhatsApp otomatis.

---

# UC-013 Export Excel

Actor

- Supervisor

Tujuan

Menghasilkan laporan bulanan.

---

# UC-014 CRUD Equipment

Actor

- Admin

Tujuan

Mengelola data equipment.

---

# UC-015 CRUD User

Actor

- Admin

Tujuan

Mengelola user aplikasi.

---

# UC-016 Backup Database

Actor

- Admin

Tujuan

Melakukan backup database.