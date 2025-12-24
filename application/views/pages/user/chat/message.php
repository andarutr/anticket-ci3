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
                      <button class="btn btn-primary btn-sm mb-4 mt-4">+ Tambah Chatting</button>
                      <div class="d-flex">
                        <div class="col-md-4 border-end">
                          <div class="list-group list-group-flush" id="chat-list">
                            <a href="#" class="list-group-item list-group-item-action chat-item" data-ticket-id="1">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">#RM20251224001</h6>
                                    <small>24/12/25</small>
                                </div>
                                <p class="mb-1 text-sm">System: HRIS</p>
                                <p class="mb-1 text-sm">Worker: Andaru Triadi</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action chat-item" data-ticket-id="2">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">#RM20251224002</h6>
                                    <small>24/12/25</small>
                                </div>
                                <p class="mb-1 text-sm">System: Knowledge Management System</p>
                                <p class="mb-1 text-sm">Worker: Andaru Triadi</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action chat-item" data-ticket-id="3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">#RM20251224003</h6>
                                    <small>24/12/25</small>
                                </div>
                                <p class="mb-1 text-sm">System: HR Connect</p>
                                <p class="mb-1 text-sm">Worker: Andaru Triadi</p>
                            </a>
                          </div>
                        </div>

                        <div class="col-md-8">
                          <div id="detail-chat-1" class="chat-detail-content d-none">
                            <div class="chat-header mb-3">
                              <h5 id="chat-ticket-title-1">&nbsp;&nbsp;&nbsp;#RM20251224001 - HRIS</h5>
                            </div>
                            <div class="chat-messages p-3 border rounded mb-3" style="height: 400px; overflow-y: auto;">
                              <div class="message mb-2">
                                <div class="d-flex justify-content-start">
                                  <div class="bg-primary text-white p-2 rounded">
                                    <small>Halo, saya ingin menanyakan tentang fitur absensi.</small><br>
                                    <small>User - 24/12/2025 10:05</small>
                                  </div>
                                </div>
                              </div>
                              <div class="message mb-2">
                                <div class="d-flex justify-content-end">
                                  <div class="bg-light p-2 rounded">
                                    <small>Baik, fitur absensi saat ini sedang dalam pengembangan.</small><br>
                                    <small>Andaru Triadi - 24/12/2025 10:15</small>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="input-group">
                              <input type="text" class="form-control" id="message-input-1" placeholder="Ketik pesan...">
                              <button class="btn btn-primary" id="send-btn-1">Kirim</button>
                            </div>
                          </div>

                          <div id="detail-chat-2" class="chat-detail-content d-none">
                            <div class="chat-header mb-3">
                              <h5 id="chat-ticket-title-2">&nbsp;&nbsp;&nbsp;#RM20251224002 - Knowledge Management System</h5>
                            </div>
                            <div class="chat-messages p-3 border rounded mb-3" style="height: 400px; overflow-y: auto;">
                              <div class="message mb-2">
                                <div class="d-flex justify-content-start">
                                  <div class="bg-primary text-white p-2 rounded">
                                    <small>Ada kendala saat upload dokumen.</small><br>
                                    <small>User - 24/12/2025 10:25</small>
                                  </div>
                                </div>
                              </div>
                              <div class="message mb-2">
                                <div class="d-flex justify-content-end">
                                  <div class="bg-light p-2 rounded">
                                    <small>Bisa dijelaskan lebih detail?</small><br>
                                    <small>Andaru Triadi - 24/12/2025 10:28</small>
                                  </div>
                                </div>
                              </div>
                              <div class="message mb-2">
                                <div class="d-flex justify-content-start">
                                  <div class="bg-primary text-white p-2 rounded">
                                    <small>File PDF tidak bisa diupload.</small><br>
                                    <small>User - 24/12/2025 10:35</small>
                                  </div>
                                </div>
                              </div>
                              <div class="message mb-2">
                                <div class="d-flex justify-content-end">
                                  <div class="bg-light p-2 rounded">
                                    <small>Saya cek dulu, terima kasih informasinya.</small><br>
                                    <small>Andaru Triadi - 24/12/2025 10:36</small>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="input-group">
                              <input type="text" class="form-control" id="message-input-2" placeholder="Ketik pesan...">
                              <button class="btn btn-primary" id="send-btn-2">Kirim</button>
                            </div>
                          </div>

                          <div id="detail-chat-3" class="chat-detail-content d-none">
                            <div class="chat-header mb-3">
                              <h5 id="chat-ticket-title-3">&nbsp;&nbsp;&nbsp;#RM20251224003 - HR Connect</h5>
                            </div>
                            <div class="chat-messages p-3 border rounded mb-3" style="height: 400px; overflow-y: auto;">
                              <div class="message mb-2">
                                <div class="d-flex justify-content-start">
                                  <div class="bg-primary text-white p-2 rounded">
                                    <small>Fitur chat belum bisa digunakan.</small><br>
                                    <small>User - 24/12/2025 10:40</small>
                                  </div>
                                </div>
                              </div>
                              <div class="message mb-2">
                                <div class="d-flex justify-content-end">
                                  <div class="bg-light p-2 rounded">
                                    <small>Saya sedang maintenance fitur chat, mohon tunggu.</small><br>
                                    <small>Andaru Triadi - 24/12/2025 10:50</small>
                                  </div>
                                </div>
                              </div>
                              <div class="message mb-2">
                                <div class="d-flex justify-content-start">
                                  <div class="bg-primary text-white p-2 rounded">
                                    <small>Oke, terima kasih infonya.</small><br>
                                    <small>User - 24/12/2025 11:00</small>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="input-group">
                              <input type="text" class="form-control" id="message-input-3" placeholder="Ketik pesan...">
                              <button class="btn btn-primary" id="send-btn-3">Kirim</button>
                            </div>
                          </div>

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