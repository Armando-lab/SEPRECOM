<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Principal</title>

<?php
	require "third_party/jquery.js";
	require "third_party/bootstrap.js";
	require "third_party/datatables.js";	
	require "third_party/bsdatatimepicker.js";
	require "third_party/googlecharts.js";
	require "owned/form_tweaks.js";
	require "owned/estilos_portal.php";
?>
	
</head>
<body>
	
<?php	
	$session_data = $this->session->userdata($this->config->item('mycfg_session_object_name'));		
	require "owned/navigation_bar.php";
	require "owned/footer.php";			
?>

	<!-- contenedor principal de la aplicaci?n -->		
	<div class='container main_div_container'>
					
		<div class='row'>
		
			<!-- Ubicaci?n actual dentro del portal -->	
			<div class='col-md-7'>
				<ol class='breadcrumb main_breadcrumb'>
					<li><a class='color_amarillo' href='principal'><?php echo $this->config->item('mycfg_nombre_aplicacion'); ?></a></li>
					<li class='active' style='color: white;'>Principal</li>											
				</ol>
			</div>		
			
<?php
			require "owned/notification_center.php";
			
			if (isset($notificacion_exito)){
				MostrarNotificacion($notificacion_exito,"OK",true);																					
			}
				
			if (isset($notificacion_error)){
				MostrarNotificacion($notificacion_error,"Error",true);																					
			}
?>	
		</div>	
	
		<!-- Espacio disponible para mostrar informaci?n del portal -->	
		<div class='row'>
			<div class='col-md-12'>
				<div class="jumbotron">
					<h1 style="font-style: italic;">Bienvenido, <font color='#000053'><?php echo $session_data['full_name']; ?></font></h1>
				</div>						
			</div>	
		</div>

		<div style="margin-left: 30px; margin-bottom:60px;"><h3>¿Qué deseas realizar?</h4></div>

		<div class="row">
					
					<div style="text-align: center; cursor: pointer;" class="col-md-4" id="Rprestamo">			
						<a style="text-decoration: none;background-color:#FFCD00;" class="thumbnail">
							<h4 style="color:#000053">Solicitar préstamo</h4>	
							<img style="width: 100px; padding: 10px;background-color:#000053; border-radius: 15px;" src="<?php echo base_url(); ?>application/views/imagenes/catalogo.png" alt="...">		  
							<p style="text-align: center; margin: 10px; color: #000053; --darkreader-inline-color: #bbb3a7;" data-darkreader-inline-color="">Haga clic aquí para realizar un préstamo.</p>
						</a>			  				  
						<div class="w-100"></div>
						<div class="row">							
						</div>
					</div>

				<!-- Ventana modal del formulario para realizar el registro de prestamo -->	
				<div class='modal fade' id='modalPrestamo'>
					<div class='modal-dialog'>
						<div style='width: 480px;' class='modal-content'>
							<div style="background-color: #000053;" class='modal-header'>
								<!--<button style="background-color: #FFCD00;" type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>-->
									<h4 style="color: white;" class='modal-title'>Datos del préstamo</h4>
							</div>
							<div class='modal-body'>
<?php 
							echo form_open("Prestamo/Crear_Solicitud","id='frmPrestamo' name='frmPrestamo' role='form'"); 
								//Agregamos los campos de la llave primaria como campos de tipo hidden
						
?>												
								<div class='row'>												
									<div class='col-md-12' id='div_col_val_errors' name='div_col_val_errors'>										
									</div>
								</div>

								<div class='row'>
									<div class='col-md-5'>
										Responsable de la entrega:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>									

										<input style="border: none; outline: none; !important; color:orange; font-size: 17px; font-weight: bold; margin-bottom: -25px;" type="text" name='Encargado' value="<?php echo set_value('Encargado', $session_data['full_name']); ?>" readonly />

										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-md-5'>
										Nombre del solicitante:
									</div>
									<br>
									<div class='col-md-8'>
										<div class='form-group'>											
<?php
											ComboBox("Nombre_Solicitante","Nombre_Solicitante","form-control","",1,false,1,$array_cliente,"","","","Nombre del solicitante");												
