<?php

class Entidad
{
    private $codigo;     // user id
    private $fields;  // other record fields

    // initialize a User object
    public function __construct()
    {
        $this->codigo = null;
        $this->fields = array('ENTIDAD' => '');
    }

    // override magic method to retrieve properties
    public function __get($field)
    {
        if ($field == 'ENTIDAD_ID')
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
        $u = new Entidad();
		
		$conexion = new Database();
		$sql =  "SELECT * FROM agenda_entidades where ENTIDAD_ID = ?";
		$query = $conexion->prepare( $sql );
		$query->bindParam( 1, $codigo );
		$query->execute();
		
		if( $row = $query->fetch() )
		{
			$u = new Entidad();
			$u->servicio = $row['ENTIDAD'];
            $u->codigo = $codigo;
			return $u;
		}	
		else
		{
			return null;
		}
	}
	
	// return an object populated based on the record's user id
    public static function getAll()
    {
        $v = array();
		$conexion = new Database();
        $sql = 'SELECT * FROM agenda_entidades order by ENTIDAD';
        $rows = $conexion->query( $sql );		

        foreach( $rows as $row )
		{
			$u = new Entidad();
			$u->codigo = $row['ENTIDAD_ID'];
         	$v[$row['ENTIDAD_ID'] ] = $row['ENTIDAD'];
		}
        return $v;
    }
}

?>