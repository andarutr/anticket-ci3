$("#table").DataTable({
    ajax: {
        type: "GET",
        url: "/supervisor/ticket/getdata"
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
        { data: "deadline" },
        { data: "status" },
        { 
            data: null,
            render: function(data, type, row){
                return `
                    <span class="badge bg-info text-white"><i class="bi bi-eye"></i></span>
                    <span class="badge bg-primary text-white"><i class="bi bi-calendar"></i></span>
                    <span class="badge bg-success text-white"><i class="bi bi-clipboard-check"></i></span>
                    <span class="badge bg-danger text-white"><i class="bi bi-clipboard-x"></i></span>
                `;
            }
        },
    ]
});