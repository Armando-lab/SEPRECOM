<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Log extends CI_Log {

    public function write_log($level = 'error', $msg, $php_error = FALSE) {
        parent::write_log($level, $msg, $php_error);

        $CI =& get_instance();
        $CI->rollbar->log_message($level, $msg);
    }
}
