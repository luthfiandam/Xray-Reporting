# Coding Guidelines

Version 1.0

---

# Objective

Dokumen ini mendefinisikan standar penulisan kode agar seluruh project memiliki struktur yang konsisten, mudah dipelajari, mudah dirawat, dan mudah dikembangkan.

---

# General Rules

- Gunakan OOP.
- Hindari Hardcode.
- Hindari Duplicate Code.
- Selalu gunakan Reusable Component.
- Selalu pikirkan Scalability.
- Selalu ikuti SOLID Principle.
- Selalu ikuti DRY Principle.
- Selalu gunakan Separation of Concern.

---

# Folder Structure

app/

Controllers/

Services/

Repositories/

Models/

DTO/

Requests/

Policies/

Traits/

Helpers/

Storage/

OCR/

Reports/

Jobs/

Events/

Middleware/

---

# Controller

Controller hanya boleh:

- menerima request
- validasi
- memanggil Service
- mengembalikan response

Controller tidak boleh memiliki Business Logic.

---

# Service

Service berisi seluruh Business Logic.

Semua keputusan sistem berada di sini.

---

# Repository

Repository hanya berkomunikasi dengan Database.

Tidak boleh ada Business Logic.

---

# Model

Model hanya mendeskripsikan Entity.

---

# Validation

Seluruh validasi dipisahkan.

Tidak boleh validasi di Controller.

---

# Storage

Semua upload file menggunakan Storage Service.

---

# OCR

OCR dibuat sebagai module tersendiri.

Jangan campurkan OCR dengan Controller.

---

# Report

WA

PDF

Excel

menggunakan Report Service.

---

# API Response

Seluruh Response menggunakan format yang sama.

{
success,

message,

data

}

---

# Error Response

{
success,

message,

errors

}

---

# Logging

Semua Exception dicatat.

---

# Transaction

Seluruh proses Submit PM menggunakan Database Transaction.

---

# Migration

Seluruh perubahan database menggunakan Migration.

Tidak boleh edit database manual.

---

# Naming

Class

PascalCase

Method

camelCase

Variable

camelCase

Database

snake_case

Migration

timestamp_name

---

# Code Review Checklist

Sebelum Merge:

- Tidak ada Hardcode
- Tidak ada Duplicate Code
- Tidak ada Business Logic di Controller
- Tidak ada Query di View
- Tidak ada SQL Injection