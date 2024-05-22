<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Solicitud</title>

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
		
			<!-- Ubicaci�n actual dentro del portal -->	
			<div class='col-md-7'>
				<ol class='breadcrumb main_breadcrumb'>
					<li><a class='color_amarillo' href='principal'><?php echo $this->config->item('mycfg_nombre_aplicacion'); ?></a></li>
					<li class='color_amarillo'>Procesos</li>											
					<li class='active' style='color: white;'>Solicitudes</li>											
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
		
			<div id="adminOptions" >
					<!-- Standard button -->
					<button style="margin-bottom: 15px;" type="button" id="CrearNuevo" class="btn btn-primary">Nuevo</button>
						<script>
							$(document).ready(function(){
								$("#CrearNuevo").click(function(){
									frmPrestamo.reset(); 
									//se muestra la ventana modal del formulario
									$('#modalPrestamo').modal();
									//se blanquea el div de errores del formulario
									$("#div_col_val_errors").html("");
								});
							});
						</script>

					<!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
					<button style="margin-bottom: 15px;" type="button" id="EditarElemento" class="btn btn-primary">Editar</button>
							<script>
								$(document).ready(function () {
									$("#EditarElemento").click(function(){
							
										//se obtienen los datos del registro seleccionado de la tabla
										var count = $('#tbPrestamo').DataTable().rows({ selected: true }).count();
										if (count==1){
											var rows =  $('#tbPrestamo').DataTable().rows({ selected: true }).indexes();
											var data =  $('#tbPrestamo').DataTable().rows( rows ).data();												
											//se resetean los valores del formulario
											frmEditarPrestamo.reset();
											//se inicializan los valores del formulario
											$('#e_id_Solicitud').val(data[0].id_solicitud);
											$('#p_e_id_solicitud').html(data[0].id_solicitud);
											$('#Nombre_Solicitante1').val(data[0].profesor);
											$('#Edificio1').val(data[0].Edificio);
											$('#Tipo_Area1').val(data[0].Tipo_Area);
											$('#Id_Area1').val(data[0].Num_Area);
											$('#Encargado1').val(data[0].encargado_prest);
											$('#Fecha_solicitud1').val(data[0].fecha_prest);
											//se muestra la ventana modal del formulario
											$('#modalPrestamoEditar').modal();
											//se blanquea el div de errores del formulario
											$("#div_col_e_val_errors").html("");
										}else{
											alert('Debe elegir un registro');
										}
									});
								});
							</script>


					<!-- Contextual button for informational alert messages -->
					<button style="margin-bottom: 15px;" type="button" id="VerElemento" class="btn btn-primary">Ver Información</button>
							<script>
								$(document).ready(function () {
									$("#VerElemento").click(function(){
										//se obtienen los datos del registro seleccionado de la tabla
										var count = $('#tbPrestamo').DataTable().rows({ selected: true }).count();
										if (count==1){
											var rows =  $('#tbPrestamo').DataTable().rows({ selected: true }).indexes();
											var data =  $('#tbPrestamo').DataTable().rows( rows ).data();												
											//se inicializan los valores del formulario												
											$('#p_v_id_Solicitud').html(data[0].id_solicitud);
											$('#p_v_encargado').html(data[0].encargado_prest);
											$('#p_v_Solicitante').html(data[0].nombre);
											$('#p_v_Edificio').html(data[0].Edificio);
											$('#p_v_Tipoarea').html(data[0].Tipo_Area);
											$('#p_v_N_area').html(data[0].Num_Area);
											$('#p_v_fecha').html(data[0].fecha_prest);
											//se muestra la ventana modal del formulario
											$('#modalVisualizarPrestamo').modal();
										}else{
											alert('Debe elegir un registro');
										}
									});
								});

							</script>

				</div>


	
		<!-- Espacio disponible para mostrar informaci?n del portal -->	
		<div class='row'>
			<div class='col-md-12'>
<script>															
				$(document).ready(function () {
					$("#btnGuardarSolicitud").click(function(){
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
							},
							error: function(){
								alert("Ocurrio un error al procesar la petición al servidor.");
							}
						});
					});
										
				});
