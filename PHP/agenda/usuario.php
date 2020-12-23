<?php

class Usuario
{
    private $codigo;     // user id
    private $fields;  // other record fields

    // initialize a User object
    public function __construct()
    {
        $this->codigo = null;
        $this->fields = array('USUARIO' => '',
                              'PASSWORD' => '');
    }

    // override magic method to retrieve properties
    public function __get($field)
    {
        if ($field == 'USUARIO_ID')
        {
            return $this->codigo;
        }
        else 
        {
            return $this->fields[$field];
        }
    }

    // override magic method to set properties
    public function __set($field, $value)
    {
        if (array_key_exists($field, $this->fields))
        {
            $this->fields[$field] = $value;
        }
    }

    // return if usuario is valid format
    public static function validateUsuario($usuario)
    {
        return preg_match('/^[A-Z0-9]{2,20}$/i', $usuario);
    }
    
    
    
    // return an object populated based on the record's user id
    public static function getByCodigo($codigo)
    {
        $u = new Usuario();

		$conexion = new Database();
		$sql = sprintf( "SELECT * FROM agenda_usuarios where USUARIO_ID = %d", $codigo );
		$rows = $conexion->query( $sql );
		
		if( $rows->rowCount()  == 0  )
			return null;
		else
		{
			$u = new Usuario();
			$row = $rows->fetch();
			$u->usuario = $row['USUARIO'];
            $u->password = $row['PASSWORD'];
            $u->codigo = $codigo;
			return $u;
		}
	}
	
	public static function checkUsuario( $usuario, $password )
    {
       
		$conexion = new Database();
		$sql = sprintf( "SELECT * FROM agenda_usuarios where USUARIO = '%s'", $usuario );
		$rows = $conexion->query( $sql );
		
		
		if( $rows->rowCount()  == 0  )
			$resultado = false;
		else
		{
			$row = $rows->fetch();
			if( $row['PASSWORD'] == $password )
				$resultado = true;
			
            else
				$resultado = false;
			
		}
		
		return $resultado;
		
	}
	
	// return an object populated based on the record's user id
    public static function getAll()
    {
        $v = array();
		$conexion = new Database();
        $sql = sprintf('SELECT * FROM agenda_usuarios' );
        $rows = $conexion->query( $sql );
		

        foreach( $rows as $row )
		{
			$u = new Usuario();
			$u->usuario = $row['USUARIO'];
            $u->password = $row['PASSWORD'];
            $u->codigo = $row['USUARIO_ID'];
			$v[] = $u;
		}

        return $v;
    }	
    
    // save the record to the database
    public function save()
    {
		$conexion = new Database();
		
        if ($this->codigo)
        {
            $query = sprintf('UPDATE agenda_usuarios SET USUARIO = "%s" password = "%s" WHERE USUARIO_ID = %d',
                $this->usuario,
                $this->password,
                $this->codigo);
            $rows = $conexion->exec( $query );
        }
        else
        {
            $query = sprintf('INSERT INTO agenda_usuarios ( USUARIO, PASSWORD) VALUES ("%s", "%s")',
                $this->usuario,
                $this->password );
			$rows = $conexion->exec( $query );

            $this->codigo = $conexion->lastInsertId();
        }
    }
	
	// save the record to the database
    public function delete()
    {
        $conexion = new Database();
		
		if ($this->codigo)
        {
            $sql = sprintf('DELETE FROM agenda_usuarios WHERE USUARIO_ID = %d',
                     $this->codigo);
            $conexion->exec( $sql );
        }
    }

}

?>