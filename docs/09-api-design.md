# API Design

Version 1.0

---

# Authentication

POST

/api/login

POST

/api/logout

GET

/api/profile

---

# User

GET

/api/users

POST

/api/users

PUT

/api/users/{id}

DELETE

/api/users/{id}

---

# Location

GET

/api/locations

POST

/api/locations

PUT

/api/locations/{id}

DELETE

/api/locations/{id}

---

# Equipment

GET

/api/equipments

GET

/api/equipments/{qr}

POST

/api/equipments

PUT

/api/equipments/{id}

DELETE

/api/equipments/{id}

---

# PM Session

POST

/api/pm

GET

/api/pm

GET

/api/pm/{id}

PUT

/api/pm/{id}

POST

/api/pm/{id}/submit

---

# Checklist

GET

/api/checklist/template

POST

/api/checklist/result

---

# Measurement

GET

/api/measurement/template

POST

/api/measurement/result

---

# OCR

POST

/api/ocr/read

Response

Raw OCR

↓

Parsing

↓

Measurement

↓

Edit

↓

Save

---

# Evidence

POST

/api/evidence/upload

DELETE

/api/evidence/{id}

GET

/api/evidence/{id}

---

# Report

GET

/api/report/wa/{pm}

GET

/api/report/pdf/{pm}

GET

/api/report/excel

---

# Dashboard

GET

/api/dashboard

GET

/api/dashboard/history

GET

/api/dashboard/today

---

# Backup

POST

/api/backup