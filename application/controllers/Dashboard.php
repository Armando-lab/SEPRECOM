<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index() {
        // Verificar si el usuario está logueado
        if ($this->session->userdata($this->config->item('mycfg_session_object_name'))) {  
            // Obtener datos de sesión
            $session_data = $this->session->userdata($this->config->item('mycfg_session_object_name'));                            
            // Cargar base de datos con las credenciales del usuario
            $this->load->database($this->Seguridad_SIIA_Model->Obtener_DBConfig_Values($this->config->item('mycfg_usuario_conexion'),$this->config->item('mycfg_pwd_usuario_conexion')));            
            
            // Crear menú del usuario
            $data['menu'] = $this->Seguridad_SIIA_Model->Crear_Menu_Usuario($this->config->item('mycfg_id_aplicacion'),$session_data['default_pfc'],"Dashboard","");
            
            // Cargar modelo del dashboard
            $this->load->model('Dashboard_model');

            // Obtener datos del dashboard
            $data['prestamosActivos'] = $this->Dashboard_model->obtener_prestamos_activos();
            $data['prestamosVencidos'] = $this->Dashboard_model->obtener_prestamos_vencidos();
            $data['articuloMasPrestado'] = $this->Dashboard_model->obtener_articulo_mas_prestado();
            $data['totalPrestamos'] = $this->Dashboard_model->obtener_total_prestamos();

            $data['menu'] = $this->Seguridad_SIIA_Model->Crear_Menu_Usuario($this->config->item('mycfg_id_aplicacion'),$session_data['default_pfc'],"Dashboard","");

            // Cargar vista del dashboard
            $this->load->view('Dashboard', $data);
        } else {
            // Redireccionar al controlador por defecto si el usuario no está logueado
            redirect($this->router->default_controller);
        }   
    }


    public function mostrar_nombres_deudores() {
        // Cargar el modelo necesario
        $this->load->model('Dashboard_model');
    
        // Obtener los nombres de los deudores vencidos
        $data['nombres_deudores'] = $this->Dashboard_model->obtener_nombres_deudores_vencidos();
    
        // Cargar la vista modal con los datos obtenidos
        $this->load->view('Dashboard', $data);
    }
    
    public function mostrar_prestamos_vencidos() {
        if ($this->session->userdata($this->config->item('mycfg_session_object_name'))) {
            $session_data = $this->session->userdata($this->config->item('mycfg_session_object_name'));
            $this->load->database($this->Seguridad_SIIA_Model->Obtener_DBConfig_Values($this->config->item('mycfg_usuario_conexion'), $this->config->item('mycfg_pwd_usuario_conexion')));

            $this->load->model('Dashboard_model');
            $resPrestamos = $this->Dashboard_model->obtener_prestamos_profesores_vencidos();

            if ($resPrestamos) {
                $output = [];
                foreach ($resPrestamos->result_array() as $row) {
                    foreach ($row as $key => $value) {
                        if (gettype($value) == "string") {
                            $row[$key] = utf8_encode($value);
                        }
                    }
                    $output[] = $row;
                }
                print(json_encode(array("data" => $output)));
            } else {
                print(json_encode(array("data" => "")));
            }
        } else {
            redirect($this->router->default_controller);
        }
    }

    
    
    
    
}
?>
