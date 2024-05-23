<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Rollbar_lib {
    
    public function __construct($config = array()) {
        if (!empty($config)) {
            $this->initialize($config);
        }
    }
    
    public function initialize($config = array()) {
        Rollbar\Rollbar::init($config);
    }

    public function log($level, $message, $context = array()) {
        Rollbar\Rollbar::log($level, $message, $context);
    }

    public function error($message, $context = array()) {
        $this->log('error', $message, $context);
    }
}
