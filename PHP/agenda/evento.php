<?php

class Evento
{
    private $codigo;     // user id
    private $fields;  // other record fields

    // initialize a User object
    public function __construct()
    {
        $this->codigo = null;
        $this->fields = array(  'evento' => '',
								'entidad_id' => '',
								'categoria_id' => '',
                                'ubicacion' => '',
                                'fecha' => '',
                                'hora' => '');
    }

    // override magic method to retrieve properties
    public function &__get($field)
    {
        if ($field == 'codigo')
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
    
    // return an object populated based on the record's user id
    public static function getByCodigo($codigo)
    {
        $u = new Usuario();

		$conexion = new Database();
		$sql = sprintf( "SELECT * FROM agenda_eventos where codigo = %d", $codigo );
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
	
	// return an object populated based on the record's user id
    public static function getAll()
    {
        $v = array();
		$conexion = new Database();
        $sql = 'SELECT * FROM agenda_eventos';
        $rows = $conexion->query( $sql );
		
        foreach( $rows as $row )
		{
			$u = new Evento();
			$u->evento = $row['EVENTO'];
            $u->ubicacion = $row['UBICACION'];
            $u->fecha = $row['FECHA'];
            $u->hora = $row['HORA'];
			$v[] = array('evento' => $u->evento, 'ubicacion' => $u->ubicacion, 'fecha' => $u->fecha, 'hora' => $u->hora);
		}

        return $v;
    }
	
	
    
    // save the record to the database
    public function save()
    {
		$conexion = new Database();
		
        if ($this->codigo)
        {
            $sql = 'UPDATE AGENDA_EVENTOS SET EVENTO = ? ENTIDAD_ID = ? CATEGORIA_ID = ? UBICACION = ? FECHA = ? HORA = ? WHERE EVENTO_ID = ?';
            $query = $conexion->prepare( $sql );
			$query->bindParam( 1, $this->evento );
			$query->bindParam( 2, $this->entidad_id );
			$query->bindParam( 3, $this->categoria_id );
			$query->bindParam( 4, $this->ubicacion );
            $query->bindParam( 5, $this->fecha );
            $query->bindParam( 6, $this->hora );
			$query->bindParam( 7, $this->codigo );
			
			$query->execute( );
        }
        else
        {
			
			$sql = 'INSERT INTO AGENDA_EVENTOS (EVENTO, ENTIDAD_ID, CATEGORIA_ID, UBICACION, FECHA, HORA ) VALUES ( ?,?,?,?,?,?)';
            
			$query = $conexion->prepare( $sql );
			$query->bindParam( 1, $this->evento );
			$query->bindParam( 2, $this->entidad_id );
			$query->bindParam( 3, $this->categoria_id );
			$query->bindParam( 4, $this->ubicacion );
            $query->bindParam( 5, $this->fecha );
            $query->bindParam( 6, $this->hora );
			
			$query->execute( );
        }
    }
	
	// save the record to the database
    public function delete()
    {
        $conexion = new Database();
		
		if ($this->codigo)
        {
            $sql = sprintf('DELETE FROM agenda_eventos WHERE codigo = %d',
                     $this->codigo);
            $conexion->exec( $sql );
        }
    }

}


?>