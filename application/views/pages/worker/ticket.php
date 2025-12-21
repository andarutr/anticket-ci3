<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <ul class="nav nav-tabs" id="ticketTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="backlog-tab" data-bs-toggle="tab"
                                data-bs-target="#backlog" type="button" role="tab">Backlog</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="list-tab" data-bs-toggle="tab"
                                data-bs-target="#list" type="button" role="tab">List</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="inprogress-tab" data-bs-toggle="tab"
                                data-bs-target="#inprogress" type="button" role="tab">In Progress</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="done-tab" data-bs-toggle="tab" data-bs-target="#done"
                                type="button" role="tab">Done</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reject-tab" data-bs-toggle="tab"
                                data-bs-target="#reject" type="button" role="tab">Reject</button>
                        </li>
                    </ul>
	                <div class="tab-content" id="ticketTabContent">
                        <div class="tab-pane fade show active" id="backlog" role="tabpanel">
                            <div class="row">
                                <div class="col-12 p-5">
                                    <div class="numbers">
                                        <h5 class="mb-5">Backlog Tickets</h5>
                                        <div class="table-responsive">
                                            <table class="table" id="tableBacklog">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-white">No Ticket</th>
                                                        <th class="text-white">System</th>
                                                        <th class="text-white">Type</th>
                                                        <th class="text-white">Requestor</th>
                                                        <th class="text-white">Priority</th>
                                                        <th class="text-white">Deadline</th>
                                                        <th class="text-white">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list" role="tabpanel">
                            <div class="row">
                                <div class="col-12 p-5">
                                    <div class="numbers">
                                        <h5 class="mb-5">All Tickets</h5>
                                        <div class="table-responsive">
                                            <table class="table" id="tableList">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-white">No Ticket</th>
                                                        <th class="text-white">System</th>
                                                        <th class="text-white">Type</th>
                                                        <th class="text-white">Requestor</th>
                                                        <th class="text-white">Priority</th>
                                                        <th class="text-white">Deadline</th>
                                                        <th class="text-white">Execute</th>
                                                        <th class="text-white">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="inprogress" role="tabpanel">
                            <div class="row">
                                <div class="col-12 p-5">
                                    <div class="numbers">
                                        <h5 class="mb-5">In Progress Tickets</h5>
                                        <div class="table-responsive">
                                            <table class="table" id="tableInprogress">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-white">Execute</th>
                                                        <th class="text-white">No Ticket</th>
                                                        <th class="text-white">System</th>
                                                        <th class="text-white">Type</th>
                                                        <th class="text-white">Requestor</th>
                                                        <th class="text-white">Priority</th>
                                                        <th class="text-white">Deadline</th>
                                                        <th class="text-white">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="done" role="tabpanel">
                            <div class="row">
                                <div class="col-12 p-5">
                                    <div class="numbers">
                                        <h5 class="mb-5">Done Tickets</h5>
                                        <div class="table-responsive">
                                            <table class="table" id="tableDone">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-white">No Ticket</th>
                                                        <th class="text-white">System</th>
                                                        <th class="text-white">Type</th>
                                                        <th class="text-white">Requestor</th>
                                                        <th class="text-white">Priority</th>
                                                        <th class="text-white">Deadline</th>
                                                        <th class="text-white">Done</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reject" role="tabpanel">
                            <div class="row">
                                <div class="col-12 p-5">
                                    <div class="numbers">
                                        <h5 class="mb-5">Rejected Tickets</h5>
                                        <div class="table-responsive">
                                            <table class="table" id="tableReject">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-white">No Ticket</th>
                                                        <th class="text-white">System</th>
                                                        <th class="text-white">Type</th>
                                                        <th class="text-white">Requestor</th>
                                                        <th class="text-white">Priority</th>
                                                        <th class="text-white">Deadline</th>
                                                        <th class="text-white">Reject</th>
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

<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">Atur Tanggal Eksekusi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm">
                    <input type="hidden" id="ticketIdInput" value="">
                    <div class="mb-3">
                        <label for="executionDate" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control" id="executionDate" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitSchedule()">Submit</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/pages/worker/ticket.js'); ?>"></script>