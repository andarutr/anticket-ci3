# anticket-ci3
Ticket Management System Menggunakan Codeigniter 3, Bootstrap, jQuery, dan MySQL. Status: In Progress...

## ERD
<img src="document/ERD Anticket.jpg">

## Flowchart
<img src="document/Flowchart Anticket.jpg">
Penjelasan:
- User melakukan pembuatan ticket (request system / request feature / report bug / meeting).
- Supervisor melakukan diskusi bersama manager dan worker atau stakeholder terkait.
- Supervisor melakukan approval atau reject.
- Admin melakukan mapping project baru kepada worker terkait.
- Setelah di mapping oleh admin, ticket akan masuk di backlog worker.
- Worker melakukan set schedule dan mengerjakan ticket sesuai dengan schedule yang telah ditetapkan.
- Ketika ticket sedang diproses, sudah selesai atau di reject maka otomatis user akan mendapatkan pemberitahuan melalui gmail.

## Role
1. Root
2. Worker
3. Admin
4. Supervisor

## Config
- Import SQL file yang terletak di folder database.
- Ketik perintah `CALL migrationAll()` dan `CALL seedUser()`