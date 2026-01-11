<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Sent Messages</h1>
                <a href="<?php echo site_url('social/messages'); ?>" class="btn btn-secondary">Back to Inbox</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($messages)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>To</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($messages as $msg): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($msg->to_username ?? 'Unknown'); ?></td>
                                            <td><?php echo htmlspecialchars($msg->subject); ?></td>
                                            <td><?php echo date('M d, Y H:i', strtotime($msg->created_at)); ?></td>
                                            <td>
                                                <a href="<?php echo site_url('social/messages/' . $msg->id); ?>" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($total > $limit): ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= ceil($total / $limit); $i++): ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                            <a class="page-link" href="<?php echo site_url('social/sent_messages?page=' . $i); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted">No sent messages.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
