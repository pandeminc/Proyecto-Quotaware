<?php 
	
	//define("BASE_URL", "http://localhost/tienda_virtual/");
	const BASE_URL = "http://localhost/sistema2";

	//Zona horaria
	date_default_timezone_set('America/Santiago');

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "db_sistema2";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "utf8";

	//Deliminadores decimal y millar Ej. 24.198
	const SPD = ".";
	const SPM = ".";

	//Simbolo de moneda
	const SMONEY = "$";

	//Datos envio de correo
	const NOMBRE_REMITENTE = "Quotaware";
	const EMAIL_REMITENTE = "no-reply@pandeminc.cl";
	const NOMBRE_EMPESA = "IngeniosChile";
	const WEB_EMPRESA = "www.ingenioschile.cl";

	//Roles
	const RADMINISTRADOR = 1;
	const RCLIENTES = 7;

	//Datos Empresa
	const DIRECCION = "Iquique, Chile.";
	const TELEMPRESA = "+56 9 6845 0956";
	const EMAIL_EMPRESA = "hola@ingenioschile.cl";
	const EMAIL_PEDIDOS = "info@abelosh.com";

	//estados cotizaciones
	const STATUS = array('Aprobado','Rechazado','Pendiente','Realizado');
	



	


 ?>