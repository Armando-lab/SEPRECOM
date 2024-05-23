<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Incluir los archivos necesarios de Rollbar
require_once APPPATH . 'libraries/Rollbar/Rollbar.php';
require_once APPPATH . 'libraries/Rollbar/DataBuilder.php';
// Agrega más archivos necesarios de Rollbar aquí

class Rollbar_lib {
    
    public function __construct($config = array()) {
        $CI =& get_instance();
        $CI->config->load('rollbar', TRUE);
        $config = $CI->config->item('rollbar');

        if (!empty($config)) {
            $this->initialize($config);
        }
    }
    
    public function initialize($config = array()) {
        Rollbar\Rollbar::init(array(
            'access_token' => $config['access_token'],
            'environment' => $config['environment'],
            'root' => $config['root']
        ));
    }

    public function log($level, $message, $context = array()) {
        Rollbar\Rollbar::log($level, $message, $context);
    }

    public function error($message, $context = array()) {
        $this->log('error', $message, $context);
    }
}
