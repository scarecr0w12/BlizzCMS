<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-user-circle text-primary"></i> Profile Enhanced Administration
        </h2>
        <div>
            <a href="<?= site_url('profile/' . $this->session->userdata('username')) ?>" class="btn btn-info mr-2" target="_blank">
                <i class="fas fa-eye"></i> View My Profile
            </a>
            <a href="<?= site_url('profile_enhanced/admin/settings') ?>" class="btn btn-primary">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Profiles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($statistics['total_profiles']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Activities</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($statistics['total_activities']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Profile Visits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($statistics['total_visits']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Showcased Achievements</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($statistics['total_showcased']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history"></i> Recent Activities
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_activities)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_activities as $activity): ?>
                                <div class="list-group-item px-0 py-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <i class="fas fa-user-circle text-muted mr-1"></i>
                                            <strong><?= htmlspecialchars($activity->username ?? 'Unknown') ?></strong>
                                            <span class="text-muted small ml-1">
                                                <?= ucfirst(str_replace('_', ' ', $activity->activity_type)) ?>
                                            </span>
                                        </div>
                                        <span class="badge badge-light text-muted small">
                                            <?= timespan(strtotime($activity->created_at), time(), 1) ?> ago
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center mb-0">No recent activities</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-info-circle"></i> Module Information
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-3"><strong>Enhanced User Profiles</strong></p>
                    <p class="text-muted small">This module provides advanced profile features including activity timelines, achievement showcases, character galleries, and social integration.</p>
                    
                    <hr>
                    
                    <p class="mb-2"><strong>Features:</strong></p>
                    <ul class="small text-muted mb-3">
                        <li>Activity Timeline - Track user actions and milestones</li>
                        <li>Achievement Showcase - Display earned achievements</li>
                        <li>Character Gallery - View all user characters</li>
                        <li>Profile Visits - Track profile view statistics</li>
                        <li>Social Links - Connect external profiles</li>
                        <li>Customizable Themes - Personal profile styling</li>
                    </ul>
                    
                    <hr>
                    
                    <p class="mb-2"><strong>Current Settings:</strong></p>
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Timeline Enabled:</span>
                            <span class="badge badge-<?= ($settings['enable_timeline'] ?? 1) ? 'success' : 'secondary' ?>">
                                <?= ($settings['enable_timeline'] ?? 1) ? 'Yes' : 'No' ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Achievements Enabled:</span>
                            <span class="badge badge-<?= ($settings['enable_achievements'] ?? 1) ? 'success' : 'secondary' ?>">
                                <?= ($settings['enable_achievements'] ?? 1) ? 'Yes' : 'No' ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Max Showcase:</span>
                            <span class="badge badge-info"><?= $settings['max_showcase_achievements'] ?? 6 ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 4px solid #4e73df !important; }
.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }
</style>
