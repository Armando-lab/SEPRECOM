<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Team_model');
    }

    public function index() {
        $data['team_members'] = $this->Team_model->get_team_members();
        $this->load->view('team_view', $data);
    }
}
?>
