<div class="container-fluid py-4">
	<div class="row">
		<div class="col-12">
			<div class="card mb-4">
				<div class="card-header pb-0">
					<h6>Request Feature</h6>
				</div>
				<div class="card-body">
					<form id="requestForm">
						<div class="row mb-3">
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label>System</label>
                                    <select name="system_id" id="system_id" class="form-select" required>
                                        <option value="">Pilih</option>
                                        <?php foreach($systems as $system): ?>
                                            <option value="<?= $system->id; ?>"><?= $system->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
							<div class="col-lg-3">
								<label>Prioritas</label>
								<select name="prioritas" class="form-select" id="priority" required>
									<option value="">Pilih</option>
									<option value="high">High</option>
									<option value="medium">Medium</option>
									<option value="low">Low</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label>Deskripsi</label>
							<div id="description"></div>
							<input type="hidden" name="deskripsi" id="descValue">
						</div>
						<div class="form-group">
							<label>Upload File Pendukung (Format .pdf)</label>
							<input type="file" name="files[]" class="form-control" accept=".pdf" multiple required>
						</div>
						<button type="submit" class="btn btn-primary mt-4 form-control">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/js/pages/user/request-feature.js'); ?>"></script>