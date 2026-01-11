<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Cache Library Wrapper
 * 
 * This is a wrapper for CodeIgniter's native cache library
 * to ensure compatibility with the autoloader
 */
class Cache extends CI_Cache
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }
}
