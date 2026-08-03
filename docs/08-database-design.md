# Database Design

Version: 1.0

---

# users

id

role_id

name

username

password

status

created_at

updated_at

---

# roles

id

name

---

# locations

id

code

name

description

---

# equipment_types

id

name

---

# equipments

id

location_id

equipment_type_id

code

name

serial_number

qr_code

status

---

# pm_types

id

name

interval

---

# checklist_templates

id

equipment_type_id

pm_type_id

name

sequence

required

---

# measurement_templates

id

equipment_type_id

name

unit

minimum_value

maximum_value

sequence

---

# pm_sessions

id

equipment_id

pm_type_id

user_id

started_at

submitted_at

status

notes

---

# checklist_results

id

pm_session_id

checklist_template_id

value

remarks

---

# measurement_results

id

pm_session_id

measurement_template_id

value

unit

input_method

---

# evidences

id

pm_session_id

filename

filepath

watermark

taken_at

---

# ocr_results

id

pm_session_id

raw_text

parsed_json

confidence

edited

edited_by

edited_at

---

# report_logs

id

pm_session_id

report_type

generated_at

generated_by