</script>

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
							echo form_open("Prestamo/Crear_Solicitud", "id='frmPrestamo' name='frmPrestamo' role='form'");
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

							<div class="row">
								<div class="col-md-6">
									<!-- Campo de b�squeda -->
									<label for="busqueda">Buscar cliente:</label>
									<input type="text" id="busqueda" class="form-control">
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-md-6">
									<!-- Selector para los clientes filtrados -->
									<select id="selector" size="1" name="Nombre_Solicitante" class="form-control">
										<?php foreach ($array_cliente as $cliente) : ?>
											<option value="<?php echo $cliente; ?>"><?php echo $cliente; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<!-- Script de JavaScript -->
							<script>
								$(document).ready(function() {
									// Agrega un evento de cambio al campo de b�squeda
									$('#busqueda').on('input', function() {
										var busqueda = $(this).val().toLowerCase();
										if (busqueda.trim() !== '') {
											$('#selector').show(); // Muestra el selector si hay una b�squeda
										} else {
											$('#selector').hide(); // Oculta el selector si no hay b�squeda
										}
										$('#selector option').each(function() {
											var cliente = $(this).text().toLowerCase();
											if (cliente.includes(busqueda)) {
												$(this).show();
											} else {
												$(this).hide();
											}
										});
									});
								});
							</script>

							<div style="width: auto; display: flex; flex-wrap: wrap; align-items: flex-start;">
								<div style="flex: 0 0 auto; margin-right: 10px;">
									<div>Edificio:</div>
									<div style="width: 100px; margin-top: 5px;" class='form-group'>
										<select name="Edificio" id="Edificio" class="form-control" onchange="fillAreas(this.value, document.getElementById('Tipo_Area').value)">
											<option value="B">B</option>
											<option value="D">D</option>
											<option value="E">E</option>
											<option value="F">F</option>
											<option value="Externo">Externo</option>

										</select>
									</div>
								</div>

								<div style="flex: 0 0 auto; margin-right: 10px;">
									<div>Tipo Área:</div>
									<div style="width: 100px; margin-top: 5px;" class='form-group'>
										<select name="Tipo_Area" id="Tipo_Area" class="form-control" onchange="fillAreas(document.getElementById('Edificio').value, this.value)">
											<option value="AULA">AULA</option>
											<option value="LABORATORIO">LABORATORIO</option>
											<option value="Sala CIC">Sala CIC</option>
											<option value="I+D+I">I+D+I</option>
										</select>
									</div>
								</div>

								<div style="flex: 0 0 auto; margin-right: 10px;">
									<div>Número de Área:</div>
									<div style="width: 100px; margin-top: 5px;" class='form-group'>
										<select name="Id_Area" id="Id_Area" class="form-control" onchange="updateFields()">
											<!-- Options will be filled by JavaScript -->
										</select>
									</div>
								</div>
							</div>
							<div class='row'>
								<br>
								<div class='col-md-8'>
									<div class='form-group'>
										<div class="row">
											<div class="col-md-9">
												<!-- Campo de b�squeda -->
												<label for="busqueda1">Equipo o accesorio solicitado:</label>
												<input type="text" id="busqueda1" name="Equipo_Solicitado1" class="form-control" placeholder="Selecciona un producto">
												<input type="hidden" id="producto_id1" name="producto_id1"> <!-- Agregar un campo oculto para almacenar el ID del producto -->
											</div>
										</div>
										<div class="row mt-3">
											<div class="col-md-6">
												<!-- Selector para los productos filtrados -->
												<select id="selector1" size="1" class="form-control">
													<option value="">Selecciona un producto</option> <!-- Agregar una opci�n por defecto -->
													<?php foreach ($array_producto as $id => $nombre) : ?>
														<option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
								</div>

								<script>
									$(document).ready(function() {
										// Agregar evento de cambio al selector
										$('#selector1').on('change', function() {
											var selectedProduct = $(this).val(); // Obtener el ID del producto seleccionado
											var selectedProductName = $(this).find(':selected').text(); // Obtener el nombre del producto seleccionado
											$('#busqueda1').val(selectedProductName); // Rellenar el input con el nombre del producto
											$('#producto_id1').val(selectedProduct); // Asignar el ID del producto al campo oculto

											// Cambiar el nombre del campo oculto solo si no ha sido cambiado previamente
											if ($('#producto_id1').attr('name') !== 'Equipo_Solicitado1') {
												$('#producto_id1').attr('name', 'Equipo_Solicitado1');
											}
										});

										// Agregar evento de b�squeda al input
										$('#busqueda1').on('input', function() {
											var busqueda1 = $(this).val().toLowerCase();
											if (busqueda1.trim() !== '') {
												$('#selector1').show(); // Muestra el selector si hay una b�squeda
											} else {
												$('#selector1').hide(); // Oculta el selector si no hay b�squeda
											}
											$('#selector1 option').each(function() {
												var producto = $(this).text().toLowerCase();
												if (producto.includes(busqueda1)) {
													$(this).show();
												} else {
													$(this).hide();
												}
											});
										});
									});
								</script>


								<div class='col-md-8'>
									<div class='form-group'>
										<div class="row">
											<div class="col-md-9">
												<!-- Campo de b�squeda -->
												<label for="busqueda2">Equipo o accesorio solicitado:</label>
												<input type="text" id="busqueda2" name="Equipo_Solicitado2" class="form-control" placeholder="Selecciona un producto">
												<input type="hidden" id="producto_id2" name="producto_id2"> <!-- Agregar un campo oculto para almacenar el ID del producto -->
											</div>
										</div>
										<div class="row mt-3">
											<div class="col-md-6">
												<!-- Selector para los productos filtrados -->
												<select id="selector2" size="1" class="form-control">
													<option value="">Selecciona un producto</option> <!-- Agregar una opci�n por defecto -->
													<?php foreach ($array_producto as $id => $nombre) : ?>
														<option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
								</div>

								<script>
									$(document).ready(function() {
										// Ocultar el selector al cargar la p�gina
										$('#selector2').hide();

										// Agregar evento de cambio al selector
										$('#selector2').on('change', function() {
											var selectedProduct = $(this).val(); // Obtener el ID del producto seleccionado
											var selectedProductName = $(this).find(':selected').text(); // Obtener el nombre del producto seleccionado
											$('#busqueda2').val(selectedProductName); // Rellenar el input con el nombre del producto
											$('#producto_id2').val(selectedProduct); // Asignar el ID del producto al campo oculto

											// Cambiar el nombre del campo oculto solo si no ha sido cambiado previamente
											if ($('#producto_id2').attr('name') !== 'Equipo_Solicitado2') {
												$('#producto_id2').attr('name', 'Equipo_Solicitado2');
											}
										});

										// Agregar evento de b�squeda al input
										$('#busqueda2').on('input', function() {
											var busqueda2 = $(this).val().toLowerCase();
											if (busqueda2.trim() !== '') {
												$('#selector2').show(); // Muestra el selector si hay una b�squeda
											} else {
												$('#selector2').hide(); // Oculta el selector si no hay b�squeda
											}
											$('#selector2 option').each(function() {
												var producto2 = $(this).text().toLowerCase();
												if (producto2.includes(busqueda2)) {
													$(this).show();
												} else {
													$(this).hide();
												}
											});
										});
									});
								</script>

								<div class='col-md-8'>
									<div class='form-group'>
										<div class="row">
											<div class="col-md-9">
												<!-- Campo de b�squeda -->
												<label for="busqueda3">Equipo o accesorio solicitado:</label>
												<input type="text" id="busqueda3" name="Equipo_Solicitado3" class="form-control" placeholder="Selecciona un producto">
												<input type="hidden" id="producto_id3" name="producto_id3"> <!-- Agregar un campo oculto para almacenar el ID del producto -->
											</div>
										</div>
										<div class="row mt-3">
											<div class="col-md-6">
												<!-- Selector para los productos filtrados -->
												<select id="selector3" size="1" class="form-control">
													<option value="">Selecciona un producto</option> <!-- Agregar una opci�n por defecto -->
													<?php foreach ($array_producto as $id => $nombre) : ?>
														<option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
								</div>

								<script>
									$(document).ready(function() {
										// Ocultar el selector al cargar la p�gina
										$('#selector3').hide();

										// Agregar evento de cambio al selector
										$('#selector3').on('change', function() {
											var selectedProduct = $(this).val(); // Obtener el ID del producto seleccionado
											var selectedProductName = $(this).find(':selected').text(); // Obtener el nombre del producto seleccionado
											$('#busqueda3').val(selectedProductName); // Rellenar el input con el nombre del producto
											$('#producto_id3').val(selectedProduct); // Asignar el ID del producto al campo oculto

											// Cambiar el nombre del campo oculto solo si no ha sido cambiado previamente
											if ($('#producto_id3').attr('name') !== 'Equipo_Solicitado3') {
												$('#producto_id3').attr('name', 'Equipo_Solicitado3');
											}
										});

										// Agregar evento de b�squeda al input
										$('#busqueda3').on('input', function() {
											var busqueda3 = $(this).val().toLowerCase();
											if (busqueda3.trim() !== '') {
												$('#selector3').show(); // Muestra el selector si hay una b�squeda
											} else {
												$('#selector3').hide(); // Oculta el selector si no hay b�squeda
											}
											$('#selector3 option').each(function() {
												var producto2 = $(this).text().toLowerCase();
												if (producto2.includes(busqueda3)) {
													$(this).show();
												} else {
													$(this).hide();
												}
											});
										});
									});
								</script>



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
							<button type='button' class='btn btn-color' id='btnGuardarSolicitud' name='btnGuardarSolicitud' value='Guardar'><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
						</div>
						</form>
					</div>
				</div>
			</div>
			<!--este script realiza la accion de mostrar la ventana modal para registrar los datos del prestamo-->
			<script>
				$(document).ready(function() {
					$("#Rprestamo").click(function() {
						frmPrestamo.reset();
						//se muestra la ventana modal del formulario
						$('#modalPrestamo').modal();
						//se blanquea el div de errores del formulario
						$("#div_col_val_errors").html("");
					});
				});
			</script>

			<script>
				function fillAreas(edificio, areaType) {
					var areas = {
						"B": {
							"AULA": ["2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16"]

						},
						"D": {
							"AULA": ["42", "43", "44", "45", "46", "47"],
							"Cubiculos": ["0"]
						},
						"E": {
							"AULA": ["25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41"]
							
						},
						"F": {
							"AULA": ["17"],
							"LABORATORIO": ["Sala Didactica", "Dibujo", "Lab. Aplicaciones", "Lab. Redes", "Eficiencia Energetica", "Posgrado 1", "Posgrado 2", "Posgrado 3"],
							"Sala CIC": ["1", "2", "3", "4"]
						},
						"Externo": {
							"I+D+I": ["Laboratorios"]
						}
						// Add more areas as needed
					};

					var areaSelect = document.getElementById("Id_Area");
					areaSelect.innerHTML = "";

					areas[edificio][areaType].forEach(function(area) {
						var option = document.createElement("option");
						option.value = area;
						option.text = area;
						areaSelect.appendChild(option);
					});

					// Update other fields
					document.getElementById("Edificio").value = edificio;
					document.getElementById("Tipo_Area").value = areaType;
				}

				function updateFields() {
					var edificio = document.getElementById("Edificio").value;
					var areaType = document.getElementById("Tipo_Area").value;
					var area = document.getElementById("Id_Area").value;

					// Update other fields
					document.getElementById("Edificio").value = edificio;
					document.getElementById("Tipo_Area").value = areaType;
				}

				// Initially fill the areas based on the selected type
				var initialEdificio = document.getElementById("Edificio").value;
				var initialType = document.getElementById("Tipo_Area").value;
				fillAreas(initialEdificio, initialType);
			</script>


				
	<!-- Ventana modal del formulario para editar el prestamo -->	
	<div class='modal fade' id='modalPrestamoEditar'>
					<div class='modal-dialog'>
						<div style='width: 480px;' class='modal-content'>
							<div style="background-color: #000053;" class='modal-header'>
								<!--<button style="background-color: #FFCD00;" type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>-->
									<h4 style="color: white;" class='modal-title'>Editar datos del préstamo</h4>
							</div>
							<div class='modal-body'>