?>
										</div>
									</div>
								</div>

								<?php
									// Define las asignaciones de áreas para cada número de área
									$area_assignments = array(
										"1" => array("Edificio" => "B", "Tipo_Area" => "AULA"),
										"2" => array("Edificio" => "B", "Tipo_Area" => "AULA"),
										"3" => array("Edificio" => "B", "Tipo_Area" => "AULA"),
										"4" => array("Edificio" => "B", "Tipo_Area" => "AULA"),
										"5" => array("Edificio" => "B", "Tipo_Area" => "AULA"),
										"42" => array("Edificio" => "D", "Tipo_Area" => "AULA"),
										"43" => array("Edificio" => "D", "Tipo_Area" => "AULA"),
										"44" => array("Edificio" => "D", "Tipo_Area" => "AULA"),
										"45" => array("Edificio" => "D", "Tipo_Area" => "AULA"),
										"46" => array("Edificio" => "D", "Tipo_Area" => "AULA"),
										"47" => array("Edificio" => "D", "Tipo_Area" => "AULA"),
										"25" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"26" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"27" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"28" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"29" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"30" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"31" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"32" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"33" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"34" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"35" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"36" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"37" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"38" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"39" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"40" => array("Edificio" => "E", "Tipo_Area" => "AULA"),
										"17" => array("Edificio" => "F", "Tipo_Area" => "AULA")
										// Añade más asignaciones de áreas según sea necesario
									);

									// Función para imprimir un ComboBox
									function ComboBox($name, $id, $class, $onChange, $selectedIndex, $isMultiple, $size, $options, $style, $attrs, $prompt, $selected)
									{
										echo "<select name='$name' id='$id' class='$class' $onChange>";

										// Si hay un prompt, añádelo como la primera opción
										if ($prompt !== "")
											echo "<option value=''>$prompt</option>";

										// Iterar sobre las opciones y crear elementos de opción
										foreach ($options as $value => $text) {
											// Verificar si esta opción está seleccionada
											$isSelected = ($selected == $value) ? 'selected' : '';

											echo "<option value='$value' $isSelected>$text</option>";
										}

										echo "</select>";
									}

									// Obtener el número de área seleccionado
									$selected_area = isset($_POST['Id_Area']) ? $_POST['Id_Area'] : '';

									// Obtener los datos del área seleccionada
									$edificio = isset($area_assignments[$selected_area]) ? $area_assignments[$selected_area]['Edificio'] : '';
									$tipo_area = isset($area_assignments[$selected_area]) ? $area_assignments[$selected_area]['Tipo_Area'] : '';
								?>

								<div style="width: auto; display: flex; flex-wrap: wrap; align-items: flex-start;">
									<div style="flex: 0 0 auto; margin-right: 10px;">
										<div>Edificio:</div>
										<div style="width: 100px; margin-top: 5px;" class='form-group'>
											<?php ComboBox("Edificio","Edificio","form-control","",1,false,1,array("B"=>"B","D"=>"D","E"=>"E","F"=>"F"),"","","","Elige un edificio"); ?>
										</div>
									</div>
									
									<div style="flex: 0 0 auto; margin-right: 10px;">
										<div>Tipo Área:</div>
										<div style="width: 100px; margin-top: 5px;" class='form-group'>
											<?php ComboBox("Tipo_Area","Tipo_Area","form-control","",1,false,1,array("AULA"=>"AULA","LABORATORIO"=>"LABORATORIO"),"","","","Elige el área"); ?>
										</div>
									</div>

									<div style="flex: 0 0 auto; margin-right: 10px;">
										<div>Número de Área:</div>
										<div style="width: 100px; margin-top: 5px;" class='form-group'>
											<?php ComboBox("Id_Area","Id_Area","form-control","onchange='this.form.submit()'",1,false,1,array("1" => "1","2" => "2","3" => "3","4" => "4","5" => "5","42" => "42","43" => "43","44" => "44","45" => "45","46" => "46","47" => "47","25" => "25","26" => "26","27" => "27","28" => "28","29" => "29","30" => "30","31" => "31","32" => "32","33" => "33","34" => "34","35" => "35","36" => "36","37" => "37","38" => "38","39" => "39","40" => "40","17" => "17"),"","","","Selecciona el número de área", $selected_area); ?>
										</div>
									</div>
								</div>

									<?php
									// Imprimir los datos seleccionados si existen
									if ($edificio && $tipo_area) {
										echo "<div style='margin-top: 10px;'>";
										echo "Edificio seleccionado: $edificio<br>";
										echo "Tipo de área seleccionado: $tipo_area<br>";
										echo "Número de área seleccionado: $selected_area<br>";
										echo "</div>";
									}
									?>


								<div class='row'>
									<div class='col-md-8'>
										Equipo o accesorio solicitado:
									</div>
									<br>
									<div class='col-md-8'>
										<div class='form-group'>											
<?php 
											ComboBox("Equipo_Solicitado1","Equipo_Solicitado1","form-control","",1,false,1,$array_producto,"","","","Elige un equipo o accesorio");												
?>
										</div>
									</div>

									<div class='col-md-8'>
										<div class='form-group'>											
<?php 
											ComboBox("Equipo_Solicitado2","Equipo_Solicitado2","form-control","",1,false,1,$array_producto,"","","","Elige un equipo o accesorio");												
