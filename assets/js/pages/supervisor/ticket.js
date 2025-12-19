$("#table").DataTable({
    ajax: {
        type: "GET",
        url: "/supervisor/ticket/getdata"
    },
    columns: [
        { 
            data: "no_ticket",
            render: function(data, type, row){
                return `#${data} <span class="badge bg-success" onclick="viewTicket(${row.id})"><i class="bi bi-eye"></i></span>`;
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
                    <span class="badge bg-primary text-white" onclick="editTicket(${row.id})" title="Edit"><i class="bi bi-pencil"></i></span>
                    <span class="badge bg-success text-white" onclick="approveTicket(${row.id})" title="Approve"><i class="bi bi-clipboard-check"></i></span>
                    <span class="badge bg-danger text-white" onclick="rejectTicket(${row.id})" title="Reject"><i class="bi bi-clipboard-x"></i></span>
                `;
            }
        },
    ]
});

function approveTicket(ticketId) {
    Swal.fire({
        title: 'Approve Ticket?',
        text: "Yakin ingin approve ticket ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745', 
        cancelButtonColor: '#6c757d', 
        confirmButtonText: 'Yakin!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/supervisor/ticket/approve/${ticketId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire(
                        'Approved!',
                        data.message,
                        'success'
                    ).then(() => {
                        $('#table').DataTable().ajax.reload(null, false);
                    });
                } else {
                    Swal.fire(
                        'Approval Failed!',
                        'Error: ' + data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Oops...',
                    'An error occurred while approving the ticket.',
                    'error'
                );
            });
        }
    });
}

function rejectTicket(ticketId) {
    Swal.fire({
        title: 'Reject Ticket?',
        text: "Yakin reject ticket ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545', 
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yakin!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/supervisor/ticket/reject/${ticketId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire(
                        'Rejected!',
                        data.message,
                        'success' 
                    ).then(() => {
                        $('#table').DataTable().ajax.reload(null, false);
                    });
                } else {
                    Swal.fire(
                        'Rejection Failed!',
                        'Error: ' + data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Oops...',
                    'An error occurred while rejecting the ticket.',
                    'error'
                );
            });
        }
    });
}

function editTicket(ticketId) {
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();

    $.ajax({
        url: `/supervisor/ticket/getById/${ticketId}`,
        type: 'GET',
        dataType: 'json', 
        success: function(response) {
            if(response.status === 'success' && response.data) {
                const ticket = response.data;
                $('#editTicketId').val(ticket.id);
                $('#editPriority').val(ticket.priority);
                $('#editDeadline').val(ticket.deadline);
            } else {
                Swal.fire('Error!', 'Could not load ticket details.', 'error');
                modal.hide();
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error fetching ticket details:', error);
            console.log('Response Text:', xhr.responseText); 
            Swal.fire('Oops...', 'An error occurred while loading ticket details.', 'error');
            modal.hide();
        }
    });
}

$('#saveChangesBtn').click(function() {
    const ticketId = $('#editTicketId').val();
    const priority = $('#editPriority').val();
    const deadline = $('#editDeadline').val();

    if (!priority || !deadline) {
        Swal.fire('Validation Error!', 'Priority and Deadline are required.', 'warning');
        return;
    }

    $.ajax({
        url: '/supervisor/ticket/update',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            id: ticketId,
            priority: priority,
            deadline: deadline
        }),
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire('Updated!', response.message, 'success');
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                $('#table').DataTable().ajax.reload(null, false);
            } else {
                Swal.fire('Update Failed!', 'Error: ' + response.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error updating ticket:', error);
            console.log('Response Text:', xhr.responseText); 
            Swal.fire('Oops...', 'An error occurred while updating the ticket.', 'error');
        }
    });
});

function viewTicket(ticketId) {
    alert(`View ticket ID: ${ticketId}`);
}