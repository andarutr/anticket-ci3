const currentUserName = $("#nameUser").text();

function showMessageDetail(id_ticket, no_ticket, developer_name, system_name){
    $.ajax({
        type: "GET",
        url: "/worker/chat/message/getChatDetail",
        data: {
            id: id_ticket
        },
        success: function(res){
            let html = `
                <div id="detail-chat-1" class="chat-detail-content">
                    <div class="chat-header mb-3">
                        <h5 id="chat-ticket-title-1">&nbsp;&nbsp;&nbsp;#${no_ticket} - ${system_name}</h5>
                    </div>

                    <div class="chat-messages p-3 border rounded mb-3" style="height: 400px; overflow-y: auto;">
            `;

            res.forEach(function(item, index){
                let badge = '';
                // console.log(item.name_sender);
                // console.log(currentUserName);
                if(item.name_sender != currentUserName){
                    badge = 'bg-light text-dark';
                }else{
                    badge = 'bg-primary text-white';
                }
                
                html += `
                    <div class="message mb-2">
                        <div class="d-flex justify-content-start">
                            <div class="${badge} p-2 rounded">
                                <small>${item.message}</small><br>
                                <small>${item.name_sender || 'Unknown'} - ${item.created_at}</small>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" id="message" placeholder="Ketik pesan...">
                        <button class="btn btn-primary" id="send-btn-1" onClick="submitMessage('${id_ticket}', '${no_ticket}', '${developer_name}', '${system_name}')">Kirim</button>
                    </div>
                </div>
            `;
            $("#containerChatDetail").empty();
            $("#containerChatDetail").append(html);
        }
    })
}

function submitMessage(id_ticket, no_ticket, developer_name, system_name){
    let message = $("#message").val();
    if(message == '' || message == null){
        Swal.fire("info", "Pesan harus diisi!", "info");
        return;
    }

    $.ajax({
        type: "POST",
        url: "/worker/chat/message/send",
        data: {
            id: id_ticket,
            message: message
        },
        success: function(res){
            $("#message").val('');
            showMessageDetail(id_ticket, no_ticket, developer_name, system_name);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            Swal.fire("Error", "Terjadi kesalahan jaringan.", "error");
        }
    })
}

$('.chat-item').on('click', function(e) {
    e.preventDefault();

    $('.chat-detail-content').addClass('d-none');

    $('#chat-placeholder').addClass('d-none');

    const ticketId = $(this).data('ticket-id');

    $(`#detail-chat-${ticketId}`).removeClass('d-none');
});