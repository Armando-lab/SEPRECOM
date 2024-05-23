<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Rollbar\Rollbar as RollbarLib;
use Rollbar\Payload\Level;

class Rollbar {

    public function __construct()
    {
        $CI =& get_instance();
        $CI->config->load('rollbar');
        $rollbarConfig = $CI->config->item('rollbar');

        RollbarLib::init(array(
            'access_token' => $rollbarConfig['access_token'],
            'environment' => $rollbarConfig['environment'],
            'root' => $rollbarConfig['root'],
        ));
    }

    public function log($level, $message, $context = null)
    {
        RollbarLib::log($level, $message, $context);
    }

    public function debug($message, $context = null)
    {
        $this->log(Level::debug(), $message, $context);
    }

    public function info($message, $context = null)
    {
        $this->log(Level::info(), $message, $context);
    }

    public function warning($message, $context = null)
    {
        $this->log(Level::warning(), $message, $context);
    }

    public function error($message, $context = null)
    {
        $this->log(Level::error(), $message, $context);
    }

    public function critical($message, $context = null)
    {
        $this->log(Level::critical(), $message, $context);
    }
}