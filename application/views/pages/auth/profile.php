<div class="container-fluid py-4">
  <div class="row">
    <div class="col-lg-12 position-relative z-index-2">
      <div class="card card-plain">
        <div class="card-body pt-3">
          <hr class="horizontal dark mt-2">
          <div class="row mt-4">
            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
              <div class="card">
                <div class="card-body p-3">
                  <div class="row">
                    <div class="col-8">
                      <div class="numbers">
                        <h3>Profile</h3>
                        <?php
                            $user_data = $this->session->userdata(); 
                        ?>
                        <form id="profileForm">
                          <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name', $user_data['name'] ?? ''); ?>" required>
                          </div>
                          <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= set_value('nik', $user_data['nik'] ?? ''); ?>" required> 
                          </div>
                          <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $user_data['email'] ?? ''); ?>" required>
                          </div>
                          <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" class="form-control" id="role" name="role" value="<?= set_value('role', $user_data['role'] ?? ''); ?>" readonly> 
                          </div>
                          <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin diperbarui)</label>
                            <input type="password" class="form-control" id="password" name="password">
                          </div>
                           <input type="hidden" id="user_id" name="user_id" value="<?= $user_data['user_id'] ?? ''; ?>">
                          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/pages/profile.js'); ?>"></script>