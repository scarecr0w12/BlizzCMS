<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_response
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function success($data = null, $message = 'Success', $code = 200)
    {
        return $this->response([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function error($message = 'Error', $code = 400, $data = null)
    {
        return $this->response([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function paginated($items, $total, $page, $per_page, $message = 'Success')
    {
        return $this->response([
            'success' => true,
            'message' => $message,
            'data' => $items,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $per_page,
                'pages' => ceil($total / $per_page),
            ],
        ], 200);
    }

    private function response($data, $code = 200)
    {
        $this->CI->output
            ->set_status_header($code)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
