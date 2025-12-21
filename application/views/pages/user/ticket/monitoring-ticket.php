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
                    <div class="col-12 p-5">
                      <div class="numbers">
                        <h5 class="mb-5">Monitoring Ticket</h5>
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">No Ticket</th>
                                        <th class="text-white">System</th>
                                        <th class="text-white">Type</th>
                                        <th class="text-white">Requestor</th>
                                        <th class="text-white">Priority</th>
                                        <th class="text-white">Deadline</th>
                                        <th class="text-white">Status</th>
                                        <th class="text-white">Action</th>
                                    </tr>
                                </thead>
                            </table>
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

<script src="<?= base_url('assets/js/pages/user/monitoring-ticket.js'); ?>"></script>