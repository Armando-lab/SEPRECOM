<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'third_party/rollbar/src/rollbar.php';
require_once APPPATH . 'third_party/rollbar/src/rollbar/logger.php';

class Rollbar {
    public function __construct() {
        // Configura Rollbar
        \Rollbar\Rollbar::init([
            'access_token' => '90e0aa2f80db40698ba64c70c02741e5',
            'environment' => ENVIRONMENT
        ]);
    }

    public function log_exception($exception) {
        \Rollbar\Rollbar::log(Level::error, $exception);
    }

    public function log_message($level, $message) {
        \Rollbar\Rollbar::log($level, $message);
    }
}
