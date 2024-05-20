<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model extends CI_Model {

    public function get_team_members() {
        $json_data = file_get_contents(APPPATH . 'data/team_members.json');
        return json_decode($json_data, true);
    }
}
?>
 