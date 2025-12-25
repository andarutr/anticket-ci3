<div class="container-fluid py-4">
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Ticket Aktif</p>
                <h5 class="font-weight-bold mb-0"><?= $ticket_aktif ?? 0 ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-single-copy-04 text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Dalam Proses</p>
                <h5 class="font-weight-bold mb-0"><?= $ticket_proses ?? 0 ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Menunggu</p>
                <h5 class="font-weight-bold mb-0"><?= $ticket_menunggu ?? 0 ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-warning shadow text-center border-radius-md">
                <i class="ni ni-email-83 text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Selesai</p>
                <h5 class="font-weight-bold mb-0"><?= $ticket_selesai ?? 0 ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Shortcut Button</h6>
        </div>
        <div class="card-body">
          <div class="d-flex flex-wrap gap-3">
            <a href="<?= base_url('user/ticket/request-system') ?>" class="btn btn-primary"><i class="bi bi-ticket-perforated"></i> Buat Ticket Baru</a>
            <a href="<?= base_url('user/chat/message') ?>" class="btn btn-info"><i class="bi bi-chat"></i> Chat Terbaru</a>
            <a href="<?= base_url('user/ticket/monitoring-ticket') ?>" class="btn btn-secondary"><i class="bi bi-ticket-perforated"></i> Monitoring Ticket</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Ticket Terbaru</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ticket</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">System</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Worker</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><center>Action</center></th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($ticket_terbaru)): ?>
                  <?php foreach ($ticket_terbaru as $ticket): ?>
                    <tr>
                      <td>
                        #<?= $ticket['no_ticket']; ?>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($ticket['system_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
                      </td>
                      <td>
                        <?= $ticket['status'] ?>
                      </td>
                      <td><span class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($ticket['worker'] ?? 'Belum Di Approve', ENT_QUOTES, 'UTF-8') ?></span></td>
                      <td><span class="text-xs font-weight-bold mb-0"><?= $ticket['created_at'] ?></span></td>
                      <td class="align-middle">
                        <center>
                          <button class="badge bg-success text-white" onClick="viewTicket(<?= $ticket['id']; ?>)"><i class="bi bi-eye"></i></button>
                        </center>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada ticket</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">View Ticket Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="viewModalContent">
          <p>Loading...</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/pages/user/dashboard.js'); ?>"></script>