<?php 
							echo form_open("Prestamo/Editar_Solicitud","id='frmEditarPrestamo' name='frmEditarPrestamo' role='form'"); 
								
									//Agregamos los campos de la llave primaria como campos de tipo hidden
									echo form_input(array("type"=>"hidden","name"=>"e_id_Solicitud","id"=>"e_id_Solicitud","value"=>""));
						
?>												
								<div class='row'>												
									<div class='col-md-12' id='div_col_val_errors' name='div_col_val_errors'>										
									</div>
								</div>

								<div class='row'>
									<div class='col-md-8'>
										Responsable de la entrega:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>									

										<input style="border: none; outline: none; !important; color:orange; font-size: 17px; font-weight: bold; margin-bottom: -25px;" type="text" name='Encargado1' value="<?php echo set_value('Encargado1', $session_data['full_name']); ?>" readonly />

										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-md-8'>
										Id. de solicitud:
									</div>
									<br>
									<div class='col-md-4'>
										<div class='form-group'>											
											<!-- Mostramos los valores de la llave primaria como textos no editables <p></p> -->
											<p style="color:orange; font-size: 17px; font-weight: bold;" id='p_e_id_solicitud' name='p_e_id_solicitud'></p>
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
											ComboBox("Nombre_Solicitante1","Nombre_Solicitante1","form-control","",1,false,1,$array_cliente,"","","","Nombre del solicitante");												
