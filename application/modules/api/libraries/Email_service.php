<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_service
{
    private $CI;
    private $from_email;
    private $from_name;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
        
        $this->from_email = $this->CI->config->item('email_from') ?: 'noreply@blizzcms.com';
        $this->from_name = $this->CI->config->item('email_from_name') ?: 'BlizzCMS';
    }

    public function send_notification_email($user_email, $subject, $message, $action_url = null)
    {
        $html_message = $this->build_email_template($subject, $message, $action_url);

        $this->CI->email->from($this->from_email, $this->from_name);
        $this->CI->email->to($user_email);
        $this->CI->email->subject($subject);
        $this->CI->email->message($html_message);
        $this->CI->email->set_mailtype('html');

        return $this->CI->email->send();
    }

    public function send_bulk_email($recipients, $subject, $message)
    {
        $success_count = 0;

        foreach ($recipients as $email) {
            if ($this->send_notification_email($email, $subject, $message)) {
                $success_count++;
            }
        }

        return $success_count;
    }

    public function send_welcome_email($user_email, $username)
    {
        $subject = 'Welcome to ' . $this->from_name;
        $message = "Welcome, {$username}! Your account has been created successfully.";
        $action_url = site_url('profile/edit');

        return $this->send_notification_email($user_email, $subject, $message, $action_url);
    }

    public function send_password_reset_email($user_email, $reset_token)
    {
        $subject = 'Password Reset Request';
        $reset_url = site_url('auth/reset_password/' . $reset_token);
        $message = 'Click the button below to reset your password.';

        return $this->send_notification_email($user_email, $subject, $message, $reset_url);
    }

    public function send_event_reminder($user_email, $event_name, $event_url)
    {
        $subject = 'Reminder: ' . $event_name . ' is starting soon!';
        $message = 'You have an event coming up. Click below to view details.';

        return $this->send_notification_email($user_email, $subject, $message, $event_url);
    }

    public function send_purchase_confirmation($user_email, $order_id, $total)
    {
        $subject = 'Purchase Confirmation - Order #' . $order_id;
        $message = 'Thank you for your purchase! Total: $' . number_format($total, 2);
        $order_url = site_url('shop/orders/' . $order_id);

        return $this->send_notification_email($user_email, $subject, $message, $order_url);
    }

    private function build_email_template($subject, $message, $action_url = null)
    {
        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                .footer { background: #333; color: white; padding: 10px; text-align: center; font-size: 12px; border-radius: 0 0 5px 5px; }
                .button { display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>' . $this->from_name . '</h1>
                </div>
                <div class="content">
                    <h2>' . htmlspecialchars($subject) . '</h2>
                    <p>' . nl2br(htmlspecialchars($message)) . '</p>';
        
        if ($action_url) {
            $html .= '<a href="' . $action_url . '" class="button">View Details</a>';
        }

        $html .= '
                </div>
                <div class="footer">
                    <p>&copy; ' . date('Y') . ' ' . $this->from_name . '. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';

        return $html;
    }
}
