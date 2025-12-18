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

    const maxInputs = 5;

    $('#addFileInput').on('click', function() {
        const container = $('#fileInputsContainer');
        const currentCount = container.find('.file-input-wrapper').length;

        if (currentCount >= maxInputs) {
            Swal.fire('Maksimal!', `Anda hanya dapat menambahkan maksimal ${maxInputs} file.`, 'warning');
            return;
        }

        const newWrapper = $(`
            <div class="file-input-wrapper mb-2">
                <div class="input-group">
                    <input type="file" name="files[]" class="form-control file-input" accept=".png,.jpg,.jpeg">
                    <button class="btn btn-danger remove-file-btn" type="button">Hapus</button>
                </div>
            </div>
        `);

        container.append(newWrapper);
    });

    $(document).on('click', '.remove-file-btn', function() {
        $(this).closest('.file-input-wrapper').remove();
    });

	$('#requestForm').on('submit', function(e) {
		e.preventDefault();

		const formData = new FormData(this);

		$.ajax({
			url: '/user/ticket/reportbug/store',
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
					Swal.fire('Berhasil','Report Bug berhasil dikirim!','success');
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