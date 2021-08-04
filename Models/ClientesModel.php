<?php 

class ClientesModel extends Mysql
{
    private $intIdUsuario;
    private $strIdentificacion;
    private $strNombre;
    private $strApellido;
    private $intTelefono;
    private $strDireccion;
    private $strEmail;
    private $strPassword;
    private $strToken;
    private $intTipoId;
    private $intStatus;
    private $strNit;
    private $strNomFiscal;
    private $strDirFiscal;

    public function __construct()
    { 
        parent::__construct();
    }	

    public function insertCliente(string $identificacion, string $nombre, string $apellido, int $telefono, string $direccion, string $email, int $tipoid, string $nit, string $nomFiscal
    , string $dirFiscal){

        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strDireccion = $direccion;
        $this->strEmail = $email;
        $this->intTipoId = $tipoid;
        $this->strNit = $nit;
        $this->strNomFiscal = $nomFiscal;
        $this->strDirFiscal = $dirFiscal;
        $return = 0;

        $sql = "SELECT * FROM persona WHERE 
                email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}' ";
        $request = $this->select_all($sql);

        if(empty($request))
        {
            $query_insert  = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,direccion,email_user,rolid,nit,nombrefiscal,direccionfiscal) 
                              VALUES(?,?,?,?,?,?,?,?,?,?)";
            $arrData = array($this->strIdentificacion,
                            $this->strNombre,
                            $this->strApellido,
                            $this->intTelefono,
                            $this->strDireccion,
                            $this->strEmail,
                            $this->intTipoId,
                            $this->strNit,
                            $this->strNomFiscal,
                            $this->strDirFiscal);
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = "exist";
        }
        return $return;
    }

    public function selectClientes()
    {
        $sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,direccion,email_user
                FROM persona 
                WHERE rolid= 7 and status != 0 ";
                
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCliente(int $idpersona){
        $this->intIdUsuario = $idpersona;
        $sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,direccion,email_user,nit,nombrefiscal,direccionfiscal,p.status, 
        DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro
                FROM persona p
                WHERE idpersona = $this->intIdUsuario and rolid = 7";
        $request = $this->select($sql);
        return $request;
    }
    // ACTUALIZAR CLIENTE
    public function updateCliente(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $direccion, string $email, string $nit, string $nomFiscal,
        string $dirFiscal){

        echo ('algo');    
        $this->intIdUsuario = $idUsuario;
        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strDireccion = $direccion;
        $this->strEmail = $email;
        $this->strNit = $nit;
        $this->strNomFiscal = $nomFiscal;
        $this->strDirFiscal = $dirFiscal;

        $sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario)
                                      OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario) ";
        $request = $this->select_all($sql);

        if(empty($request))
        {
            
            //if($this->strPassword  != "")
            //{
                /*$sql = "UPDATE persona SET identificacion='".$identificacion."',nombres='".$nombre."',apellidos='".$apellido."', telefono=".$telefono.", direccion='".$direccion."',
                         email_user='".$email."', nit='".$nit."', nombrefiscal='".$nomFiscal."', direccionfiscal='".$dirFiscal."' WHERE idpersona = $this->intIdUsuario ";*/
                $sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, direccion=?, email_user=?, nit=?, nombrefiscal=?, direccionfiscal=? 
                        WHERE idpersona = $this->intIdUsuario ";
                //echo ($sql); exit;
                $arrData = array($this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->$telefono,
                                $this->strDireccion,
                                $this->strEmail,
                                $this->strNit,
                                $this->strNomFiscal,
                                $this->strDirFiscal);
            /*}else{
                $sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, rolid=?, status=? 
                        WHERE idpersona = $this->intIdUsuario ";
                $arrData = array($this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->intTelefono,
                                $this->strEmail,
                                $this->intTipoId,
                                $this->intStatus);
            }*/
            $request = $this->update($sql,$arrData);
            
        }else{
            $request = "exist";
        }
        return $request;
    }

    public function deleteCliente(int $intIdpersona)
    {
        $this->intIdUsuario = $intIdpersona;
        $sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario ";
        $arrData = array(0);
        $request = $this->update($sql,$arrData);
        return $request;
    }


}

?>