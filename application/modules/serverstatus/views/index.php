<div class="uk-container uk-container-large uk-margin-top uk-margin-bottom">
    <div class="uk-margin-large-bottom">
        <h1 class="uk-heading-medium uk-margin-remove-bottom">
            <i class="fas fa-server uk-margin-small-right"></i><?= lang('serverstatus_title') ?>
        </h1>
        <p class="uk-text-muted uk-margin-remove-top">Real-time server statistics and player information</p>
    </div>

    <div class="uk-grid-small uk-margin-large-bottom" uk-grid>
        <?php foreach ($realms as $realm): ?>
        <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-3@m">
            <div class="uk-card uk-card-default uk-card-hover uk-transition-toggle">
                <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
                    <div>
                        <h4 class="uk-card-title uk-margin-remove"><?= htmlspecialchars($realm->realm_name) ?></h4>
                        <p class="uk-text-small uk-text-muted uk-margin-remove">World of Warcraft Server</p>
                    </div>
                    <span class="uk-badge uk-badge-<?= $realm->online_count > 0 ? 'success' : 'danger' ?> uk-transition-fade">
                        <i class="fas fa-circle uk-margin-small-right"></i><?= $realm->online_count > 0 ? lang('serverstatus_online') : lang('serverstatus_offline') ?>
                    </span>
                </div>
                <div class="uk-card-divider"></div>
                <div class="uk-card-body">
                    <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                        <div>
                            <div class="uk-text-center">
                                <div class="uk-text-large uk-text-bold uk-text-primary" id="online-count-<?= $realm->id ?>">
                                    <?= $realm->online_count ?>
                                </div>
                                <div class="uk-text-small uk-text-muted">
                                    <i class="fas fa-users uk-margin-small-right"></i><?= lang('serverstatus_online_players') ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-text-center">
                                <div class="uk-text-large uk-text-bold uk-text-warning">
                                    <?= isset($peak_players[$realm->id]) ? $peak_players[$realm->id] : 0 ?>
                                </div>
                                <div class="uk-text-small uk-text-muted">
                                    <i class="fas fa-chart-line uk-margin-small-right"></i><?= lang('serverstatus_peak_today') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($uptime_stats[$realm->id]) && !empty($uptime_stats[$realm->id])): ?>
                    <div class="uk-margin-top uk-padding-small uk-background-muted uk-border-rounded">
                        <div class="uk-text-small uk-text-muted uk-margin-small-bottom">
                            <i class="fas fa-hourglass-half uk-margin-small-right"></i><?= lang('serverstatus_uptime') ?>
                        </div>
                        <div class="uk-text-bold uk-text-large">
                            <?= gmdate("H:i:s", $uptime_stats[$realm->id]) ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (isset($faction_balance[$realm->id])): ?>
                    <div class="uk-margin-top">
                        <div class="uk-text-small uk-text-muted uk-margin-small-bottom">
                            <i class="fas fa-balance-scale uk-margin-small-right"></i>Faction Balance
                        </div>
                        <?php
                        $fb = $faction_balance[$realm->id];
                        $alliance_pct = $fb['total'] > 0 ? ($fb['alliance'] / $fb['total']) * 100 : 50;
                        $horde_pct = 100 - $alliance_pct;
                        ?>
                        <div class="uk-progress uk-margin-small-bottom">
                            <div class="uk-progress-bar" style="width: <?= $alliance_pct ?>%; background-color: #0070DE;">
                                <span class="uk-text-small uk-text-bold" style="color: white; padding: 2px 4px;">
                                    Alliance <?= round($alliance_pct) ?>%
                                </span>
                            </div>
                        </div>
                        <div class="uk-progress">
                            <div class="uk-progress-bar" style="width: <?= $horde_pct ?>%; background-color: #C41F3B;">
                                <span class="uk-text-small uk-text-bold" style="color: white; padding: 2px 4px;">
                                    Horde <?= round($horde_pct) ?>%
                                </span>
                            </div>
                        </div>
                        <div class="uk-grid-small uk-text-small uk-margin-top" uk-grid>
                            <div class="uk-width-1-2">
                                <span class="uk-badge" style="background-color: #0070DE;">Alliance: <?= $fb['alliance'] ?></span>
                            </div>
                            <div class="uk-width-1-2">
                                <span class="uk-badge" style="background-color: #C41F3B;">Horde: <?= $fb['horde'] ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($class_distribution) || !empty($level_distribution)): ?>
    <div class="uk-margin-large-top">
        <h3 class="uk-heading-small uk-margin-bottom">
            <i class="fas fa-chart-pie uk-margin-small-right"></i>Player Statistics
        </h3>
        <div class="uk-grid-small" uk-grid>
            <?php if (!empty($class_distribution)): ?>
            <div class="uk-width-1-1 uk-width-1-2@m">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <h5 class="uk-card-title uk-margin-remove">
                            <i class="fas fa-users uk-margin-small-right"></i><?= lang('serverstatus_class_distribution') ?>
                        </h5>
                    </div>
                    <div class="uk-card-body">
                        <canvas id="classChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($level_distribution)): ?>
            <div class="uk-width-1-1 uk-width-1-2@m">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <h5 class="uk-card-title uk-margin-remove">
                            <i class="fas fa-chart-bar uk-margin-small-right"></i><?= lang('serverstatus_level_distribution') ?>
                        </h5>
                    </div>
                    <div class="uk-card-body">
                        <canvas id="levelChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let chartInstances = {};
    
    function updateStats() {
        <?php foreach ($realms as $realm): ?>
        fetch('<?= site_url("serverstatus/api_stats?realm_id={$realm->id}") ?>')
            .then(response => response.json())
            .then(data => {
                const elem = document.getElementById('online-count-<?= $realm->id ?>');
                if (elem) {
                    const oldValue = parseInt(elem.textContent);
                    const newValue = data.online_players;
                    
                    if (oldValue !== newValue) {
                        elem.style.transition = 'color 0.3s ease';
                        elem.style.color = '#0070DE';
                        elem.textContent = newValue;
                        setTimeout(() => {
                            elem.style.color = 'inherit';
                        }, 300);
                    }
                }
            })
            .catch(err => console.error('Failed to update stats:', err));
        <?php endforeach; ?>
    }

    if (typeof Chart !== 'undefined') {
        <?php if (!empty($class_distribution)): ?>
        const classCtx = document.getElementById('classChart');
        if (classCtx) {
            chartInstances.class = new Chart(classCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode(array_column($class_distribution, 'class')) ?>,
                    datasets: [{
                        data: <?= json_encode(array_column($class_distribution, 'count')) ?>,
                        backgroundColor: [
                            '#C79C6E', '#F58CBA', '#ABD473', '#FFF569',
                            '#FFFFFF', '#C41F3B', '#0070DE', '#69CCF0',
                            '#9482C9', '#00FF96', '#FF7D0A'
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        }
        <?php endif; ?>

        <?php if (!empty($level_distribution)): ?>
        const levelCtx = document.getElementById('levelChart');
        if (levelCtx) {
            chartInstances.level = new Chart(levelCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($level_distribution, 'level_range')) ?>,
                    datasets: [{
                        label: 'Players',
                        data: <?= json_encode(array_column($level_distribution, 'count')) ?>,
                        backgroundColor: '#0070DE',
                        borderColor: '#004a99',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
        <?php endif; ?>
    }

    setInterval(updateStats, 30000);
    
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
</script>

<style>
.uk-card-hover {
    transition: all 0.3s ease;
}

.uk-card-hover:hover {
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.uk-text-primary {
    color: #0070DE !important;
}

.uk-text-warning {
    color: #FF8000 !important;
}

#online-count-<?php foreach ($realms as $realm): echo $realm->id . ', '; endforeach; ?> {
    transition: color 0.3s ease;
}

.uk-progress-bar {
    transition: width 0.5s ease;
}

@media (max-width: 640px) {
    .uk-card-header {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .uk-badge {
        margin-top: 10px;
    }
}
</style>
