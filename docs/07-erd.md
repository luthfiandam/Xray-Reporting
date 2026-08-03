# Entity Relationship Diagram (ERD)

Version: 1.0 Draft

---

# Core Principle

PM Session adalah pusat seluruh transaksi.

Semua data Preventive Maintenance harus memiliki satu PM Session.

---

# Master Entity

User
│
├── Role

Location

Equipment Type

Equipment

PM Type

Checklist Template

Measurement Template

---

# Transaction Entity

PM Session

Checklist Result

Measurement Result

Evidence

OCR Result

---

# Report Entity

WA Report

PDF Report

Excel Export Log

---

# Relationship

Role

↓

User

↓

PM Session

├── Equipment
├── PM Type
├── User
├── Checklist Result
├── Measurement Result
├── Evidence
├── OCR Result

↓

Report Generator

├── WA
├── PDF
└── Excel

---

# ERD Concept

Role
 │
 └──────── User
               │
               │
               ▼
          PM Session
          │    │
          │    │
          │    ├──────── Evidence
          │
          ├──────── Checklist Result
          │
          ├──────── Measurement Result
          │
          └──────── OCR Result

Equipment Type
      │
      ▼
 Equipment
      │
      ▼
 PM Session

Location
      │
      ▼
 Equipment