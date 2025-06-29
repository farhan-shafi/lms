<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Reports</h3>
                </div>
                <div class="card-body">
                    <!-- Date Filter Form -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date ?? '' ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date ?? '' ?>">
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>Total Revenue</h5>
                                    <h3>$<?= number_format($total_amount, 2) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Completed Payments</h5>
                                    <h3><?= $total_completed ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5>Failed Payments</h5>
                                    <h3><?= $total_failed ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Course</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($payments)): ?>
                                    <?php foreach ($payments as $payment): ?>
                                        <tr>
                                            <td><?= $payment['id'] ?></td>
                                            <td><?= htmlspecialchars($payment['user_name'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($payment['course_title'] ?? 'N/A') ?></td>
                                            <td>$<?= number_format($payment['amount'], 2) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $payment['status'] == 'completed' ? 'success' : ($payment['status'] == 'failed' ? 'danger' : 'warning') ?>">
                                                    <?= ucfirst($payment['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y H:i', strtotime($payment['created_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No payments found</td>
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
