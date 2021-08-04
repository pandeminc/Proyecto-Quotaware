<?php

class Clientes extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(4);
		}

		public function Clientes()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Clientes";
			$data['page_title'] = "CLIENTES <small>Quotaware</small>";
			$data['page_name'] = "clientes";
			$data['page_functions_js'] = "functions_clientes.js";
			$this->views->getView($this,"clientes",$data);
		}

		public function setCliente(){
			if($_POST){
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || 
				empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtDireccion']) || empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal'])
				|| empty($_POST['txtDirFiscal']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = (strClean($_POST['txtTelefono']));
					$strDireccion = ucwords(strClean($_POST['txtDireccion']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$strNit = ucwords(strClean($_POST['txtNit']));
					$strNomFiscal = ucwords(strClean($_POST['txtNombreFiscal']));
					$strDirFiscal = ucwords(strClean($_POST['txtDirFiscal']));
					$intTipoId = 7; // segun la base de datos (tabla rol)
					$request_user = "";
					echo ($intTelefono." ".$idUsuario );
					if($idUsuario == 0)
					{
						$option = 1;
						//$strPassword =  empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);

						if($_SESSION['permisosMod']['w']){
							$request_user = $this->model->insertCliente($strIdentificacion,
																				$strNombre, 
																				$strApellido, 
																				$intTelefono,
																				$strDireccion, 
																				$strEmail,
																				$intTipoId,
																				$strNit,
																				$strNomFiscal,
																				$strDirFiscal );
						}
					}else{
						$option = 2;
						//$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['u']){
							$request_user = $this->model->updateCliente($idUsuario,
																				$strIdentificacion,
																				$strNombre, 
																				$strApellido, 
																				$intTelefono,
																				$strDireccion, 
																				$strEmail,
																				$strNit,
																				$strNomFiscal,
																				$strDirFiscal );
						}

					}

					if($request_user > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o el rut ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getClientes()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectClientes();
				/*dep($arrData);
				exit;*/
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idpersona'].')" title="Ver cliente"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
							$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idpersona'].')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
					}

					if($_SESSION['permisosMod']['d']){
							$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idpersona'].')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>';
					}
					
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}	
			die();
		}

		public function getCliente($idpersona){
			if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idpersona);
				if($idusuario > 0)
				{
					$arrData = $this->model->selectCliente($idusuario);
					//dep($arrData);exit;
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delCliente()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteCliente($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cliente.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		
		

	}
?>