?>
										</div>
									</div>
								</div>

								<div style="width: auto; display: flex; flex-wrap: wrap; align-items: flex-start;">
									<div style="flex: 0 0 auto; margin-right: 10px;">
										<div>Edificio:</div>
										<div style="width: 100px; margin-top: 5px;" class='form-group'>
											<?php ComboBox("Edificio1","Edificio1","form-control","",1,false,1,array("A"=>"A","B"=>"B","C"=>"C","D"=>"D","F"=>"F","G"=>"G"),"","","","Elige un edificio"); ?>
										</div>
									</div>
									
									<div style="flex: 0 0 auto; margin-right: 10px;">
										<div>Tipo Área:</div>
										<div style="width: 100px; margin-top: 5px;" class='form-group'>
											<?php ComboBox("Tipo_Area1","Tipo_Area1","form-control","",1,false,1,array("AULA"=>"AULA","SALA CIC"=>"SALA CIC","EXTERNA"=>"EXTERNA","I+D+I"=>"I+D+I","LABORATORIO"=>"LABORATORIO","CUBICULO"=>"CUBICULO","COORDINACION"=>"COORDINACION","SITE"=>"SITE"),"","","","Elige el area"); ?>
										</div>
									</div>

									<div style="flex: 0 0 auto; margin-right: 10px;">
										<div>Id Área:</div>
										<div style="width: 100px; margin-top: 5px;" class='form-group'>
											<?php ComboBox("Id_Area1","Id_Area1","form-control","",1,false,1,array("1" => "1","2" => "2","3" => "3","4" => "4","5" => "5","6" => "6","7" => "7","8" => "8","9" => "9","10" => "10","11" => "11","12" => "12","13" => "13","14" => "14","15" => "15","16" => "16","17" => "17","18" => "18","19" => "19","20" => "20","21" => "21","22" => "22","23" => "23","24" => "24","25" => "25","26" => "26","27" => "27","28" => "28","29" => "29","30" => "30","31" => "31","32" => "32","33" => "33","34" => "34","35" => "35","36" => "36","37" => "37","38" => "38","39" => "39","40" => "40","41" => "41","42" => "42","43" => "43","44" => "44","45" => "45","46" => "46","47" => "47","48"=>"48"),"","","","id del area"); ?>
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
											DateEditBox("Fecha_solicitud1", "Fecha_solicitud1", "form-control", "", 1, 255, 255, false, "Fecha de solicitud", "");												
