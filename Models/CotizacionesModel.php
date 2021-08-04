<?php 

	class CotizacionesModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}
        
        public function selectCotizaciones(){
            $sql = "SELECT p.idpedido,
                           DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
                           p.monto,
                           p.nota,
                           ed.estadotipo,
                           ed.estadoid
                    FROM pedido p
                    INNER JOIN estadocotizacion ed
                    ON p.estadoid = ed.estadoid";
            $request = $this->select_all($sql); // extraer datos de la base
            return $request; // retorna al controlador        
        }

        public function selectCotizacion(int $idpedido, $idpersona = NULL){
            // verificar para solo traer los datos de 1 usuario 1 cotizacion
            $busqueda = "";
            if($idpersona != NULL){
                $busqueda = " AND p.personaid =".$idpersona;
            }
            $request = array();
            $sql = "SELECT p.idpedido,
                            DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
                            p.monto,
                            p.nota,
                            ed.estadotipo,
                            ed.estadoid,
                            p.idpersona
                    FROM pedido p
                    INNER JOIN estadocotizacion ed
                    ON p.estadoid = ed.estadoid
                    WHERE p.idpedido = $idpedido".$busqueda;
            $requestCotizacion = $this->select($sql); // extraer datos de la base
            if(!empty($requestCotizacion)){
                $idpersona = $requestCotizacion['idpersona'];
                $sql_cliente = "SELECT idpersona,
                                        nombres,
                                        apellidos,
                                        telefono,
                                        direccion,
                                        email_user,
                                        nit,
                                        nombrefiscal,
                                        direccionfiscal
                                FROM persona
                                WHERE idpersona = $idpersona ";
                $requestcliente = $this->select($sql_cliente); // extraer datos del cliente de la base

                $sql_detalle = "SELECT p.idproducto,
                                        p.nombre as producto,
                                        d.precio,
                                        d.cantidad
                                FROM detalle_pedido d
                                INNER JOIN producto p
                                ON d.productoid = p.idproducto
                                WHERE d.pedidoid = $idpedido ";
                 $requestProductos = $this->select_all($sql_detalle); // extraer datos del detalle de la base
                 
                 // creacion de un array con los datos de cada uno
                 $request = array('cliente' => $requestcliente,
                                  'orden' => $requestCotizacion,
                                  'detalle' => $requestProductos );
            }
            return $request;        

        }
        // actualizar el atributo de estadoid
        public function updateCotizacion(int $idpedido, string $estado){
            $query_insert = "UPDATE pedido SET estadoid = ? WHERE idpedido = $idpedido";
            $arrData = array($estado);

        
        $request_insert = $this->update($query_insert, $arrData);
        return $request_insert;
        }



        
	}
 ?>