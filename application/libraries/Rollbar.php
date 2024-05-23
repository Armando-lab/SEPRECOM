<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'application/libraries/rollbar/src/Rollbar.php'; // Ajusta la ruta a la ubicación correcta de rollbar.php

class Rollbar {
    public function __construct() {
        \Rollbar\Rollbar::init([
            'access_token' => '6ca3dfab2cd0441f962391f4bf6ead5c',
            'environment' => ENVIRONMENT,
            'root' => FCPATH
        ]);
    }
}
