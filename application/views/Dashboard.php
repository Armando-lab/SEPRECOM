<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	
	<title>Dashboard</title>

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
					<li class='active' style='color: white;'>Dashboard</li>											
				</ol>
			</div>		
			
		</div>	
	
        <div class="row">
					
					<div style="text-align: center; cursor: pointer;" class="col-md-3" id="Rprestamo" >			
						<a style="text-decoration: none;background-color:#327ab4;" href='<?php echo base_url();?>index.php/devolucion' class="thumbnail">
							<h3 style="color:#FFFFFF">Préstamos activos</h3>	
							<img style="width: 100px;" src="<?php echo base_url(); ?>application/views/imagenes/activo.png" alt="...">
                            <h1 class="card-text" style="text-align: center; margin: 10px; color: #FFFFFF; --darkreader-inline-color: #bbb3a7;"><?php echo $prestamosActivos; ?></h1>		  
							<p style="text-align: center; margin: 10px; color: #FFFFFF; " data-darkreader-inline-color="">ver más detalles <span class='glyphicon glyphicon-arrow-right'></span></p>
						</a>			  				  
						<div class="w-100"></div>
						<div class="row">							
						</div>
					</div>


												
					<div style="text-align: center; cursor: pointer;" class="col-md-3" id="Verprestamo">			
						<a style="text-decoration: none;background-color:#d75250;" data-toggle="modal" data-target="#modalPrestamosVencidos" id="modalPrestamos"  class="thumbnail">
							<h3 style="color:#FFFFFF">Préstamos con atraso!</h3>	
							<img style="width: 100px;" src="<?php echo base_url(); ?>application/views/imagenes/atraso.png" alt="...">
                            <h1 class="card-text" style="text-align: center; margin: 10px; color: #FFFFFF; --darkreader-inline-color: #bbb3a7;"><?php echo $prestamosVencidos; ?></h1>
                            <p style="text-align: center; margin: 10px; color: #FFFFFF; ">ver más detalles <span class='glyphicon glyphicon-arrow-right'></span></p>		  
						</a>
						<div class="w-100"></div>
						<div class="row">							
						</div>			  				  
					</div>

					<div style="text-align: center; cursor: pointer;" class="col-md-3" id="Vperfil">			
						<a style="text-decoration: none;background-color:#5fb760;" href='<?php echo base_url();?>index.php/devolucion' class="thumbnail">
							<h3 style="color:#FFFFFF">Artículo más prestado</h3>
							<img style="width: 100px;" src="<?php echo base_url(); ?>application/views/imagenes/popular.png" alt="...">
                            <h1 class="card-text" style="text-align: center; margin: 10px; color: #FFFFFF; --darkreader-inline-color: #bbb3a7;"><?php echo $articuloMasPrestado; ?></h1>			  
							<p style="text-align: center; margin: 10px; color: #FFFFFF; ">ver más detalles <span class='glyphicon glyphicon-arrow-right'></span></p>		  
						</a>
						<div class="w-100"></div>
						<div class="row">							
						</div>			  				  
					</div>	
                    
                    <div style="text-align: center; cursor: pointer;" class="col-md-3" id="Vperfil">			
						<a style="text-decoration: none;background-color:#ecac54;" href='<?php echo base_url();?>index.php/devolucion' class="thumbnail">
							<h3 style="color:#FFFFFF">Total de préstamos</h3>
							<img style="width: 100px;" src="<?php echo base_url(); ?>application/views/imagenes/total.png" alt="...">
                            <h1 class="card-text" style="text-align: center; margin: 10px; color: #FFFFFF; --darkreader-inline-color: #bbb3a7;"><?php echo $totalPrestamos; ?></h1>	  
							<p style="text-align: center; margin: 10px; color: #FFFFFF; ">ver más detalles <span class='glyphicon glyphicon-arrow-right'></span></p>
						</a>
						<div class="w-100"></div>
						<div class="row">							
						</div>			  				  
					</div>	
		</div>


        <canvas id="grafica"></canvas>



        <!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Tu propio script para generar la gr�fica de barras -->
<script>
    $(document).ready(function(){
        // Datos de ejemplo (puedes obtener estos datos desde tu backend)
        var datos = {
            labels: ["Préstamos activos", "Préstamos vencidos", "Artáculo más prestado", "Total de prstamos"],
            datasets: [{
                label: 'Cantidad',
                data: [<?php echo $prestamosActivos; ?>, <?php echo $prestamosVencidos; ?>, <?php echo $articuloMasPrestado; ?>, <?php echo $totalPrestamos; ?>],
                backgroundColor: [
                    '#327ab4',
                    '#d75250',
                    '#5fb760',
                    '#ecac54'
                ],
                borderColor: [
                    '#327ab4',
                    '#d75250',
                    '#5fb760',
                    '#ecac54'
                ],
                borderWidth: 1
            }]
        };

        // Configuraci�n de la gr�fica
        var config = {
            type: 'bar',
            data: datos,
            options: {
                options: {
                    // Tama�o del canvas
                    responsive: true, // Permite que el canvas se ajuste al contenedor
                    maintainAspectRatio: false, // Evita que la relaci�n de aspecto sea constante
                    width: 50, // Ancho del canvas en p�xeles
                    height: 50, // Alto del canvas en p�xeles
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                        }
                }
            }
        };

        // Crear la instancia de la gr�fica en el elemento canvas con el id 'grafica'
        var ctx = document.getElementById('grafica').getContext('2d');
        new Chart(ctx, config);
    });
</script>




    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




</div>
	
<?php
	require "owned/set_security_controller.php";
	require "owned/notification_messages_controller.php";
?>	
</body>
</html>