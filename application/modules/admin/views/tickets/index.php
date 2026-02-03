<div uk-grid class="uk-grid-small">
    <div class="uk-width-1-1">
        <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
            <h1 class="uk-heading-small uk-margin-remove">
                <i class="fas fa-ticket-alt"></i> Game Tickets
            </h1>
            <a href="<?= site_url('admin/tickets') ?>" class="uk-button uk-button-small uk-button-default">
                <i class="fas fa-sync-alt"></i> Refresh
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

        <div class="uk-card uk-card-default uk-margin-bottom">
            <div class="uk-card-body">
                <form method="get">
                    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-4@m" uk-grid>
                        <div>
                            <label class="uk-form-label" for="realm">Realm</label>
                            <div class="uk-form-controls">
                                <select id="realm" name="realm" class="uk-select" onchange="this.form.submit()">
                                    <?php foreach ($realms as $realm): ?>
                                        <option value="<?= $realm->id ?>" <?= $realm->id == $realm_id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($realm->realm_name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="uk-form-label" for="status">Status</label>
                            <div class="uk-form-controls">
                                <select id="status" name="status" class="uk-select" onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <?php foreach ($statuses as $key => $status): ?>
                                        <option value="<?= $key ?>" <?= $status_filter == $key ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($status) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="uk-child-width-1-1" uk-grid>
                            <div>
                                <label class="uk-form-label" for="search">Search</label>
                                <div class="uk-form-controls uk-inline uk-width-1-1">
                                    <input type="text" id="search" name="search" class="uk-input" 
                                           placeholder="Player name or content..." value="<?= htmlspecialchars($search) ?>">
                                    <button class="uk-button uk-button-default" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="uk-form-label">&nbsp;</label>
                            <div class="uk-form-controls">
                                <a href="<?= site_url('admin/tickets') ?>" class="uk-button uk-button-default uk-width-1-1">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="uk-card uk-card-default">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-hover uk-table-divider">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Ticket ID</th>
                            <th style="width: 20%;">Player</th>
                            <th style="width: 35%;">Subject</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 15%;">Created</th>
                            <th style="width: 5%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tickets)): ?>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td>
                                        <span class="uk-badge">#<?= $ticket->id ?></span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($ticket->name) ?></strong>
                                    </td>
                                    <td>
                                        <small><?= htmlspecialchars(substr($ticket->description, 0, 50)) ?>...</small>
                                    </td>
                                    <td>
                                        <?php
                                        $status_class = match($ticket->completed) {
                                            0 => 'uk-badge-danger',
                                            1 => 'uk-badge-success',
                                            default => 'uk-badge-secondary'
                                        };
                                        $status_text = $statuses[$ticket->completed] ?? 'Unknown';
                                        ?>
                                        <span class="uk-badge <?= $status_class ?>">
                                            <?= htmlspecialchars($status_text) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small><?= date('Y-m-d H:i', $ticket->createTime) ?></small>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('admin/tickets/view/' . $ticket->id . '?realm=' . $realm_id) ?>" 
                                           class="uk-button uk-button-small uk-button-default" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="uk-text-center uk-padding">
                                    <i class="fas fa-inbox" style="font-size: 2rem; color: #999;"></i>
                                    <p class="uk-text-muted uk-margin-top">No tickets found</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($pagination)): ?>
                <div class="uk-card-footer">
                    <nav>
                        <?= $pagination ?>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
