<div class="container-fluid py-4">
	<div class="row">
		<div class="col-12">
			<div class="card mb-4">
				<div class="card-header pb-0">
					<h6>Request System</h6>
				</div>
				<div class="card-body">
					<form id="requestForm">
						<div class="form-group">
							<label>Judul</label>
							<input type="text" name="judul" class="form-control" id="name" required>
						</div>
						<div class="row mb-3">
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
								<label>Dept</label>
								<select name="dept" class="form-select" id="dept" required>
									<option value="">Pilih</option>
									<option value="IT">IT</option>
									<option value="HR">HR</option>
									<option value="Finance">Finance</option>
								</select>
							</div>
							<div class="col-lg-4">
								<label>PIC</label>
								<select name="pic_name" class="form-select" id="pic_name" required>
									<option value="">Pilih</option>
									<?php foreach ($users as $user): ?>
                                        <option value="<?= $user->name ?>">
                                            <?= $user->name ?>
                                        </option>
                                    <?php endforeach; ?>
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

<script src="<?= base_url('assets/js/pages/user/request-system.js'); ?>"></script>