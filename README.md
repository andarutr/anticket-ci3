# anticket-ci3
Anticket adalah Ticket Management System yang dikhususkan untuk manajemen ticket worker. Aplikasi ini dibuat menggunakan Codeigniter 3, Bootstrap, jQuery, dan MySQL. Status: Improvement

## ERD
<img src="document/ERD Anticket.jpg" width="450">

## Flowchart
<img src="document/Flowchart Anticket.jpg" width="450">
Penjelasan:
- User melakukan pembuatan ticket (request system / request feature / report bug / meeting).
- Supervisor melakukan diskusi bersama manager dan worker atau stakeholder terkait.
- Supervisor melakukan approval atau reject.
- Admin melakukan mapping project baru kepada worker terkait.
- Setelah di mapping oleh admin, ticket akan masuk di backlog worker.
- Worker melakukan set schedule dan mengerjakan ticket sesuai dengan schedule yang telah ditetapkan.
- Ketika ticket sedang diproses, sudah selesai atau di reject maka otomatis user akan mendapatkan pemberitahuan melalui email (mailtrap testing).
- Ticket dinyatakan selesai bila user sudah melakukan closing ticket.

## Role
1. Root
2. User
3. Supervisor
4. Admin
5. Worker

## Account

### Root
- Nama: Wilcox
- Email: wilcox@emyu.test
- Nik: 12345
- Password: anticket123

### User
- Nama: Brian
- Email: brian@emyu.test
- Nik: 91011
- Password: anticket123

### Supervisor
- Nama: Amorim
- Email: amorim@emyu.test
- Nik: 891012
- Password: anticket123

### Admin
- Nama: Jason
- Email: jason@emyu.test
- Nik: 78910
- Password: anticket123

### Worker
- Nama: Andaru
- Email: andaru@emyu.test
- Nik: 67891
- Password: anticket123

## Config
- Import SQL file yang terletak di folder database.
- Ketik perintah `CALL migrationAll()` dan `CALL seedUser()`

## Plugin / Libraries
- jQuery
- Sweet Alert 2
- QuillJS
- Select2
- Captcha

## Feature
- [x] Monitoring Ticket.
- [x] Create Ticket (Request System, Request Feature, Report Bug, Request Meeting).
- [x] Approval Ticket.
- [x] Set Deadline & Priority Ticket.
- [x] Assign Ticket.
- [x] Backlog Ticket.
- [x] Execution Ticket (In Progress, Done, Reject).
- [x] User closed ticket.
- [x] Chatting With Worker or User.
- [x] Management User (Reset Pwd, and Block Account).
- [x] Update Profile (name, email, nik, password).
- [x] Full SQL Native