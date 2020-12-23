<?php
include "vista.php";
include "modelo.php";

function checkDato( $valor )
{	
	if( strlen( $valor ) < 5 ) 
		$resultado = 0;
	else 
		$resultado = 1;
	return $resultado;
}

function checkCategoria( $categoria )
{
	if(Categoria::getByCodigo($categoria))
		$resultado = 1;
	else
		$resultado = 0;
	return $resultado;
}

function checkEntidad( $entidad )
{
	if(Entidad::getByCodigo($entidad))
		$resultado = 1;
	else
		$resultado = 0;
	return $resultado;
}

function validateField( $fieldName, $missingFields ) 
{
	if ( in_array( $fieldName, $missingFields ) ) 
	{
		echo 'class="error"';
	}
}

function processForm( $campos ) 
{
	foreach ( $campos as $campo ) 
	{
		//echo $campo[ 'nombre' ] . $campo[ 'funcion' ];
		if ( !isset( $_POST[$campo[ 'nombre' ] ] ) or !$_POST[$campo[ 'nombre' ] ] ) 
		{
			$missingFields[] = $campo[ 'nombre' ];
		}
		elseif( ! call_user_func( $campo[ 'funcion' ],  $_POST[$campo[ 'nombre' ] ] ) )
		{
			$missingFields[] = $campo[ 'nombre' ];
		}
	}
	if( isset ( $missingFields ) )
		return( $missingFields );
	else
		return null;
}


function salir()
{
	session_destroy();

}

function entrar()
{
	$_SESSION['logueado'] = true;

}

//main
session_start();


if( isset($_SESSION['logueado'])  && $_SESSION['logueado'] == true )
{
	if( isset( $_GET["opcion"]  ) &&  $_GET["opcion"] == "salir")
	{
		salir();
		displayEntrada( array() );
	}
	elseif( isset($_POST["opcion"]) && $_POST["opcion"] == "evento")
	{
		$campos = array(
			array('nombre' => 'nombre_evento', 'funcion' => 'checkDato'),
			array('nombre' => 'categorias', 'funcion' => 'checkCategoria'),
			array('nombre' => 'entidades', 'funcion' => 'checkEntidad'),
			array('nombre' => 'ubicacion', 'funcion' => 'checkDato'));
		$missingFields = processForm( $campos );

		if( $missingFields )
		{
			$categorias = Categoria::getAll();
			$entidades = Entidad::getAll();
			$eventos = Evento::getAll();
			displayPrivada(array(), $categorias, $entidades, $eventos);
		}
		else
		{
			$evento = new Evento();

			$evento->evento = $_POST['nombre_evento'];
			$evento->categoria_id = $_POST['categorias'];
			$evento->entidad_id = $_POST['entidades'];
			$evento->ubicacion = $_POST['ubicacion'];
			$evento->fecha = $_POST['fecha'];
			$evento->hora = $_POST['hora'];

			$evento->save();

			displayEvento();
		}		
	}
	else
	{
		$entidades = Entidad::getAll();
		$categorias = Categoria::getAll();
		$eventos = Evento::getAll();
		displayPrivada( array(), $categorias, $entidades, $eventos );
	}
}
elseif( ! isset( $_POST["submit"] ) ) 
{
	displayEntrada( array() );
	
}

elseif( isset( $_POST["opcion"]  ) &&  $_POST["opcion"] == "entrada" ) 
{
	// campo_requerido funcion_validacion
	$campos = array( 
				array( 'nombre' => 'usuario', 'funcion' => 'checkDato' ), 
				array( 'nombre' => 'password', 'funcion' => 'checkDato' ) );
	$missingFields = processForm( $campos );

	if ( $missingFields ) 
	{
		displayEntrada( $missingFields );		
	} 
	else
	{
		if( Usuario::checkUsuario( $_POST["usuario"], $_POST["password"] ))
		{	
			entrar();
			$_SESSION['usuario'] = Usuario::getByCodigo($_POST["usuario"]);
			$categorias = Categoria::getAll();
			$entidades = Entidad::getAll();
			$eventos = Evento::getAll();
			displayPrivada(array(), $categorias, $entidades, $eventos);
		}
		else
		{
			displayError();
		}	
			
	}

}