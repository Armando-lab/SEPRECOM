<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {


    public function index() {
        $this->load->model('Team_model');
        $data['team_members'] = $this->Team_model->get_team_members();
        $this->load->view('team_view', $data);
    }
}
?>
