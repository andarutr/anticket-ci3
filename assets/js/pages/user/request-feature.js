$(document).ready(function() {
	$("#system_id").select2();
	$("#priority").select2();

	const quill = new Quill('#description', {
		theme: 'snow'
	});

	quill.on('text-change', function(delta, oldDelta, source) {
		if (source === 'user') {
			document.getElementById('descValue').value = quill.root.innerHTML;
		}
	});

	$('#requestForm').on('submit', function(e) {
		e.preventDefault();

		const formData = new FormData(this);

		$.ajax({
			url: '/user/ticket/requestfeature/store',
			type: 'POST',
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$('button[type=submit]').prop('disabled', true).text('Processing...');
			},
			success: function(response) {
				if (response.status === 'success') {
					Swal.fire('Berhasil','Request berhasil dikirim!','success');
					$('#requestForm')[0].reset();
					quill.setContents([]);
				} else {
					Swal.fire('Gagal', response.message, 'error');
				}
			},
			error: function(xhr) {
				console.error(xhr.responseText);
				Swal.fire('Ops','Kesalahan jaringan atau server.','error');
			},
			complete: function() {
				$('button[type=submit]').prop('disabled', false).text('Submit');
			}
		});
	});
});