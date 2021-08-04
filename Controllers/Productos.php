<?php
	class Productos extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(3);
		}

		public function Productos()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Productos y Servicios";
			$data['page_title'] = "PRODUCTOS Y SERVICIOS <small>Quotaware</small>";
			$data['page_name'] = "productos";
			$data['page_functions_js'] = "functions_productos.js";
			$this->views->getView($this,"productos",$data);
		}

        public function getProductos()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectProductos();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					/*if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}*/

                    $arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']); // para poner el simbolo de moneda $

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver producto"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idproducto'].')" title="Editar producto"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        public function setProducto(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['txtPrecio']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					
					$idProducto = intval($_POST['idProducto']);
					$strNombre =  strClean($_POST['txtNombre']);
					$strDescipcion = strClean($_POST['txtDescripcion']);
                    $strCodigo = strClean($_POST['txtCodigo']);
                    $strPrecio = strClean($_POST['txtPrecio']);
					//$intStatus = intval($_POST['listStatus']);
                    
                    if($idProducto == 0)
                    {
                        $option = 1;
                        $request_producto = $this->model->insertProducto($strNombre,
                                                                     $strDescipcion,
                                                                     $strCodigo,
                                                                     $strPrecio);
                    }else{
                        $option = 2;
                    }

                    if($request_producto > 0)
                    {
                        if($option == 1){
                            $arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
                        }else{

                        }
                    }else if($request_producto == 'exist'){
                        $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');
                    }else{
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

    }

?>