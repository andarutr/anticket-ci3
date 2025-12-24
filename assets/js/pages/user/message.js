function showMessageDetail(id_ticket, no_ticket, developer_name, system_name){
    $.ajax({
        type: "GET",
        url: "/user/chat/message/getChatDetail",
        data: {
            id: id_ticket
        },
        success: function(res){
            console.log(res);
            $("#containerChatDetail").empty();
            $("#containerChatDetail").append(`
                <div id="detail-chat-1" class="chat-detail-content">
                    <div class="chat-header mb-3">
                        <h5 id="chat-ticket-title-1">&nbsp;&nbsp;&nbsp;#${no_ticket} - ${system_name}</h5>
                    </div>
                    <div class="chat-messages p-3 border rounded mb-3" style="height: 400px; overflow-y: auto;">
                        <div class="message mb-2">
                        <div class="d-flex justify-content-start">
                            <div class="bg-primary text-white p-2 rounded">
                            <small>Halo, saya ingin menanyakan tentang fitur absensi.</small><br>
                            <small>User - 24/12/2025 10:05</small>
                            </div>
                        </div>
                        </div>
                        <div class="message mb-2">
                        <div class="d-flex justify-content-end">
                            <div class="bg-light p-2 rounded">
                            <small>Baik, fitur absensi saat ini sedang dalam pengembangan.</small><br>
                            <small>Andaru Triadi - 24/12/2025 10:15</small>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" id="message-input-1" placeholder="Ketik pesan...">
                        <button class="btn btn-primary" id="send-btn-1">Kirim</button>
                    </div>
                </div>
            `);
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