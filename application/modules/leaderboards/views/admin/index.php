<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-trophy text-warning"></i> Leaderboards Administration
        </h2>
        <div>
            <a href="<?= site_url('leaderboards') ?>" class="btn btn-info mr-2" target="_blank">
                <i class="fas fa-eye"></i> View Public
            </a>
            <a href="<?= site_url('leaderboards/admin/settings') ?>" class="btn btn-primary">
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Players</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_players) ?></div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Guilds</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_guilds) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Categories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">7</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Auto-Update</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="badge badge-success">Real-time</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sync fa-2x text-gray-300"></i>
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
                        <i class="fas fa-chart-bar"></i> Leaderboard Categories
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-crossed-swords text-danger"></i> PvP Rankings</span>
                            <span class="badge badge-primary badge-pill">Total Kills</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-medal text-warning"></i> Honor Rankings</span>
                            <span class="badge badge-primary badge-pill">Honor Points</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-chess-knight text-info"></i> Arena Rankings</span>
                            <span class="badge badge-primary badge-pill">Team Rating</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-star text-success"></i> Achievements</span>
                            <span class="badge badge-primary badge-pill">Total Earned</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-hammer text-secondary"></i> Professions</span>
                            <span class="badge badge-primary badge-pill">Skill Level</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-crown text-warning"></i> Guilds</span>
                            <span class="badge badge-primary badge-pill">Progression</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-trophy text-gold"></i> Server Firsts</span>
                            <span class="badge badge-primary badge-pill">Achievements</span>
                        </div>
                    </div>
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
                    <p class="mb-3"><strong>Real-time Data Integration</strong></p>
                    <p class="text-muted small">Leaderboards automatically pull data from your character database. All rankings update in real-time based on player activity.</p>
                    
                    <hr>
                    
                    <p class="mb-2"><strong>Features:</strong></p>
                    <ul class="small text-muted mb-3">
                        <li>Automatic data synchronization</li>
                        <li>Multi-realm support</li>
                        <li>Configurable ranking criteria</li>
                        <li>Pagination support</li>
                        <li>Direct armory integration</li>
                    </ul>
                    
                    <hr>
                    
                    <p class="mb-2"><strong>Quick Links:</strong></p>
                    <div class="btn-group btn-group-sm d-flex" role="group">
                        <a href="<?= site_url('leaderboards/pvp') ?>" class="btn btn-outline-primary" target="_blank">PvP</a>
                        <a href="<?= site_url('leaderboards/arena') ?>" class="btn btn-outline-primary" target="_blank">Arena</a>
                        <a href="<?= site_url('leaderboards/guilds') ?>" class="btn btn-outline-primary" target="_blank">Guilds</a>
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
.text-gold { color: #ffd700 !important; }
</style>
