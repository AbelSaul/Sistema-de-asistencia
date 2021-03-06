<?php 
  require_once"nusoap-0.9.5/lib/nusoap.php";
  include 'conexion.php';

  $soap = new soap_server;
  $soap->configureWSDL('AddService', 'http://php.hoshmand.org/');
  $soap->wsdl->schemaTargetNamespace = 'http://soapinterop.org/xsd/';

  $soap->register(
    'metodos.consulta',
     array('dni' => 'xsd:int'),
     array('return' => 'xsd:string'),
    'http://soapinterop.org/'
  );

  $soap->register(
        'metodos.listarRegistros',
       array('dni' => 'xsd:int'),
        
        array('return'=>'xsd:Array'),
        'listarRegistrosWsdl',
        'urn:listarRegistrosWsdl',
        'rpc',
        'encoded',
        'Consultar Datos'
    );

  $soap->service(isset($HTTP_RAW_POST_DATA) ?
    $HTTP_RAW_POST_DATA : '');

  class metodos{
  		public $cn;
		  public function __construct(){
		     $this->cn = new conexion();

		  }


     public function listarRegistros($dni) 
     {

            $lista=array();
            
          $conn=$this->cn->conectar();
          $sql="select name, surname_paternal, dni from employees where dni ='$dni'";
          $r=$conn->query($sql)or die(mysqli_error()); 
            while($filas=mysqli_fetch_array($r,MYSQLI_ASSOC)){
              $lista[]=$filas;
            }

          return $lista;
     }


	     public function consulta($dni){
             $conn=$this->cn->conectar();
          
             $r=mysqli_query($conn,"select name from employees where dni ='$dni'");
             $resultado = mysqli_fetch_array($r);
             $a=$resultado['name'];
             return $a;
	  }
  }	
 ?>