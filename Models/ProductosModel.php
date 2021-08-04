<?php 

	class ProductosModel extends Mysql
	{
        private $intIdProducto;
        private $strNombre;
        private $strDescripcion;
        private $intCodigo;
        private $intPrecio;

		public function __construct()
		{
			parent::__construct();
		}
        
        public function selectProductos(){
            $sql = "SELECT idproducto,
                            codigo,
                            nombre,
                            descripcion,
                            precio
                    FROM producto ";
                    $request = $this->select_all($sql);
            return $request;
        }

        public function insertProducto(string $nombre, string $descripcion, int $codigo, string $precio){
            $this->strNombre = $nombre;
            $this->strDescripcion = $descripcion;
            $this->intCodigo = $codigo;
            $this->strPrecio = $precio;
            $return = 0;
            $sql = "SELECT * FROM producto WHERE codigo = $this->intCodigo";
            $request = $this->select_all($sql);
            if(empty($request))
            {
                $query_insert = "INSERT INTO producto (codigo,
                                                       nombre,
                                                       descripcion,
                                                       precio)
                                VALUES(?,?,?,?)";
                $arrData = array($this->intCodigo,
                                $this->strNombre,
                                $this->strDescripcion,
                                $this->strPrecio);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;                                
            }else{
                $return = "exist";
            }
            return $return;



        }
	}
 ?>