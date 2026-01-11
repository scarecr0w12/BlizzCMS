<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('analytics/Analytics_model');
        header('Content-Type: application/json');
    }

    public function chart_data()
    {
        $chart_type = $this->input->get('type');
        $days = $this->input->get('days') ?? 30;
        
        $data = [];
        
        switch ($chart_type) {
            case 'daily_users':
                $daily_stats = $this->Analytics_model->get_daily_stats($days);
                $data = [
                    'labels' => array_column($daily_stats, 'date'),
                    'datasets' => [
                        [
                            'label' => 'New Users',
                            'data' => array_column($daily_stats, 'users'),
                            'borderColor' => '#3498db',
                            'backgroundColor' => 'rgba(52, 152, 219, 0.1)',
                            'tension' => 0.4
                        ]
                    ]
                ];
                break;
                
            case 'daily_logins':
                $daily_stats = $this->Analytics_model->get_daily_stats($days);
                $data = [
                    'labels' => array_column($daily_stats, 'date'),
                    'datasets' => [
                        [
                            'label' => 'Logins',
                            'data' => array_column($daily_stats, 'logins'),
                            'borderColor' => '#2ecc71',
                            'backgroundColor' => 'rgba(46, 204, 113, 0.1)',
                            'tension' => 0.4
                        ]
                    ]
                ];
                break;
                
            case 'daily_revenue':
                $daily_stats = $this->Analytics_model->get_daily_stats($days);
                $data = [
                    'labels' => array_column($daily_stats, 'date'),
                    'datasets' => [
                        [
                            'label' => 'Revenue',
                            'data' => array_column($daily_stats, 'revenue'),
                            'borderColor' => '#f39c12',
                            'backgroundColor' => 'rgba(243, 156, 18, 0.1)',
                            'tension' => 0.4
                        ]
                    ]
                ];
                break;
                
            case 'top_items':
                $top_items = $this->Analytics_model->get_top_items(10);
                $data = [
                    'labels' => array_column($top_items, 'name'),
                    'datasets' => [
                        [
                            'label' => 'Sales',
                            'data' => array_column($top_items, 'sales'),
                            'backgroundColor' => [
                                '#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6',
                                '#1abc9c', '#34495e', '#e67e22', '#95a5a6', '#c0392b'
                            ]
                        ]
                    ]
                ];
                break;
                
            case 'user_metrics':
                $metrics = $this->Analytics_model->get_user_metrics($days);
                $data = [
                    'labels' => ['Total Users', 'New Users', 'Active Users', 'Banned Users'],
                    'datasets' => [
                        [
                            'label' => 'Count',
                            'data' => [
                                $metrics['total_users'],
                                $metrics['new_users'],
                                $metrics['active_users'],
                                $metrics['banned_users']
                            ],
                            'backgroundColor' => ['#3498db', '#2ecc71', '#f39c12', '#e74c3c']
                        ]
                    ]
                ];
                break;
                
            case 'server_metrics':
                $metrics = $this->Analytics_model->get_server_metrics();
                $data = [
                    'labels' => ['Total Characters', 'Online Players', 'Total Guilds'],
                    'datasets' => [
                        [
                            'label' => 'Count',
                            'data' => [
                                $metrics['total_characters'],
                                $metrics['online_players'],
                                $metrics['total_guilds']
                            ],
                            'backgroundColor' => ['#3498db', '#2ecc71', '#9b59b6']
                        ]
                    ]
                ];
                break;
                
            default:
                $data = ['error' => 'Invalid chart type'];
                break;
        }
        
        echo json_encode($data);
    }
}
