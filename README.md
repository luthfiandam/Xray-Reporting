# X-Ray Reporting System

> Web-based Preventive & Corrective Maintenance Management System for X-Ray Machines.

---

# Project Status

**Current Version**

```
v1.0.0 (Development)
```

Current Progress
- [x] Requirement Analysis
- [x] Documentation
- [x] Database Design
- [x] ERD
- [x] Laravel Installation
- [x] Database Migration
- [x] Database Seeder

---

# Technology Stack

Backend
- Laravel 12
- PHP 8.4+
- MySQL 8
- Eloquent ORM

Frontend
- Blade
- Bootstrap 5
- JavaScript
- Vite

Storage
- Local Storage
- Public Storage

Future
- OCR
- WhatsApp Report
- PDF Generator
- Excel Export
- Progressive Web App (PWA)

---

# Folder Structure

```
app/
bootstrap/
config/
database/
docs/
public/
resources/
routes/
storage/
tests/
```

---

# Development Roadmap
---
# Phase 1 — Foundation ✅
Status
- [x] Laravel Installation
- [x] Git Repository
- [x] Database Design
- [x] ERD
- [x] Migration
- [x] Seeder
---
# Phase 2 — Core Backend
Status
- [x] Models
- [x] Relationships
- [x] Authentication
- [x] Role Middleware
- [x] Authorization Policy
- [x] Form Request Validation
- [x] Service Layer
- [x] Helper Functions
- [x] Enum
- [x] Factory
---
## 2.1 Models
Target
- Every database table has its own Eloquent Model.
Checklist
- [ ] Role
- [ ] User
- [ ] Location
- [ ] EquipmentType
- [ ] Equipment
- [ ] MaintenanceFrequency
- [ ] ChecklistCategory
- [ ] ChecklistTemplate
- [ ] ChecklistTemplateItem
- [ ] MeasurementTemplate
- [ ] WorkOrder
- [ ] ChecklistResult
- [ ] MeasurementResult
- [ ] Evidence
- [ ] OCRResult
- [ ] Report
---
## 2.2 Relationship
Target
Connect all models using Eloquent Relationship.
Checklist
- [ ] belongsTo
- [ ] hasMany
- [ ] belongsToMany
- [ ] hasOne
---
## 2.3 Authentication
Checklist
- [ ] Login
- [ ] Logout
- [ ] Remember Login
- [ ] Session
- [ ] Password Hashing
---
## 2.4 Authorization
Checklist
- [ ] Super Admin
- [ ] Admin
- [ ] Technician
- [ ] Viewer
---
## 2.5 Middleware
Checklist
- [ ] Role Middleware
- [ ] Permission Middleware
---
## 2.6 Validation
Checklist
- [ ] Form Request
- [ ] Custom Validation
- [ ] Error Response
---
## 2.7 Service Layer
Checklist
- [ ] WorkOrderService
- [ ] ReportService
- [ ] OCRService
- [ ] ImageService
---
## 2.8 Helper
Checklist
- [ ] Generate Work Order Number
- [ ] Image Helper
- [ ] Date Helper
- [ ] Watermark Helper
---
## 2.9 Enum
Checklist
- [ ] User Status
- [ ] Equipment Status
- [ ] Work Order Status
- [ ] Maintenance Type
---
## 2.10 Factory
Checklist
- [ ] UserFactory
- [ ] EquipmentFactory
- [ ] WorkOrderFactory
---
# Phase 3 — Master Data
Status
- [ ] Role
- [ ] User
- [ ] Location
- [ ] Equipment Type
- [ ] Equipment
- [ ] Maintenance Frequency
- [ ] Checklist Category
- [ ] Checklist Template
- [ ] Checklist Template Item
---
# Phase 4 — Preventive Maintenance
Checklist
- [ ] PM Schedule
- [ ] Create Work Order
- [ ] Checklist
- [ ] Measurement
- [ ] Upload Evidence
- [ ] Finish Work Order
---
# Phase 5 — Corrective Maintenance
Checklist
- [ ] Create Corrective WO
- [ ] Problem Description
- [ ] Root Cause
- [ ] Corrective Action
- [ ] Downtime
- [ ] Evidence
---
# Phase 6 — OCR
Checklist
- [ ] OCR Upload
- [ ] OCR Parsing
- [ ] OCR Validation
- [ ] OCR Storage
---
# Phase 7 — Report
Checklist
- [ ] PDF Report
- [ ] Excel Export
- [ ] WhatsApp Report
- [ ] Email Report
---
# Phase 8 — Dashboard
Checklist
- [ ] Total Work Order
- [ ] PM Progress
- [ ] Corrective Progress
- [ ] Equipment Health
- [ ] Reminder
- [ ] Charts
---
# Phase 9 — PWA
Checklist
- [ ] Offline Mode
- [ ] Camera
- [ ] Sync
- [ ] Cache
- [ ] Install App
---
# Phase 10 — Deployment
Checklist
- [ ] Production Server
- [ ] SSL
- [ ] Domain
- [ ] Backup
- [ ] Monitoring
- [ ] Logging
---
# Development Rules
- Always use Laravel Best Practice.
- Keep Controllers thin.
- Put business logic inside Services.
- Validate using Form Request.
- Use Eloquent Relationship.
- Avoid duplicated code.
- Follow PSR-12 Coding Standard.
- Write reusable code.
- Think about scalability before coding.
---
# Current Milestone
Current Focus
```
Phase 2
Core Backend
```
Next Task
```
1. Models
2. Relationships
3. Authentication
4. Middleware
5. Authorization
6. Form Request
7. Service Layer
```
---
# Goal

Build a scalable, maintainable, and production-ready X-Ray Maintenance Management System using Laravel 12.