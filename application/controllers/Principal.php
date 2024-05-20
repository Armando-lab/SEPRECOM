<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function index(){
		if($this->session->userdata($this->config->item('mycfg_session_object_name'))){	
			$session_data = $this->session->userdata($this->config->item('mycfg_session_object_name'));							
			$this->load->database($this->Seguridad_SIIA_Model->Obtener_DBConfig_Values($this->config->item('mycfg_usuario_conexion'),$this->config->item('mycfg_pwd_usuario_conexion')));			
			
			/*
			$rowPerfil=$this->Seguridad_SIIA_Model->Obtener_DatosPerfil($session_data['username'],$this->config->item('mycfg_id_aplicacion'),$session_data['default_pfc']);						
			$this->db->close();							
			$this->load->database($this->Seguridad_SIIA_Model->Obtener_DBConfig_Values($rowPerfil->Dbname,$this->Seguridad_SIIA_Model->Desencriptar($rowPerfil->Password)));
			*/

			$this->load->model('producto_model');
			$data['array_producto']=$this->producto_model->Obtener_Array_Nombre_Producto();

			 // Cargar modelo del dashboard
			 $this->load->model('Dashboard_model');

			 // Obtener datos del dashboard
			 $data['prestamosActivos'] = $this->Dashboard_model->obtener_prestamos_activos();
			 $data['prestamosVencidos'] = $this->Dashboard_model->obtener_prestamos_vencidos();
			 $data['articuloMasPrestado'] = $this->Dashboard_model->obtener_articulo_mas_prestado();
			 $data['totalPrestamos'] = $this->Dashboard_model->obtener_total_prestamos();

			$this->load->model('cliente_model');
			$data['array_cliente']=$this->cliente_model->Obtener_Array_Nombre_Cliente();
			
			$data['menu']=$this->Seguridad_SIIA_Model->Crear_Menu_Usuario($this->config->item('mycfg_id_aplicacion'),$session_data['default_pfc'],"Principal","");
			$this->load->view('principal',$data);
		}else{			
			redirect($this->router->default_controller);
		}														
	}
	
	public function metodo_prueba(){					
		if($this->session->userdata($this->config->item('mycfg_session_object_name'))){	
			$session_data = $this->session->userdata($this->config->item('mycfg_session_object_name'));							
			$this->load->database($this->Seguridad_SIIA_Model->Obtener_DBConfig_Values($this->config->item('mycfg_usuario_conexion'),$this->config->item('mycfg_pwd_usuario_conexion')));			
			
			/*
			$rowPerfil=$this->Seguridad_SIIA_Model->Obtener_DatosPerfil($session_data['username'],$this->config->item('mycfg_id_aplicacion'),$session_data['default_pfc']);						
			$this->db->close();							
			$this->load->database($this->Seguridad_SIIA_Model->Obtener_DBConfig_Values($rowPerfil->Dbname,$this->Seguridad_SIIA_Model->Desencriptar($rowPerfil->Password)));
			*/
			
			$data['menu']=$this->Seguridad_SIIA_Model->Crear_Menu_Usuario($this->config->item('mycfg_id_aplicacion'),$session_data['default_pfc'],"Prueba","");
			$this->load->view('prueba',$data);
		}else{			
			redirect($this->router->default_controller);
		}														
	}

	public function mostrar_prestamos_vencidos() {
        // Verifica si el usuario está logueado usando los datos de sesión
        if ($this->session->userdata($this->config->item('mycfg_session_object_name'))) {

            $this->load->model('Dashboard_model');
            // Obtener los préstamos vencidos desde el modelo
            $resPrestamos = $this->Dashboard_model->obtener_prestamos_profesores_vencidos();

            // Preparar los datos para JSON
            if (!empty($resPrestamos)) {
                $output = [];
                foreach ($resPrestamos as $row) {
                    foreach ($row as $key => $value) {
                        // Codificar las cadenas en UTF-8 para asegurar la correcta visualización de caracteres especiales
                        if (is_string($value)) {
                            $row[$key] = utf8_encode($value);
                        }
                    }
                    $output[] = $row;
                }
                print(json_encode(array("data" => $output)));
            } else {
                // Devolver un array vacío si no hay préstamos vencidos
                print(json_encode(array("data" => [])));
            }
        } else {
            // Redirigir al controlador por defecto si el usuario no está logueado
            redirect($this->router->default_controller);
        }
    }
		
}
?>