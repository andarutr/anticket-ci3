$("#table").DataTable({
    ordering: false,
    ajax: {
        type: "GET",
        url: "/supervisor/history/getdata"
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
                `;
            }
        },
    ]
});

function viewTicket(ticketId) {
    const modal = new bootstrap.Modal(document.getElementById('viewModal'));
    modal.show();

    $('#viewModalContent').html('<p>Loading...</p>');

    $.ajax({
        url: `/supervisor/ticket/getById/${ticketId}`,
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