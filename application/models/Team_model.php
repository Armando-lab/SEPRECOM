<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model extends CI_Controller {

    public function index() {
        $data['team_members'] = array(
            array(
                'name' => 'Mercedes A Flores Moreno',
                'role' => 'Proyect Manager',
                'image' => 'Merci.jpeg'
            ),
            array(
                'name' => 'Mario F Landa Lopez',
                'role' => 'QA',
                'image' => 'Mario.jpeg'
            ),
            array(
                'name' => 'Alfonso R Moha Pacheco',
                'role' => 'Frontend',
                'image' => 'Armando.jpeg'
            ),
            array(
                'name' => 'Arturo Perez Kantun',
                'role' => 'Backend',
                'image' => 'Arturo.jpeg'
            ),
            array(
                'name' => 'Valentina Ramirez Lopez',
                'role' => 'Frontend',
                'image' => 'Vale.jpeg'
            ),
            array(
                'name' => 'Armando L Tun Hernandez',
                'role' => 'Backend',
                'image' => 'Armando.jpeg'
            )
            // Añade más miembros aquí
        );

        $this->load->view('team_view', $data);
    }
}
?>
