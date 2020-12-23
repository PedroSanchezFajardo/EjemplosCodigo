<?php
function head()
{
?>	

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<style type="text/css">
.error { background: #d33; color: white; padding: 0.2em; }
</style>
</head>
<body>
<?php
}

function foot()
{
?>	
</body>
</html>
<?php
}


function displayEntrada( $missingFields )
{
	
	head();
	?>
	<H1>Introduce Identificación</H1>
	<FORM METHOD=POST ACTION="controlador.php">
	<INPUT TYPE="hidden" name="opcion" value="entrada">
	<br>
	<label for="usuario">Usuario</label>
	<INPUT TYPE="text" <?php validateField( "usuario", $missingFields );?> NAME="usuario">
	<br>
	<label for="password" >Password</label>
	<INPUT TYPE="password" <?php validateField( "password", $missingFields );?> NAME="password">
	<br>
	<input type="submit" name="submit" id="submitButton" value="Enviar">
	<input type="reset" name="reset" id="resetButton" value="Borrar">
	</FORM>
	<?php
	foot();
}

function displayPrivada($missingFields, $categorias, $entidades, $eventos)
{
		
	head();
	?>
    <h1>Agenda usuario</h1>
    <form method=POST action="controlador.php">
    <input type="hidden" name="opcion" value="evento">
    <br>
    <label for="nombre_evento">Nombre evento</label>
    <input type="text" <?php validateField("nombre_evento", $missingFields);?> name="nombre_evento">
    <br>
	<label for="ubicacion" >Ubicacion</label>
    <input type="text" <?php validateField("ubicacion", $missingFields);?> name="ubicacion">
    <br>
	<SELECT NAME="categorias" > 
	<?php
	foreach( $categorias as $key => $value )
	{
		printf( '<OPTION VALUE="%s">%s</OPTION>',$key, $value ); 
	}
	?>
	</SELECT>
	<br>
	<SELECT NAME="entidades" > 
	<?php
	foreach( $entidades as $key => $value )
	{
		printf( '<OPTION VALUE="%s">%s</OPTION>',$key, $value ); 
	}
	?>
	</SELECT>
	<br>
    <label for="fecha">Fecha</label>
    <input type="date" name="fecha">
    <br>
    <label for="hora">Hora</label>
    <input type="time" name="hora">
    <br>
    <input type="submit" name="submit" id="submitButton" value="Enviar">
    <input type="reset" name="reset" id="resetButton"	value="Borrar">
	</FORM>
	<br>
	<h2>Eventos<hr></h2>
	<?php
	foreach( $eventos as $evento )
	{
		print "{$evento['evento']} <br> {$evento['ubicacion']} <br> {$evento['fecha']} <br> {$evento['hora']} <br> <hr>";
	}

	?>
    <?php
	printf( "<a href='controlador.php?opcion=salir'>Salir</a>");
	foot();
}

function displayEvento()
{
	head();
	printf("El evento se ha registado correctamente<br>");
	printf("<a href='controlador.php?opcion=entrada'>Continuar</a><br>");
	printf("<a href='controlador.php?opcion=salir'>Salir</a>");
	foot();
}

function displayError()
{
		
	head();
	printf( "<a href='controlador.php'>Se ha producido un error</a>");
	foot();
}
?>