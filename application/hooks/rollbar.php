<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function init_rollbar() {
    $CI =& get_instance();
    $CI->config->load('rollbar');
}
