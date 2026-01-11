<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <a href="<?php echo site_url('social/messages'); ?>" class="btn btn-secondary mb-3">Back to Messages</a>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo htmlspecialchars($message->subject); ?></h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>From:</strong> <?php echo htmlspecialchars($sender->username ?? 'Unknown'); ?><br>
                        <strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($message->created_at)); ?>
                    </div>
                    <hr>
                    <div class="message-content">
                        <?php echo nl2br(htmlspecialchars($message->message)); ?>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo site_url('social/messages/send'); ?>" class="btn btn-primary">Reply</a>
                </div>
            </div>
        </div>
    </div>
</div>
