$('.chat-item').on('click', function(e) {
    e.preventDefault();

    $('.chat-detail-content').addClass('d-none');

    $('#chat-placeholder').addClass('d-none');

    const ticketId = $(this).data('ticket-id');

    $(`#detail-chat-${ticketId}`).removeClass('d-none');
  });