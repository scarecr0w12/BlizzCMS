<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User_subscription_model extends BS_Model
{
    protected $table = 'shop_user_subscriptions';
    protected $setCreatedField = true;
    protected $setUpdatedField = true;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create user subscription
     *
     * @param array $data
     * @return int|false
     */
    public function create($data)
    {
        $data['created_at'] = current_date();
        $data['started_at'] = current_date();

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Get user subscription by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get($id)
    {
        return $this->db->from($this->table . ' us')
            ->join('shop_subscriptions s', 's.id = us.subscription_id')
            ->select('us.*, s.name, s.description, s.subscription_type, s.benefits, s.interval_type, s.interval_count, s.delivery_items')
            ->where('us.id', $id)
            ->get()
            ->row();
    }

    /**
     * Get user subscriptions
     *
     * @param int $user_id
     * @param string|null $status
     * @return array
     */
    public function get_user_subscriptions($user_id, $status = null)
    {
        $query = $this->db->from($this->table . ' us')
            ->join('shop_subscriptions s', 's.id = us.subscription_id')
            ->select('us.*, s.name, s.description, s.subscription_type, s.benefits, s.interval_type, s.interval_count, s.price_dp, s.price_vp, s.price_money, s.currency, s.icon')
            ->where('us.user_id', $user_id);

        if ($status !== null) {
            $query->where('us.status', $status);
        }

        return $query->order_by('us.created_at', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Check if user has active subscription of a specific type
     *
     * @param int $user_id
     * @param int $subscription_id
     * @return bool
     */
    public function has_active_subscription($user_id, $subscription_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('subscription_id', $subscription_id)
            ->where('status', 'active')
            ->where('current_period_end >', current_date())
            ->count_all_results($this->table) > 0;
    }

    /**
     * Check if user has any active subscription of a type
     *
     * @param int $user_id
     * @param string $subscription_type
     * @return bool
     */
    public function has_subscription_type($user_id, $subscription_type)
    {
        return $this->db->from($this->table . ' us')
            ->join('shop_subscriptions s', 's.id = us.subscription_id')
            ->where('us.user_id', $user_id)
            ->where('s.subscription_type', $subscription_type)
            ->where('us.status', 'active')
            ->where('us.current_period_end >', current_date())
            ->count_all_results() > 0;
    }

    /**
     * Calculate next billing date
     *
     * @param string $interval_type
     * @param int $interval_count
     * @param string|null $from_date
     * @return string
     */
    public function calculate_next_billing_date($interval_type, $interval_count, $from_date = null)
    {
        $from = $from_date ? strtotime($from_date) : time();

        switch ($interval_type) {
            case 'daily':
                $next = strtotime("+{$interval_count} days", $from);
                break;
            case 'weekly':
                $next = strtotime("+{$interval_count} weeks", $from);
                break;
            case 'monthly':
                $next = strtotime("+{$interval_count} months", $from);
                break;
            case 'yearly':
                $next = strtotime("+{$interval_count} years", $from);
                break;
            default:
                $next = strtotime("+1 month", $from);
        }

        return date('Y-m-d H:i:s', $next);
    }

    /**
     * Renew subscription
     *
     * @param int $id
     * @param string $interval_type
     * @param int $interval_count
     * @return bool
     */
    public function renew($id, $interval_type, $interval_count)
    {
        $now = current_date();
        $next_period_end = $this->calculate_next_billing_date($interval_type, $interval_count, $now);

        return $this->update([
            'status' => 'active',
            'current_period_start' => $now,
            'current_period_end' => $next_period_end
        ], ['id' => $id]);
    }

    /**
     * Cancel subscription
     *
     * @param int $id
     * @return bool
     */
    public function cancel($id)
    {
        return $this->update([
            'status' => 'cancelled',
            'cancelled_at' => current_date()
        ], ['id' => $id]);
    }

    /**
     * Pause subscription
     *
     * @param int $id
     * @return bool
     */
    public function pause($id)
    {
        return $this->update([
            'status' => 'paused'
        ], ['id' => $id]);
    }

    /**
     * Resume subscription
     *
     * @param int $id
     * @return bool
     */
    public function resume($id)
    {
        return $this->update([
            'status' => 'active'
        ], ['id' => $id]);
    }

    /**
     * Get subscriptions due for renewal (for cron job)
     *
     * @return array
     */
    public function get_due_for_renewal()
    {
        return $this->db->from($this->table . ' us')
            ->join('shop_subscriptions s', 's.id = us.subscription_id')
            ->select('us.*, s.name, s.interval_type, s.interval_count, s.price_dp, s.price_vp, s.price_money')
            ->where('us.status', 'active')
            ->where('us.current_period_end <=', current_date())
            ->get()
            ->result();
    }

    /**
     * Get subscriptions due for item delivery (for cron job)
     *
     * @return array
     */
    public function get_due_for_delivery()
    {
        return $this->db->from($this->table . ' us')
            ->join('shop_subscriptions s', 's.id = us.subscription_id')
            ->select('us.*, s.name, s.delivery_items, s.interval_type, s.interval_count')
            ->where('us.status', 'active')
            ->where('us.current_period_end >', current_date())
            ->group_start()
                ->where('us.last_delivery_at IS NULL')
                ->or_where('us.last_delivery_at < us.current_period_start')
            ->group_end()
            ->where('s.delivery_items IS NOT NULL')
            ->get()
            ->result();
    }

    /**
     * Update last delivery date
     *
     * @param int $id
     * @return bool
     */
    public function mark_delivered($id)
    {
        return $this->update([
            'last_delivery_at' => current_date()
        ], ['id' => $id]);
    }

    /**
     * Expire subscriptions (for cron job)
     *
     * @return int
     */
    public function expire_old_subscriptions()
    {
        return $this->db->where('status', 'active')
            ->where('current_period_end <', current_date())
            ->where_not_in('payment_method', ['paypal', 'stripe']) // Don't expire auto-renewing
            ->update($this->table, ['status' => 'expired']);
    }

    /**
     * Get all user subscriptions (admin)
     *
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_all($limit, $offset, $filters = [])
    {
        $query = $this->db->from($this->table . ' us')
            ->join('shop_subscriptions s', 's.id = us.subscription_id')
            ->join('users u', 'u.id = us.user_id', 'left')
            ->select('us.*, s.name, s.subscription_type, u.nickname, u.username');

        if (! empty($filters['status'])) {
            $query->where('us.status', $filters['status']);
        }

        if (! empty($filters['user_id'])) {
            $query->where('us.user_id', $filters['user_id']);
        }

        return $query->order_by('us.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count all user subscriptions (admin)
     *
     * @param array $filters
     * @return int
     */
    public function count_all($filters = [])
    {
        $query = $this->db->from($this->table . ' us');

        if (! empty($filters['status'])) {
            $query->where('us.status', $filters['status']);
        }

        if (! empty($filters['user_id'])) {
            $query->where('us.user_id', $filters['user_id']);
        }

        return $query->count_all_results();
    }

    /**
     * Get subscription statistics
     *
     * @return object
     */
    public function get_statistics()
    {
        $stats = new stdClass();
        
        $stats->total = $this->db->count_all_results($this->table);
        
        $stats->active = $this->db->where('status', 'active')
            ->count_all_results($this->table);
        
        $stats->cancelled = $this->db->where('status', 'cancelled')
            ->count_all_results($this->table);
        
        $stats->expired = $this->db->where('status', 'expired')
            ->count_all_results($this->table);

        return $stats;
    }
}
