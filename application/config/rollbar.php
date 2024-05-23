<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;

$config['rollbar'] = array(
    'access_token' => '40bdd05d0b3243bdb191609a811ca28e',
    'environment' => 'production'
);

Rollbar::init($config['rollbar']);