?>
										</div>
									</div>
								</div>



							</div>
							<div style="background-color: #000053;" class='modal-footer'>
								<button type='button' class='btn btn-close' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span>Cancelar</button>
								<button type='button'  class='btn btn-color' id='btnGuardar_Edicion_Solicitud' name='btnGuardar_Edicion_Solicitud' value='Guardar'><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				<script>
					$(document).ready(function () {
					$("#btnGuardar_Edicion_Solicitud").click(function(){

						$(this).prop("disabled", true).html("<span class='glyphicon glyphicon-floppy-disk'></span> Guardando....");

						$.ajax({
							type: "POST",
							url: "<?php echo base_url();?>index.php/Prestamo/Editar_Solicitud",
							data: $('#frmEditarPrestamo').serialize(),
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
									$("#modalPrestamoEditar").modal('hide');																				
									$('#tbPrestamo').DataTable().ajax.reload(null, false);
									$("#div_col_e_val_errors").html("");
								}else{
									$("#div_col_e_val_errors").html(msg_val_errors);
								}			
								$("#btnGuardar_Edicion_Solicitud").prop("disabled", false).html("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar");	
							},
							error: function(){
								alert("Ocurrió un error al procesar la petición servidor.");
								$("#btnGuardar_Edicion_Solicitud").prop("disabled", false).html("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar");
							}
						});
					});
					
					
				});

				</script>
				
				<!-- Ventana modal  para visualizar la informacion de la informaci�n -->	

				<div class='modal fade' id='modalVisualizarPrestamo'>
					<div class='modal-dialog'>
						<div style='width: 480px;' class='modal-content'>
							<div style="background-color: #000053;" class='modal-header'>
								<!--<button style="background-color: #FFCD00;" type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>-->
									<h4 style="color: white;" class='modal-title'>Visualizar información del préstamo</h4>
							</div>
							<div class='modal-body'>
											
								<div class='row'>												
									<div class='col-md-12' id='div_col_e_val_errors' name='div_col_e_val_errors'>										
									</div>
								</div>

								<div class='row'>
									<div class='col-md-5'>
										Numero de Solicitud:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>											
											<p style="color:orange; font-size: 17px; font-weight: bold;" id='p_v_id_Solicitud' name='p_v_id_Solicitud'></p>
										</div>
									</div>
								</div>
								<div class='row'>
									<div class='col-md-8'>
										Responsable de la entrega:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>
											<p style="color:orange; font-size: 17px; font-weight: bold;" id='p_v_encargado' name='p_v_encargado'></p>										
										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-md-5'>
										Nombre del solicitante:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>
											<p style="color:orange; font-size: 17px; font-weight: bold;" id='p_v_Solicitante' name='p_v_Solicitante'></p>										
										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-md-5'>
										Edificio:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>
											<p style="color:orange; font-size: 17px; font-weight: bold;" id='p_v_Edificio' name='p_v_Edificio'></p>										
										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-md-5'>
										Tipo de Área:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>
											<p style="color:orange; font-size: 17px; font-weight: bold;" id='p_v_Tipoarea' name='p_v_Tipoarea'></p>										
										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-md-5'>
										Numero de Área:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>
											<p style="color:orange; font-size: 17px; font-weight: bold;" id='p_v_N_area' name='p_v_N_area'></p>										
										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-md-5'>
										Fecha de la solicitud:
									</div>
									<div class='col-md-8'>
										<div class='form-group'>
											<p style="color:orange; font-size: 17px; font-weight: bold;" id='p_v_fecha' name='p_v_fecha'></p>										
										</div>
									</div>
								</div>



							</div>
							<div style="background-color: #000053;" class='modal-footer'>
								<button type='button' class='btn btn-close' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span>Cancelar</button>
							</div>
							</form>
						</div>
					</div>
				</div>

				
				
				<!-- Tabla din?mica para mostrar los registros del cat?logo -->	
				<table id='tbPrestamo' name='tbPrestamo' class='display cell-border order-column dt-responsive'>
					<thead>
						<tr>							
							<th style='width: 50px;'>Numero de Solicitud</th>		
							<th>Profesor
							<th>Edificio
							<th>Tipo de área
							<th>Número de área
							<th>Encargado del préstamo
							<th>Fecha de préstamo				
					</thead>
					<tfoot>
						<tr>																										
							<th>						
							<th>
							   					
					</tfoot>					
					<tbody>															
					</tbody>
				</table>


