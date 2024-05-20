<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {			
	
	public function Obtener_Cliente(){			
		$qry = "SELECT * FROM cliente WHERE matricula IS NOT NULL";
		$resqry = $this->db->query($qry);										
		if ($resqry->num_rows()>0){			
			return $resqry; 
		}else{			
			return 0;
		}		
	}
    
    public function Obtener_Usuarios_Por_Rol($rol){
        $qry = "SELECT * FROM cliente WHERE Rol_admin = ?";
        $resqry = $this->db->query($qry, array($rol));                                        
        if ($resqry->num_rows() > 0){            
            return $resqry->result_array();
        } else {            
            return array();
        }       
    }
    
	

	public function Obtener_Array_Nombre_Cliente(){
        $resqry = $this->Obtener_Cliente();												
        if ($resqry->num_rows() > 0){			
            $array = array();
            while ($row = $resqry->unbuffered_row('array')){
                $array[$row["matricula"]] = $row["nombre"];
            }
            return $array; 
        } else {			
            return 0;
        }		
    }
	
	public function Eliminar_Matricula($matricula){												
		$qry = "delete from cliente where matricula=?";
		$resqry = $this->db->query($qry,array((int)$matricula));			
		return ($this->db->affected_rows()>0);		
	}

	public function Obtener_Sig_Id_Usuario() {
        // Verificar que la conexi�n a la base de datos est� establecida
        if ($this->db !== null) {
            $qry = "SELECT COALESCE(max(matricula),0)+1 Sig_matricula from cliente";
            
            // Realizar la consulta
            $resqry = $this->db->query($qry);
    
            // Verificar si la consulta se ejecut� correctamente
            if ($resqry !== false && $resqry->num_rows() > 0) {
                $regqry = $resqry->unbuffered_row();
                return $regqry->Sig_matricula;
            } else {
                // Manejar el caso de una consulta sin resultados
                return 1;
            }
        } else {
            // Manejar el caso de una conexi�n nula
            return -1; // Puedes ajustar el valor de retorno seg�n tus necesidades
        }
    }
	
	public function Crear_Usuario($nombreUsuario,$correo,$cargo,$roladmin){						
		$Sig_matricula=$this->Obtener_Sig_Id_Usuario();		
		$qry = "insert into cliente (matricula,nombre,correo,cargo,Rol_admin,contrasena) values (?,?,?,?,?,'NEWTON')";
		$resqry = $this->db->query($qry,array((int)$Sig_matricula,$nombreUsuario,$correo,$cargo,$roladmin));			
		return ($this->db->affected_rows()>0);
	}
	
	public function Editar_Institucion($Id_Institucion,$Descrip_Institucion){								
		$qry = "update GC_Instituciones set Institucion=? where Id_Institucion=?";
		$resqry = $this->db->query($qry,array($Descrip_Institucion,(int)$Id_Institucion));			
		return ($this->db->affected_rows()==1);
	}
		
}
?>
