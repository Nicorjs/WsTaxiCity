<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de empleados</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">

	<style>
		.content {
			margin-top: 80px;
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos</h2>
			<hr />

			<?php
			//if(isset($_GET['aksi']) == 'delete'){
			//	// escaping, additionally removing everything that could be (html/javascript-) code
			//	$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			//	$cek = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$nik'");
			//	if(mysqli_num_rows($cek) == 0){
			//		echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
			//	}else{
			//		$delete = mysqli_query($con, "DELETE FROM empleados WHERE codigo='$nik'");
			//		if($delete){
			//			echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
			//		}else{
			//			echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
			//		}
			//	}
			//}
			?>
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <th>Transacción</th>
					<th>Rut</th>
                    <th>Monto de Carga</th>
                    <th>Fecha de Carga</th>
					<!--<th>Saldo Real</th>-->
                    <th></th>
				</tr>
				<?php
					$sql = mysqli_query($con, "SELECT * FROM carga ORDER BY fecha_carga DESC");
					if(mysqli_num_rows($sql) == 0){
						echo '<tr><td colspan="8">No hay datos.</td></tr>';
					}else{
						$no = 1;
						while($row = mysqli_fetch_assoc($sql)){
							echo '
							<tr>
								<td>'.$row['transaccion'].'</td>
								<td></span>'.$row['id_conductor'].'</td>
								<td>'.$row['saldo_contable'].'</td>
								<td>'.$row['fecha_carga'].'</td>
								<!--<td>'.$row['saldo_real'].'</td>-->
								<td>';
							echo '
								</td>
							</tr>
							';
							$no++;
						}
					}
				?>
			</table>
			</div>
		</div>
	</div><center>
	<p>&copy; Taxicity <?php;?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
