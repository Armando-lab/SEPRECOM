<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {





    public function index() {
        // Verificar si el usuario est� logueado
        if ($this->session->userdata($this->config->item('mycfg_session_object_name'))) {  
            // Obtener datos de sesi�n
            $session_data = $this->session->userdata($this->config->item('mycfg_session_object_name'));                            
            // Cargar base de datos con las credenciales del usuario
            $this->load->database($this->Seguridad_SIIA_Model->Obtener_DBConfig_Values($this->config->item('mycfg_usuario_conexion'),$this->config->item('mycfg_pwd_usuario_conexion')));            
            
            // Crear men� del usuario
            $data['menu'] = $this->Seguridad_SIIA_Model->Crear_Menu_Usuario($this->config->item('mycfg_id_aplicacion'),$session_data['default_pfc'],"team_view","");
            
            // Cargar modelo del dashboard
            $this->load->model('Team_model');
            $data['team_members'] = $this->Team_model->index();
            $this->load->view('team_view', $data);
        } else {
            // Redireccionar al controlador por defecto si el usuario no est� logueado
            redirect($this->router->default_controller);
        }   
    }
}
?>
