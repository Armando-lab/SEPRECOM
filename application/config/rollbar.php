<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;

$config['rollbar'] = array(
    'access_token' => 'ca89b4b196634660a33efe0f5d2d76e6',
    'environment' => 'production'
);

Rollbar::init($config['rollbar']);
