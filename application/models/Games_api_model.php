<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Games_api_model extends CI_Model
{
    private $api_host = '140.150.202.236';
    private $api_port = 8081;
    private $cache_ttl = 300;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get server status including player count and uptime
     *
     * @return array|false
     */
    public function get_server_status()
    {
        $cache_key = 'games_api_status';
        
        try {
            if (isset($this->cache)) {
                $cached = $this->cache->get($cache_key);
                if ($cached !== false) {
                    return $cached;
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Games API Cache Error: ' . $e->getMessage());
        }

        $response = $this->_make_request('/api/server');
        
        if ($response) {
            $formatted = $this->_format_server_response($response);
            try {
                if (isset($this->cache)) {
                    $this->cache->save($cache_key, $formatted, $this->cache_ttl);
                }
            } catch (Exception $e) {
                log_message('error', 'Games API Cache Save Error: ' . $e->getMessage());
            }
            return $formatted;
        }

        log_message('error', 'Games API: Failed to fetch server status');
        return false;
    }

    /**
     * Format server API response to standard format
     *
     * @param array $response
     * @return array
     */
    private function _format_server_response($response)
    {
        return [
            'player_count' => $response['players_online'] ?? 0,
            'uptime' => $response['uptime_seconds'] ?? 0,
            'status' => ($response['players_online'] ?? 0) > 0 ? 'online' : 'offline',
            'version' => $response['version'] ?? '',
            'realm_name' => $response['realm_name'] ?? ''
        ];
    }

    /**
     * Get player count
     *
     * @return int|false
     */
    public function get_player_count()
    {
        $status = $this->get_server_status();
        
        if ($status && isset($status['player_count'])) {
            return (int)$status['player_count'];
        }

        return false;
    }

    /**
     * Get server uptime
     *
     * @return string|false
     */
    public function get_uptime()
    {
        $status = $this->get_server_status();
        
        if ($status && isset($status['uptime'])) {
            return $status['uptime'];
        }

        return false;
    }

    /**
     * Get realm statistics including progression
     *
     * @return array|false
     */
    public function get_progression()
    {
        $cache_key = 'games_api_realm_stats';
        
        try {
            if (isset($this->cache)) {
                $cached = $this->cache->get($cache_key);
                if ($cached !== false) {
                    return $cached;
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Games API Progression Cache Error: ' . $e->getMessage());
        }

        $response = $this->_make_request('/api/realm/stats');
        
        if ($response) {
            $formatted = $this->_format_realm_stats_response($response);
            try {
                if (isset($this->cache)) {
                    $this->cache->save($cache_key, $formatted, $this->cache_ttl);
                }
            } catch (Exception $e) {
                log_message('error', 'Games API Progression Cache Save Error: ' . $e->getMessage());
            }
            return $formatted;
        }

        log_message('error', 'Games API: Failed to fetch progression');
        return false;
    }

    /**
     * Get current progression (brackets and current bracket)
     *
     * @return array|false
     */
    public function get_current_progression()
    {
        $cache_key = 'games_api_progression';
        
        try {
            if (isset($this->cache)) {
                $cached = $this->cache->get($cache_key);
                if ($cached !== false) {
                    return $cached;
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Games API Progression Cache Error: ' . $e->getMessage());
        }

        $response = $this->_make_request('/api/server');
        
        if ($response && isset($response['progression'])) {
            $formatted = $this->_format_progression_response($response['progression']);
            try {
                if (isset($this->cache)) {
                    $this->cache->save($cache_key, $formatted, $this->cache_ttl);
                }
            } catch (Exception $e) {
                log_message('error', 'Games API Progression Cache Save Error: ' . $e->getMessage());
            }
            return $formatted;
        }

        return false;
    }

    /**
     * Format realm stats API response
     *
     * @param array $response
     * @return array
     */
    private function _format_realm_stats_response($response)
    {
        return [
            'player_count' => $response['player_count'] ?? 0,
            'max_players' => $response['max_players'] ?? 0,
            'uptime_seconds' => $response['uptime_seconds'] ?? 0,
            'realm_name' => $response['realm_name'] ?? ''
        ];
    }

    /**
     * Format progression API response
     *
     * @param array $response
     * @return array
     */
    private function _format_progression_response($response)
    {
        return [
            'active_brackets' => $response['active_brackets'] ?? [],
            'current_bracket' => $response['current_bracket'] ?? ''
        ];
    }

    /**
     * Get human-readable bracket name
     *
     * @param string $bracket_id
     * @return string
     */
    public function get_bracket_name($bracket_id)
    {
        $bracket_names = [
            '0' => 'Vanilla',
            '1_19' => 'Beginner Dungeons',
            '20_29' => 'Novice Dungeons',
            '30_39' => 'Intermediate Dungeons',
            '40_49' => 'Advanced Dungeons',
            '50_59_1' => 'Pre-Raid',
            '50_59_2' => 'Raid Preparation',
            '60_1_1' => 'Molten Core',
            '60_1_2' => 'Onyxia\'s Lair',
            '60_2_1' => 'Blackwing Lair',
            '60_2_2' => 'Zul\'Gurub',
            '60_3_1' => 'AQ20',
            '60_3_2' => 'AQ40',
            '60_3_3' => 'World Bosses',
            '61_64' => 'Outland Dungeons',
            '65_69' => 'Heroic Dungeons',
            '70_1_1' => 'Level 70 - Normal',
            '70_1_2' => 'Level 70 - Heroics',
            '70_2_1' => 'Gruul\'s Lair',
            '70_2_2' => 'Karazhan',
            '70_2_3' => 'Ogri\'la',
            '70_3_1' => 'Serpentshrine Cavern',
            '70_3_2' => 'The Eye',
            '70_4_1' => 'Mount Hyjal',
            '70_4_2' => 'Black Temple',
            '70_5' => 'Zul\'Aman',
            '70_6_1' => 'Isle of Quel\'Danas',
            '70_6_2' => 'Sunwell Plateau',
            '71_74' => 'Northrend Dungeons',
            '75_79' => 'Heroic Northrend',
            '80_1_1' => 'WotLK Dungeons',
            '80_1_2' => 'Heroic WotLK',
            '80_2' => 'Ulduar',
            '80_3' => 'Trial of the Crusader',
            '80_4_1' => 'Icecrown Citadel',
            '80_4_2' => 'Ruby Sanctum'
        ];

        return $bracket_names[$bracket_id] ?? ucfirst(str_replace('_', ' ', $bracket_id));
    }

    /**
     * Get list of online players
     *
     * @return array|false
     */
    public function get_online_players()
    {
        $cache_key = 'games_api_online_players';
        
        if (isset($this->cache)) {
            $cached = $this->cache->get($cache_key);
            if ($cached !== false) {
                return $cached;
            }
        }

        $response = $this->_make_request('/api/players');
        
        if ($response) {
            if (isset($this->cache)) {
                $this->cache->save($cache_key, $response, $this->cache_ttl);
            }
        }

        return $response;
    }

    /**
     * Make HTTP request to games API
     *
     * @param string $endpoint
     * @param string $method
     * @param array $data
     * @return array|false
     */
    private function _make_request($endpoint, $method = 'GET', $data = [])
    {
        $url = 'http://' . $this->api_host . ':' . $this->api_port . $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($method === 'POST' && !empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($http_code !== 200 || !$response) {
            log_message('error', 'Games API Error - Endpoint: ' . $endpoint . ', HTTP Code: ' . $http_code . ', cURL Error: ' . $curl_error);
            return false;
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            log_message('error', 'Games API JSON Decode Error - Endpoint: ' . $endpoint . ', Response: ' . $response);
            return false;
        }
        
        return $decoded;
    }

    /**
     * Format uptime string to human readable format
     *
     * @param string $uptime
     * @return string
     */
    public function format_uptime($uptime)
    {
        if (empty($uptime)) {
            return 'N/A';
        }

        if (is_numeric($uptime)) {
            $seconds = (int)$uptime;
            $days = floor($seconds / 86400);
            $hours = floor(($seconds % 86400) / 3600);
            $minutes = floor(($seconds % 3600) / 60);

            if ($days > 0) {
                return sprintf('%dd %dh %dm', $days, $hours, $minutes);
            } elseif ($hours > 0) {
                return sprintf('%dh %dm', $hours, $minutes);
            } else {
                return sprintf('%dm', $minutes);
            }
        }

        return $uptime;
    }
}
