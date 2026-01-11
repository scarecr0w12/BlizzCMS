<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1><?php echo $page_title; ?></h1>
            
            <div class="card mt-4">
                <div class="card-body">
                    <form method="post" action="<?php echo site_url('social/messages/send'); ?>">
                        <div class="mb-3">
                            <label for="to_id" class="form-label">Recipient</label>
                            <select class="form-control" id="to_id" name="to_id" required>
                                <option value="">Select a user...</option>
                                <?php 
                                $users = $this->db->get('users')->result();
                                foreach ($users as $user):
                                    if ($user->id != $this->session->userdata('user_id')):
                                ?>
                                    <option value="<?php echo $user->id; ?>"><?php echo htmlspecialchars($user->username); ?></option>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                            <a href="<?php echo site_url('social/messages'); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
