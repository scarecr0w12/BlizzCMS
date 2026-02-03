<div uk-grid class="uk-grid-small">
    <div class="uk-width-1-1">
        <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
            <h1 class="uk-heading-small uk-margin-remove">
                <i class="fas fa-ticket-alt"></i> Ticket #<?= $ticket->id ?>
            </h1>
            <a href="<?= site_url('admin/tickets?realm=' . $realm_id) ?>" class="uk-button uk-button-small uk-button-default">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="uk-alert-success uk-margin-bottom" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="uk-alert-danger uk-margin-bottom" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <div uk-grid class="uk-grid-small">
            <div class="uk-width-2-3@m">
                <div class="uk-card uk-card-default uk-margin-bottom">
                    <div class="uk-card-header">
                        <h3 class="uk-card-title uk-margin-remove">Ticket Details</h3>
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-grid-small uk-child-width-1-2@s" uk-grid>
                            <div>
                                <label class="uk-form-label">Player Name</label>
                                <p class="uk-margin-remove"><strong><?= htmlspecialchars($ticket->name) ?></strong></p>
                            </div>
                            <div>
                                <label class="uk-form-label">Player GUID</label>
                                <p class="uk-margin-remove"><strong><?= $ticket->playerGuid ?></strong></p>
                            </div>
                            <div>
                                <label class="uk-form-label">Created</label>
                                <p class="uk-margin-remove"><strong><?= date('Y-m-d H:i:s', $ticket->createTime) ?></strong></p>
                            </div>
                            <div>
                                <label class="uk-form-label">Last Modified</label>
                                <p class="uk-margin-remove"><strong><?= date('Y-m-d H:i:s', $ticket->lastModifiedTime) ?></strong></p>
                            </div>
                            <div>
                                <label class="uk-form-label">Map ID</label>
                                <p class="uk-margin-remove"><strong><?= $ticket->mapId ?></strong></p>
                            </div>
                            <div>
                                <label class="uk-form-label">Position</label>
                                <p class="uk-margin-remove"><strong><?= round($ticket->posX, 2) ?>, <?= round($ticket->posY, 2) ?>, <?= round($ticket->posZ, 2) ?></strong></p>
                            </div>
                        </div>

                        <hr class="uk-margin-medium">

                        <div class="uk-margin-bottom">
                            <label class="uk-form-label">Ticket Content</label>
                            <div class="uk-background-muted uk-padding uk-border-rounded">
                                <p class="uk-margin-remove uk-text-break"><?= nl2br(htmlspecialchars($ticket->description)) ?></p>
                            </div>
                        </div>

                        <?php if (!empty($ticket->response)): ?>
                            <hr class="uk-margin-medium">
                            <div class="uk-margin-bottom">
                                <label class="uk-form-label">GM Responses</label>
                                <div class="uk-background-muted uk-padding uk-border-rounded">
                                    <p class="uk-margin-remove uk-text-break"><?= nl2br(htmlspecialchars($ticket->response)) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($ticket->completed != 1): ?>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            <h3 class="uk-card-title uk-margin-remove">Add Response</h3>
                        </div>
                        <form method="post" action="<?= site_url('admin/tickets/respond') ?>">
                            <div class="uk-card-body">
                                <div class="uk-margin">
                                    <label class="uk-form-label" for="response">Your Response</label>
                                    <textarea id="response" name="response" class="uk-textarea" rows="5" 
                                              placeholder="Type your response here..." required></textarea>
                                    <small class="uk-text-muted">Your response will be visible to the player.</small>
                                </div>
                            </div>
                            <div class="uk-card-footer">
                                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                                <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                                <input type="hidden" name="realm_id" value="<?= $realm_id ?>">
                                <button type="submit" class="uk-button uk-button-primary">
                                    <i class="fas fa-paper-plane"></i> Send Response
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <div class="uk-width-1-3@m">
                <div class="uk-card uk-card-default uk-margin-bottom">
                    <div class="uk-card-header">
                        <h3 class="uk-card-title uk-margin-remove">Status & Actions</h3>
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-margin-bottom">
                            <label class="uk-form-label">Current Status</label>
                            <?php
                            $status_class = match($ticket->completed) {
                                0 => 'uk-badge-danger',
                                1 => 'uk-badge-success',
                                default => 'uk-badge-secondary'
                            };
                            $status_text = $statuses[$ticket->completed] ?? 'Unknown';
                            ?>
                            <p class="uk-margin-remove">
                                <span class="uk-badge <?= $status_class ?>">
                                    <?= htmlspecialchars($status_text) ?>
                                </span>
                            </p>
                        </div>

                        <?php if ($ticket->completed != 1): ?>
                            <form method="post" action="<?= site_url('admin/tickets/update_status') ?>" class="uk-margin-bottom">
                                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                                <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                                <input type="hidden" name="realm_id" value="<?= $realm_id ?>">
                                <label class="uk-form-label" for="status">Change Status</label>
                                <select id="status" name="status" class="uk-select" required>
                                    <option value="">Select Status</option>
                                    <?php foreach ($statuses as $key => $status): ?>
                                        <option value="<?= $key ?>" <?= $key == $ticket->completed ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($status) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="uk-button uk-button-default uk-width-1-1 uk-margin-top">
                                    <i class="fas fa-sync-alt"></i> Update Status
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if ($ticket->completed != 1): ?>
                            <form method="post" action="<?= site_url('admin/tickets/close') ?>" 
                                  onsubmit="return confirm('Are you sure you want to close this ticket?');">
                                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                                <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                                <input type="hidden" name="realm_id" value="<?= $realm_id ?>">
                                <button type="submit" class="uk-button uk-button-danger uk-width-1-1">
                                    <i class="fas fa-times-circle"></i> Close Ticket
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <h3 class="uk-card-title uk-margin-remove">Realm Info</h3>
                    </div>
                    <div class="uk-card-body">
                        <label class="uk-form-label">Selected Realm</label>
                        <p class="uk-margin-remove">
                            <strong>
                                <?php
                                $realm = array_filter($realms, fn($r) => $r->id == $realm_id);
                                $realm = reset($realm);
                                echo $realm ? htmlspecialchars($realm->realm_name) : 'Unknown';
                                ?>
                            </strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
