<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_system'] = array(
    'class'    => '',
    'function' => 'init_rollbar',
    'filename' => 'rollbar.php',
    'filepath' => 'hooks'
);
