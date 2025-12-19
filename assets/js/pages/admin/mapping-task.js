$("#table").DataTable({
    ordering: false,
    ajax: {
        type: "GET",
        url: "/admin/mappingtask/getdata"
    },
    columns: [
        { 
            data: "no_ticket",
            render: function(data, type, row){
                return `#${data}`;
            }
        },
        { data: "system_name" },
        { 
            data: "category",
            render: function(data, type, row){
                let badge = '';

                if(data == 'system'){
                    badge = `<span class="badge bg-info text-white">${data}</span>`
                } else if(data == 'feature'){
                    badge = `<span class="badge bg-primary text-white">${data}</span>`
                } else if(data == 'bug'){
                    badge = `<span class="badge bg-danger text-white">${data}</span>`
                } else{
                    badge = `<span class="badge bg-success text-white">${data}</span>`
                }

                return badge;
            }
        },
        { data: "requestor_name" },
        { 
            data: "priority",
            render: function(data, type, row){
                let badge = '';

                if(data == 'high'){
                    badge = `<span class="badge bg-danger text-white">${data}</span>`
                }else if(data == 'medium'){
                    badge = `<span class="badge bg-warning text-white">${data}</span>`
                }else{
                    badge = `<span class="badge bg-success text-white">${data}</span>`
                }

                return badge;
            }
        },
        { data: "deadline" },
        { data: "status" },
        { 
            data: null,
            render: function(data, type, row){
                return `
                <span class="badge bg-success" onclick="viewTicket(${row.id})"><i class="bi bi-eye"></i></span>
                    <span class="badge bg-primary text-white" onclick="mappingTicket(${row.id})" title="Mapping"><i class="bi bi-bounding-box"></i></span>
                `;
            }
        },
    ]
});

function assignTaskToWorker(ticketId, workerId) {
    confirmAssignBtn.disabled = true;
    workerSelect.disabled = true;
    confirmAssignBtn.textContent = 'Assigning...';

    $.ajax({
        url: '/admin/mappingtask/assigntask', 
        type: 'POST',
        data: {
            ticket_id: ticketId,
            user_id: workerId
        },
        dataType: 'json',
        success: function(response) {
            if(response.status === 'success') {
                Swal.fire('Berhasil','Task berhasil diassign!','success');
                $('#assignWorkerModal').modal('hide');
                $('#table').DataTable().ajax.reload(null, false);
            } else {
                Swal.fire('Gagal',`Gagal mengassign task: ${response.message}`,'error');
                console.error('Server error on assign:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error assigning task:', error);
            Swal.fire('Gagal','Terjadi kesalahan saat mengassign task.','error');
        },
        complete: function() {
            confirmAssignBtn.disabled = false;
            workerSelect.disabled = false;
            confirmAssignBtn.textContent = 'Assign';
        }
    });
}

function mappingTicket(ticketId) {
    $('#ticketIdForAssignment').val(ticketId);

    $('#workerSelect')
        .empty() 
        .append('<option value="">Loading...</option>')
        .prop('disabled', true); 

    $('#assignWorkerModal').modal('show');

    loadWorkers();
}

function loadWorkers() {
    const ticketId = $('#ticketIdForAssignment').val();

    if (!ticketId) {
        console.error("Ticket ID tidak valid untuk loadWorkers.");
        $('#workerSelect')
            .empty()
            .append('<option value="">Error: Invalid Ticket</option>');
        return;
    }

    $.ajax({
        url: '/admin/mappingtask/getworkers', 
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#workerSelect').empty();

            if(response.status === 'success' && response.data && Array.isArray(response.data)) {
                const workers = response.data;
                if(workers.length > 0) {
                    workers.forEach(worker => {
                        const $option = $('<option></option>')
                            .attr('value', worker.id)
                            .text(`${worker.name} (${worker.nik})`);
                        $('#workerSelect').append($option);
                    });
                } else {
                    $('#workerSelect').append('<option value="">Tidak ada worker tersedia</option>');
                }
            } else {
                console.error('Gagal memuat worker:', response.message || 'Data tidak valid');
                $('#workerSelect').append('<option value="">Gagal memuat worker</option>');
            }
            $('#workerSelect').prop('disabled', false); 
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error fetching workers:', error);
            $('#workerSelect')
                .empty()
                .append('<option value="">Error memuat worker</option>');
            $('#workerSelect').prop('disabled', false); 
        }
    });
}

$(document).ready(function() {
    $('#confirmAssignBtn').on('click', function() {
        const selectedWorkerId = $('#workerSelect').val();
        const ticketId = $('#ticketIdForAssignment').val();

        if (!selectedWorkerId) {
            alert('Silakan pilih seorang worker.');
            return;
        }

        assignTaskToWorker(ticketId, selectedWorkerId);
    });
});

function viewTicket(ticketId) {
    const modal = new bootstrap.Modal(document.getElementById('viewModal'));
    modal.show();

    $('#viewModalContent').html('<p>Loading...</p>');

    $.ajax({
        url: `/admin/mappingtask/getById/${ticketId}`,
        type: 'GET',
        dataType: 'json', 
        success: function(response) {
            if(response.status === 'success' && response.data) {
                const ticket = response.data;

                let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>No Ticket:</strong> #${ticket.no_ticket}</p>
                            <p><strong>System:</strong> ${ticket.system_name || 'N/A'}</p>
                            <p><strong>Type:</strong> 
                                <span class="badge ${
                                    ticket.category === 'system' ? 'bg-info' :
                                    ticket.category === 'feature' ? 'bg-primary' :
                                    ticket.category === 'bug' ? 'bg-danger' : 'bg-success'
                                } text-white">${ticket.category}</span>
                            </p>
                            <p><strong>Requestor:</strong> ${ticket.requestor_name} (${ticket.requestor_nik})</p>
                            <p><strong>Priority:</strong> 
                                <span class="badge ${
                                    ticket.priority === 'high' ? 'bg-danger' :
                                    ticket.priority === 'medium' ? 'bg-warning' : 'bg-success'
                                } text-white">${ticket.priority}</span>
                            </p>
                            <p><strong>Status:</strong> 
                                <span class="badge ${
                                    ticket.status === 'waiting approval' ? 'bg-warning' :
                                    ticket.status === 'approved' ? 'bg-success' :
                                    ticket.status === 'on progress' ? 'bg-info' :
                                    ticket.status === 'done' ? 'bg-secondary' :
                                    ticket.status === 'closed' ? 'bg-dark' : 'bg-light'
                                }">${ticket.status}</span>
                            </p>
                            <p><strong>Deadline:</strong> ${ticket.deadline || 'Not set'}</p>
                            <p><strong>Requested At:</strong> ${ticket.requested_at || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Description:</strong></p>
                            <div class="border p-3 bg-light rounded">
                                ${ticket.description ? ticket.description.replace(/\n/g, '<br>') : '<em>No description provided.</em>'}
                            </div>
                            <p><strong>URLs:</strong></p>
                            <div class="border p-3 bg-light rounded">
                                ${ticket.urls ? ticket.urls.split(',').map(url => `<a href="${url.trim()}" target="_blank">${url.trim()}</a><br>`).join('') : '<em>No URLs provided.</em>'}
                            </div>
                        </div>
                    </div>
                `;

                $('#viewModalContent').html(html);

            } else {
                $('#viewModalContent').html('<div class="alert alert-danger">Could not load ticket details.</div>');
                console.error('Error loading ticket:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error fetching ticket details for view:', error);
            $('#viewModalContent').html('<div class="alert alert-danger">An error occurred while loading ticket details.</div>');
        }
    });
}