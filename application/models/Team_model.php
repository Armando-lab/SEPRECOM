<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['team_members'] = [
            [
                'name' => 'Mercedes A Flores Moreno',
                'role' => 'Proyect Manager',
                'image' => 'Merci.jpeg'
            ],
            [
                'name' => 'Mario F Landa Lopez',
                'role' => 'QA',
                'image' => 'Mario.jpeg'
            ],
            [
                'name' => 'Alfonso R Moha Pacheco',
                'role' => 'Frontend',
                'image' => 'Armando.jpeg'
            ],
            [
                'name' => 'Arturo Perez Kantun',
                'role' => 'Backend',
                'image' => 'Arturo.jpeg'
            ],
            [
                'name' => 'Valentina Ramirez Lopez',
                'role' => 'Frontend',
                'image' => 'Vale.jpeg'
            ],
            [
                'name' => 'Armando L Tun Hernandez',
                'role' => 'Backend',
                'image' => 'Armando.jpeg'
            ],
            // Añade más miembros aquí
        ];

        $this->load->view('team_view', $data);
    }
}
?>
