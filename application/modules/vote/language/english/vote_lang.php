<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['vote'] = 'Vote';
$lang['vote_title'] = 'Vote for Us';
$lang['vote_description'] = 'Support our server by voting on various toplists. Each vote rewards you with Vote Points!';
$lang['vote_disabled'] = 'The voting system is currently disabled.';

// Vote sites
$lang['vote_sites'] = 'Vote Sites';
$lang['vote_site'] = 'Vote Site';
$lang['vote_no_sites'] = 'No vote sites are currently available.';
$lang['vote_available_sites'] = 'Available Vote Sites';

// Voting
$lang['vote_now'] = 'Vote Now';
$lang['vote_click_to_vote'] = 'Click to Vote';
$lang['vote_vp_reward'] = 'VP Reward';
$lang['vote_cooldown'] = 'Cooldown';
$lang['vote_cooldown_hours'] = 'Cooldown (Hours)';
$lang['vote_hours'] = 'hours';

// Status messages
$lang['vote_success'] = 'Thank you for voting! You have been awarded %d Vote Points.';
$lang['vote_already_voted'] = 'You have already voted on this site recently.';
$lang['vote_cooldown_active'] = 'You can vote again in %d hours and %d minutes.';
$lang['vote_invalid_callback'] = 'Invalid vote callback. Please try voting again.';
$lang['vote_can_vote'] = 'Ready to vote!';
$lang['vote_wait'] = 'Wait %s';

// History
$lang['vote_history'] = 'Vote History';
$lang['vote_no_history'] = 'You have not voted yet.';
$lang['vote_date'] = 'Date';
$lang['vote_site_name'] = 'Site';
$lang['vote_points_awarded'] = 'Points Awarded';

// Top voters
$lang['vote_top_voters'] = 'Top Voters';
$lang['vote_total_votes'] = 'Total Votes';
$lang['vote_vote_count'] = 'Votes';
$lang['vote_rank'] = 'Rank';

// Admin
$lang['vote_admin'] = 'Vote Management';
$lang['vote_statistics'] = 'Statistics';
$lang['vote_today'] = 'Today';
$lang['vote_this_month'] = 'This Month';
$lang['vote_total_vp_awarded'] = 'Total VP Awarded';
$lang['vote_active_sites'] = 'Active Sites';
$lang['vote_recent_votes'] = 'Recent Votes';
$lang['vote_logs'] = 'Vote Logs';

// Admin sites
$lang['vote_site_added'] = 'Vote site has been added successfully.';
$lang['vote_site_add_error'] = 'Failed to add vote site. Please try again.';
$lang['vote_site_updated'] = 'Vote site has been updated successfully.';
$lang['vote_site_update_error'] = 'Failed to update vote site. Please try again.';
$lang['vote_site_deleted'] = 'Vote site has been deleted successfully.';
$lang['vote_site_delete_error'] = 'Failed to delete vote site. Please try again.';
$lang['vote_add_site'] = 'Add Vote Site';
$lang['vote_edit_site'] = 'Edit Vote Site';
$lang['vote_delete_site'] = 'Delete Vote Site';
$lang['vote_confirm_delete_site'] = 'Are you sure you want to delete this vote site?';

// Site configuration
$lang['vote_url'] = 'Vote URL';
$lang['vote_url_help'] = 'Use {username} or {user_id} as placeholder for the username/user ID';
$lang['vote_callback_url'] = 'Callback URL';
$lang['vote_callback_url_help'] = 'URL to verify vote (optional)';

// Settings
$lang['vote_settings'] = 'Vote Settings';
$lang['vote_enabled'] = 'Enable Voting';
$lang['vote_points_per_vote'] = 'Default Points Per Vote';
$lang['vote_default_cooldown'] = 'Default Cooldown (Hours)';

// Buttons
$lang['vote_view_sites'] = 'View Vote Sites';
$lang['vote_view_history'] = 'View History';

// Admin Dashboard
$lang['vote_admin_title'] = 'Vote Management';
$lang['vote_manage_sites'] = 'Manage Sites';
$lang['vote_manage_sites_desc'] = 'Add, edit, or remove vote sites';
$lang['vote_logs_desc'] = 'View detailed voting logs and activity';
$lang['vote_settings_desc'] = 'Configure voting system settings';
$lang['vote_view_public'] = 'View Public Page';
$lang['vote_view_public_desc'] = 'See the voting page as users see it';
$lang['vote_no_votes'] = 'No votes have been recorded yet.';
$lang['vote_no_logs'] = 'No vote logs found.';
$lang['vote_votes_today'] = 'Votes Today';

// Settings
$lang['vote_enabled_help'] = 'Allow users to vote for your server';
$lang['vote_cooldown_help'] = 'Hours users must wait between votes (applies to new sites by default)';
$lang['vote_default_vp'] = 'Default VP Per Vote';
$lang['vote_default_vp_help'] = 'Default vote points awarded per vote (can be overridden per site)';
$lang['vote_ip_check'] = 'Enable IP Check';
$lang['vote_ip_check_help'] = 'Prevent multiple votes from same IP address';
$lang['vote_display_settings'] = 'Display Settings';
$lang['vote_top_voters_count'] = 'Top Voters Count';
$lang['vote_top_voters_count_help'] = 'Number of top voters to display';
$lang['vote_show_top_sidebar'] = 'Show Top Voters in Sidebar';
$lang['vote_show_top_sidebar_help'] = 'Display top voters widget in sidebar';

// Misc
$lang['vote_all_sites'] = 'All Sites';
$lang['vote_site_desc_placeholder'] = 'Enter a description for this vote site...';
$lang['vote_image_help'] = 'Optional logo/banner for the vote site';
$lang['voting_points'] = 'Vote Points';
$lang['total_vp'] = 'Total VP';