?>
										</div>
									</div>

									<div class='col-md-8'>
										<div class='form-group'>											
<?php 
											ComboBox("Equipo_Solicitado3","Equipo_Solicitado3","form-control","",1,false,1,$array_producto,"","","","Elige un equipo o accesorio");												
?>
										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-md-4'>
										Fecha de solicitud:
									</div>
									<br>
									<div class='col-md-8'>
										<div class='form-group'>											
<?php 
											DateEditBox("Fecha_solicitud", "Fecha_solicitud", "form-control", "", 1, 255, 255, false, "Fecha de solicitud", "");												
?>
										</div>
									</div>
								</div>



							</div>
							<div style="background-color: #000053;" class='modal-footer'>
								<button type='button' class='btn btn-close' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span>Cancelar</button>
								<button type='button'  class='btn btn-color' id='btnGuardarSolicitud' name='btnGuardarSolicitud' value='Guardar'><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				<!--este script realiza la accion de mostrar la ventana modal para registrar los datos del prestamo-->
					<script>
					$(document).ready(function () {
						$("#Rprestamo").click(function(){
							frmPrestamo.reset(); 
								//se muestra la ventana modal del formulario
								$('#modalPrestamo').modal();
								//se blanquea el div de errores del formulario
								$("#div_col_val_errors").html("");
						});
					});
					</script>


												
					<div style="text-align: center; cursor: pointer;" class="col-md-4" id="Verprestamo">			
						<a style="text-decoration: none;background-color:#FFCD00;" href='<?php echo base_url();?>index.php/prestamo' class="thumbnail">
							<h4 style="color:#000053">Ver préstamos</h4>	
							<img style="width: 100px; padding: 10px;background-color:#000053; border-radius: 15px;" src="<?php echo base_url(); ?>application/views/imagenes/ver.png" alt="...">			  
							<p style="text-align: center; margin: 10px; color: #000053; --darkreader-inline-color: #bbb3a7;" data-darkreader-inline-color="">Haga clic aquí para observar registro de préstamos.</p>		  
						</a>
						<div class="w-100"></div>
						<div class="row">							
						</div>			  				  
					</div>

					<div style="text-align: center; cursor: pointer;" class="col-md-4" id="Vperfil">			
						<a style="text-decoration: none;background-color:#FFCD00;" href='<?php echo base_url();?>index.php/devolucion' class="thumbnail">
							<h4 style="color:#000053">Realizar devolución</h4>
							<img style="width: 100px; padding: 10px;background-color:#000053; border-radius: 15px;" src="<?php echo base_url(); ?>application/views/imagenes/devolucion-de-producto.png" alt="...">			  
							<p style="text-align: center; margin: 10px; color: #000053; --darkreader-inline-color: #bbb3a7;" data-darkreader-inline-color="">Haga clic aquí para realizar la devolución.</p>
						</a>
						<div class="w-100"></div>
						<div class="row">							
						</div>			  				  
					</div>					
		</div>



				
			<!--guardar los prestamos realizados-->	
			<script>															
				$(document).ready(function () {
					$("#btnGuardarSolicitud").click(function(){
						$(this).prop("disabled", true).html("<span class='glyphicon glyphicon-floppy-disk'></span> Guardando....");
						$.ajax({
							type: "POST",
							url: "<?php echo base_url();?>index.php/Prestamo/Crear_Solicitud",
							data: $('#frmPrestamo').serialize(),
							success: function(msg){																					
								var msg_substr = msg.split("@", 4);
								var msg_html = msg_substr[0];
								var msg_cont_notif = msg_substr[1];
								var msg_result = msg_substr[2];
								var msg_val_errors = msg_substr[3];
								$('#div_notifications_content').html(msg_html);	
								$("#span_notif_count").html(msg_cont_notif);         																																																																					
								$('#modal_notificaciones').modal();								
								if (msg_result=="T"){																				
									$("#modalPrestamo").modal('hide');																				
									$('#tbPrestamo').DataTable().ajax.reload(null, false);
									$('#tbPrestamo').DataTable().page('last');
									$("#div_col_val_errors").html("");
								}else{
									$("#div_col_val_errors").html(msg_val_errors);
								}
								$("#btnGuardarSolicitud").prop("disabled", false).html("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar");							
							},
							error: function(){
								alert("Ocurrió un error al procesar la petición servidor.");
								$("#btnGuardarSolicitud").prop("disabled", false).html("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar");	
							}
						});
					});
										
				});
</script>

			<!---->



									
			
			
</div>
	
	
<?php
	require "owned/set_security_controller.php";
	require "owned/notification_messages_controller.php";
?>	
</body>
</html>