<script>
				var tbPrestamo;
				$(document).ready( function () {
					$.fn.dataTable.ext.errMode = 'throw';
					tbPrestamo = $('#tbPrestamo').DataTable(
						{																									
							dom : 'Blfiprtip',																																																	
							language: {
								processing:     "Procesando...",
								search:         "Buscar:",
								lengthMenu:     "Mostrar _MENU_ registro(s) a la vez</div>",
								info:           "Mostrando _START_ a _END_ de _TOTAL_ registro(s)",
								infoEmpty:      "Mostrando 0 a 0 de 0 registros",
								infoFiltered:   "(Filtrados de _MAX_ registros en total)",
								infoPostFix:    "",
								loadingRecords: "Cargando...",
								zeroRecords:    "No hay registros para mostrar",
								emptyTable:     "No hay datos disponibles en la tabla",
								paginate: {
									first:      "Primero",
									previous:   "Anterior",
									next:       "Siguiente",
									last:       "Ultimo"
								},
								aria: {
									sortAscending:  ": Ordenar ascendentemente",
									sortDescending: ": Ordenar descendentemente"
								},
								select: {
									rows: {
										_: " - %d registros seleccionados",
										0: "",
										1: " - 1 registro seleccionado"
									}
								}
							},											
							"pageLength": 10,
							"lengthMenu": [ 5,10, 25, 50, 100, 250, 500, 1000, 5000, 10000],
							responsive: true,
							select: {
								style: 'os'
							},
							buttons: [
							
								{
									extend: 'copyHtml5',
									text: '<span class="glyphicon glyphicon-indent-left"></span> Copiar registros',
								},								
								{
									extend: 'excelHtml5',
									text: '<span class="glyphicon glyphicon-export"></span> Exportar a Excel'
								},
								

							],																		
							columnDefs: [
								{ responsivePriority: 1, targets: 0 },
								{ responsivePriority: 1, targets: 1 }								
							],											
							ajax: '<?php echo base_url();?>index.php/Prestamo/Obtener_Dataset_Prestamo',
							autoWidth: false,							
							columns: [								
								{ data: "id_solicitud" },
								{ data: "profesor" },
								{ data: "Edificio" },
								{ data: "Tipo_Area" },
								{ data: "Num_Area" },
								{ data: "encargado_prest" },
								{ data: "fecha_prest" }
							],
							"footerCallback": function ( row, data, start, end, display ) {
								var api = this.api(), data;
					 
								// Remove the formatting to get only the number data
								var numericVal = function ( i ) {
									return typeof i === 'string' ?
										i.replace(/[\$,]/g, '')*1 :
										typeof i === 'number' ?
											i : 0;
								};
								/*
								// Total over all pages
								total = api
									.column( 1 )
									.data()
									.reduce( function (a, b) {
										return numericVal(a) + numericVal(b);
									}, 0 );
					 
								// Total over this page
								pageTotal = api
									.column( 1, { page: 'current'} )
									.data()
									.reduce( function (a, b) {
										return numericVal(a) + numericVal(b);
									}, 0 );
					 
								// Update footer data
								$( api.column( 1 ).footer() ).html(
									pageTotal +' (de '+ total +')'
								);
								*/
							}

							
						} 
					);																							
					
					// Apply the search
					$('#tbPrestamo').DataTable().columns().every( function () {
						var that = this;
				 
						$( 'input', this.header() ).on( 'keyup change', function () {				
							if ( that.search() !== this.value ) {
								that
									.search( this.value )
									.draw();
							}
						} );
					} );
					
				} );	
								
</script>
			
			</div>	
		</div>	
	
	</div>
	
	
<?php
	require "owned/set_security_controller.php";
	require "owned/notification_messages_controller.php";
?>
</body>
</html>