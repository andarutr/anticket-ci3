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
                    <div class="col-12">
                      <h3>Chat</h3>
                      <p>Anda dapat chat bersama worker yang sudah di approval oleh SPV ITE.</p>
                      <div class="d-flex">
                        <div class="col-md-4 border-end">
                          <div class="list-group list-group-flush" id="chat-list">
                            <?php foreach($tickets as $ticket): ?>
                            <a href="javascript:;" class="list-group-item list-group-item-action chat-item" onClick="showMessageDetail('<?= $ticket->id_ticket ?>', '<?= $ticket->no_ticket ?>', '<?= $ticket->developer_name ?>', '<?= $ticket->system_name ?>')">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">#<?= $ticket->no_ticket ?></h6>
                                    <small><?= $ticket->updated_at ?></small>
                                </div>
                                <p class="mb-1 text-sm">System: <?= $ticket->system_name ?></p>
                                <p class="mb-1 text-sm">Worker: <?= $ticket->developer_name ?></p>
                            </a>
                            <?php endforeach; ?>
                          </div>
                        </div>

                        <div class="col-md-8">
                          <div id="containerChatDetail"></div>

                          <div id="chat-placeholder" class="text-center py-5">
                            <p class="text-muted">Pilih obrolan untuk memulai percakapan</p>
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
</div>

<script src="<?= base_url('assets/js/pages/user/message.js'); ?>"></script>