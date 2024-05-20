<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Esto carga la biblioteca de la base de datos
    }

    public function obtener_prestamos_activos() {
        $query = $this->db->query("SELECT COUNT(*) AS num_prestamos_activos FROM devolucion WHERE estado = 'prestado'");
        $result = $query->row();
        return $result->num_prestamos_activos;
    }

    public function obtener_prestamos_vencidos() {
        // Obtener la fecha actual
        $fecha_actual = date('Y-m-d H:i:s');
    
        // Calcular la fecha de vencimiento (24 horas después de la fecha de préstamo)
        $fecha_vencimiento = date('Y-m-d H:i:s', strtotime('-24 hours', strtotime($fecha_actual)));
    
        // Realizar la consulta para obtener los préstamos vencidos
        $this->db->where('fecha_prest <', $fecha_vencimiento);
        $query = $this->db->get('prestamo'); // Reemplaza 'prestamo' con el nombre real de la tabla en tu base de datos
    
        // Contar los préstamos vencidos
        return $query->num_rows();
    }
           
    public function obtener_nombres_deudores_vencidos() {
        // Obtener la fecha actual
        $fecha_actual = date('Y-m-d H:i:s');
    
        // Construir la consulta SQL para obtener los nombres de los profesores cuyos préstamos están vencidos
        $this->db->select('profesor');
        $this->db->where('fecha_prest <', $fecha_actual); // Fecha de préstamo menor que la fecha actual
        $query = $this->db->get('prestamo');
    
        // Verificar si se encontraron resultados
        if ($query->num_rows() > 0) {
            return $query->result_array(); // Devolver los nombres de los profesores como un array
        } else {
            return array(); // Devolver un array vacío si no se encontraron resultados
        }
    }
    

    public function obtener_articulo_mas_prestado() {
        $query = $this->db->query("SELECT id_producto, COUNT(*) AS cantidad_prestamos FROM devolucion GROUP BY id_producto ORDER BY cantidad_prestamos DESC LIMIT 1");
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->id_producto;
        }
        return false;
    }

    public function obtener_total_prestamos() {
        $query = $this->db->query("SELECT COUNT(*) AS total_prestamos FROM devolucion");
        $result = $query->row();
        return $result->total_prestamos;
    }

    public function obtener_prestamos_profesores_vencidos() {
        $this->db->select('id_solicitud, profesor');
        $this->db->from('prestamos');
        $this->db->where('DATE_ADD(fecha_prestamo, INTERVAL 3 DAY) <', 'CURDATE()', FALSE);
        $query = $this->db->get();
        return $query;
    }
}
?>
