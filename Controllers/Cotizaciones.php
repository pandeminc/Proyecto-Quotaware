<?php

class Cotizaciones extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(2);// segun tabla módulo
		}

		public function Cotizaciones()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Cotizaciones";
			$data['page_title'] = "COTIZACIONES <small>Quotaware</small>";
			$data['page_name'] = "cotizaciones";
			$data['page_functions_js'] = "functions_cotizaciones.js";
			$this->views->getView($this,"cotizaciones",$data);
		}

        public function getCotizaciones(){
            if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectCotizaciones();
                //dep($arrData);
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

                    $arrData[$i]['monto'] = SMONEY.formatMoney($arrData[$i]['monto']); // formato para el monto [$ monto]

					if($_SESSION['permisosMod']['r']){
                        $btnView .= ' <a title="Ver Detalle" href="'.base_url().'/cotizaciones/orden/'.$arrData[$i]['idpedido'].'" target="_blanck" class="btn btn-info btn-sm"> <i class="far fa-eye "></i></a></button>';
                        
						//$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver producto"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idpedido'].')" title="Editar cotización"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idpedido'].')" title="Eliminar cotización"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
        }

        public function orden(int $idpedido){
            if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
            $idpersona = "";
            if($_SESSION['userData']['idrol'] == RCLIENTES ){
				$idpersona = $_SESSION['userData']['idpersona'];
			}

            $data['page_tag'] = "Cotización - Quotaware";
			$data['page_title'] = "COTIZACIÓN <small>Quotaware</small>";
			$data['page_name'] = "cotizacion";
            $data['arrCotizacion'] = $this->model->selectCotizacion($idpedido,$idpersona);
			$this->views->getView($this,"orden",$data);
        }

        public function getCotizacion(string $pedido){
            if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol']  != RCLIENTES ){
                if($pedido == ""){
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                }else{
                    $requestPedido = $this->model->selectCotizacion($pedido,"");
                    if(empty($requestPedido)){
                        $arrResponse = array("status" => false, "msg" => "Datos no disponibles.");
                    }else{
                        //$requestPedido['estadotipo'] = $this->getEstadoTipo();
                        $htmlModal = getFile("Template/Modals/ModalCotizacion", $requestPedido);
                        $arrResponse = array("status" => true, "html" => $htmlModal);
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        //   funcion para editar y actualizar el estado cotización 
        // el gran problema
        public function setCotizacion(){
            if($_POST){
                if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol']  != RCLIENTES ){
                    $idpedido = !empty($_POST['idpedido']) ? intval($_POST['idpedido']) : "";
                    $estado = !empty($_POST['listEstado']) ? strClean($_POST['listEstado']) : "";

                        if($idpedido == ""){
							$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
						}else{
							$requestPedido = $this->model->updateCotizacion($idpedido,$estado);
							if($requestPedido){
								$arrResponse = array("status" => true, "msg" => "Datos actualizados correctamente");
							}else{
								$arrResponse = array("status" => false, "msg" => "No es posible actualizar la información.");
							}
                        }
                       echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } 
            die();
        }
        }
    }
?>        