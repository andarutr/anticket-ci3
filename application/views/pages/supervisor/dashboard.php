<div class="container-fluid py-4">
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Menunggu Approval</p>
                <h5 class="font-weight-bold mb-0"><?= $ticket_waiting ?? 0 ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                <i class="ni ni-email-83 text-lg opacity-10" aria-hidden="true"></i>
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Approved</p>
                <h5 class="font-weight-bold mb-0"><?= $ticket_approved ?? 0 ?></h5>
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
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Rejected</p>
                <h5 class="font-weight-bold mb-0"><?= $ticket_rejected ?? 0 ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                <i class="ni ni-fat-remove text-lg opacity-10" aria-hidden="true"></i>
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Bulan Ini</p>
                <h5 class="font-weight-bold mb-0"><?= $ticket_total ?? 0 ?></h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
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
          <h6>Approval Queue</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ticket</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">System</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requestor</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Priority</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deadline</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><center>Action</center></th>
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
                        <span class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($ticket['requestor_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></span>
                      </td>
                      <td>
                        <span class="badge bg-warning text-white"><?= $ticket['priority'] ?></span>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold mb-0"><?= $ticket['deadline'] ?? 'N/A' ?></span>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold mb-0"><?= $ticket['created_at'] ?></span>
                      </td>
                      <td class="align-middle">
                        <center>
                          <span class="badge bg-success" onClick="viewTicket(<?= $ticket['id']; ?>)"><i class="bi bi-eye"></i></span>
                        </center>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada ticket yang menunggu approval</td>
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

<script src="<?= base_url('assets/js/pages/supervisor/dashboard.js'); ?>"></script>