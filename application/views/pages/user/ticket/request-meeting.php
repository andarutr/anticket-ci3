<div class="container-fluid py-4">
	<div class="row">
		<div class="col-12">
			<div class="card mb-4">
				<div class="card-header pb-0">
					<h6>Request Meeting</h6>
				</div>
				<div class="card-body">
					<form id="requestForm">
						<div class="row mb-3">
                            <div class="col-lg-4">
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
							<div class="col-lg-4">
								<label>Prioritas</label>
								<select name="prioritas" class="form-select" id="priority" required>
									<option value="">Pilih</option>
									<option value="high">High</option>
									<option value="medium">Medium</option>
									<option value="low">Low</option>
								</select>
							</div>
							<div class="col-lg-4">
								<label>Tanggal</label>
								<input type="datetime-local" class="form-control" name="tanggal" id="tanggal" required>
							</div>
						</div>
						<div class="form-group">
							<label>Deskripsi</label>
							<div id="description"></div>
							<input type="hidden" name="deskripsi" id="descValue">
						</div>
						<button type="submit" class="btn btn-primary mt-4 form-control">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/js/pages/user/request-meeting.js'); ?>"></script>