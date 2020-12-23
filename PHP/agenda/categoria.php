<?php

class Categoria
{
    private $codigo;     // user id
    private $fields;  // other record fields

    // initialize a User object
    public function __construct()
    {
        $this->codigo = null;
        $this->fields = array('CATEGORIA' => '');
    }

    // override magic method to retrieve properties
    public function __get($field)
    {
        if ($field == 'CATEGORIA_ID')
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
        $u = new Categoria();
		
		$conexion = new Database();
		$sql =  "SELECT * FROM agenda_categorias where CATEGORIA_ID = ?";
		$query = $conexion->prepare( $sql );
		$query->bindParam( 1, $codigo );
		$query->execute();
		
		if( $row = $query->fetch() )
		{
			$u = new Categoria();
			$u->servicio = $row['CATEGORIA'];
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
        $sql = 'SELECT * FROM agenda_categorias order by CATEGORIA';
        $rows = $conexion->query( $sql );		

        foreach( $rows as $row )
		{
			$u = new Categoria();
			$u->codigo = $row['CATEGORIA_ID'];
         	$v[$row['CATEGORIA_ID'] ] = $row['CATEGORIA'];
		}
        return $v;
    }
}

?>