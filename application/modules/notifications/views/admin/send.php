<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-paper-plane text-primary"></i> Send Notification
        </h2>
        <a href="<?= site_url('notifications/admin') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <strong>Validation Error:</strong>
        <?= validation_errors() ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('notifications/admin/send') ?>" id="notificationForm">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-edit"></i> Notification Details
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="send_to" class="d-flex align-items-center">
                                <i class="fas fa-users text-info mr-2"></i>
                                <strong>Send To</strong>
                            </label>
                            <select name="send_to" id="send_to" class="form-control" required>
                                <option value="">Select Recipients...</option>
                                <option value="all">All Users</option>
                                <option value="specific">Specific User</option>
                            </select>
                            <small class="form-text text-muted">Choose whether to send to all users or a specific user.</small>
                        </div>

                        <div class="form-group" id="user_id_group" style="display: none;">
                            <label for="user_id" class="d-flex align-items-center">
                                <i class="fas fa-user text-primary mr-2"></i>
                                <strong>User ID</strong>
                            </label>
                            <input type="number" name="user_id" id="user_id" class="form-control" placeholder="Enter user ID" min="1">
                            <small class="form-text text-muted">Enter the specific user ID to send the notification to.</small>
                        </div>

                        <div class="form-group">
                            <label for="type" class="d-flex align-items-center">
                                <i class="fas fa-tag text-warning mr-2"></i>
                                <strong>Notification Type</strong>
                            </label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Select Type...</option>
                                <option value="system">System</option>
                                <option value="info">Information</option>
                                <option value="success">Success</option>
                                <option value="warning">Warning</option>
                                <option value="danger">Alert</option>
                            </select>
                            <small class="form-text text-muted">Type affects the icon and color of the notification.</small>
                        </div>

                        <div class="form-group">
                            <label for="title" class="d-flex align-items-center">
                                <i class="fas fa-heading text-primary mr-2"></i>
                                <strong>Title</strong>
                            </label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Notification title" required maxlength="255">
                            <small class="form-text text-muted">Short, descriptive title for the notification.</small>
                        </div>

                        <div class="form-group">
                            <label for="message" class="d-flex align-items-center">
                                <i class="fas fa-comment-alt text-success mr-2"></i>
                                <strong>Message</strong>
                            </label>
                            <textarea name="message" id="message" class="form-control" rows="5" placeholder="Enter your notification message..." required></textarea>
                            <small class="form-text text-muted">Detailed message content for the notification.</small>
                        </div>

                        <div class="form-group">
                            <label for="link" class="d-flex align-items-center">
                                <i class="fas fa-link text-secondary mr-2"></i>
                                <strong>Link URL (Optional)</strong>
                            </label>
                            <input type="text" name="link" id="link" class="form-control" placeholder="https://example.com/page">
                            <small class="form-text text-muted">Optional link for users to click through from the notification.</small>
                        </div>

                        <hr class="my-4">

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane"></i> Send Notification
                            </button>
                            <a href="<?= site_url('notifications/admin') ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-palette"></i> Notification Preview
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="notification-preview" class="alert alert-secondary" role="alert">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <i class="fas fa-bell fa-2x" id="preview-icon"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" id="preview-title">Notification Title</h6>
                                    <p class="mb-1 small" id="preview-message">Your notification message will appear here...</p>
                                    <small class="text-muted" id="preview-time">Just now</small>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">This is how your notification will appear to users.</small>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-lightbulb"></i> Tips
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="small text-muted mb-0">
                            <li>Keep titles short and descriptive</li>
                            <li>Use clear, actionable language</li>
                            <li>Include a link for more context if needed</li>
                            <li>Test with specific user before mass sending</li>
                            <li>System notifications are for important updates</li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-info-circle"></i> Notification Types
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge badge-secondary">System</span>
                            <small class="text-muted d-block">General system messages</small>
                        </div>
                        <div class="mb-2">
                            <span class="badge badge-info">Info</span>
                            <small class="text-muted d-block">Informational updates</small>
                        </div>
                        <div class="mb-2">
                            <span class="badge badge-success">Success</span>
                            <small class="text-muted d-block">Positive confirmations</small>
                        </div>
                        <div class="mb-2">
                            <span class="badge badge-warning">Warning</span>
                            <small class="text-muted d-block">Important notices</small>
                        </div>
                        <div class="mb-0">
                            <span class="badge badge-danger">Alert</span>
                            <small class="text-muted d-block">Urgent messages</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.card {
    border: none;
}
.shadow {
    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important;
}
#notification-preview {
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendToSelect = document.getElementById('send_to');
    const userIdGroup = document.getElementById('user_id_group');
    const userIdInput = document.getElementById('user_id');
    const typeSelect = document.getElementById('type');
    const titleInput = document.getElementById('title');
    const messageInput = document.getElementById('message');
    const previewDiv = document.getElementById('notification-preview');
    const previewIcon = document.getElementById('preview-icon');
    const previewTitle = document.getElementById('preview-title');
    const previewMessage = document.getElementById('preview-message');

    sendToSelect.addEventListener('change', function() {
        if (this.value === 'specific') {
            userIdGroup.style.display = 'block';
            userIdInput.required = true;
        } else {
            userIdGroup.style.display = 'none';
            userIdInput.required = false;
            userIdInput.value = '';
        }
    });

    function updatePreview() {
        const type = typeSelect.value || 'system';
        const title = titleInput.value || 'Notification Title';
        const message = messageInput.value || 'Your notification message will appear here...';

        previewTitle.textContent = title;
        previewMessage.textContent = message;

        previewDiv.className = 'alert';
        previewIcon.className = 'fas fa-2x';

        switch(type) {
            case 'info':
                previewDiv.classList.add('alert-info');
                previewIcon.classList.add('fa-info-circle');
                break;
            case 'success':
                previewDiv.classList.add('alert-success');
                previewIcon.classList.add('fa-check-circle');
                break;
            case 'warning':
                previewDiv.classList.add('alert-warning');
                previewIcon.classList.add('fa-exclamation-triangle');
                break;
            case 'danger':
                previewDiv.classList.add('alert-danger');
                previewIcon.classList.add('fa-exclamation-circle');
                break;
            default:
                previewDiv.classList.add('alert-secondary');
                previewIcon.classList.add('fa-bell');
        }
    }

    typeSelect.addEventListener('change', updatePreview);
    titleInput.addEventListener('input', updatePreview);
    messageInput.addEventListener('input', updatePreview);
});
</script>
