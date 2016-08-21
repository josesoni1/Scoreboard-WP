<?php






$dbhost = '67.192.246.142:3306';
$dbuser = 'root';
$dbpass = 'A1ESECMX-hub2438_dbs';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}


if( isset($_POST['ai']) ){
	$ai = $_POST["ai"]; 	//	Año inicial
	$af = $_POST["af"]; 	//	Año final
	$mi = $_POST["mi"]; 	//	Mes inicial
	$mf = $_POST["mf"]; 	//	Mes Final
	$prog = $_POST["prog"]; // Programa que queremos consultar
	$lc = $_POST["lc"]; 	// LC que queremos consultar
}

if( isset($_GET['ai']) ){
	$ai = $_GET["ai"]; 		//	Año inicial
	$af = $_GET["af"]; 		//	Año final
	$mi = $_GET["mi"]; 		//	Mes inicial
	$mf = $_["mf"]; 		//	Mes Final
	$prog = $_GET["prog"]; 	// Programa que queremos consultar
	$lc = $_GET["lc"]; 		// LC que queremos consultar
}



$sql1 ='SELECT LC.LC_name , sum(operation.app_ach) as ap, sum(operation.re_ach) as re, operation.year
from LC inner join operation
on LC.idLC = operation.LC_idLC 
inner join program 
on operation.program_idprogram = program.idprogram
where operation.month between '. $mi .' and '. $mf .' 
group by LC.LC_name, operation.year';


$comites = array();

mysql_select_db('scoreboard');

$res1 = mysql_query( $sql1, $conn );
if(! $res1 )
{
  die('Could not get data: ' . mysql_error());
}
$cadena = "llll";
while($row = mysql_fetch_array($res1, MYSQL_ASSOC))
{
	if (array_key_exists("{$row['LC_name']}", $comites)){

		$comites["{$row['LC_name']}"] ["a{$row['year']}"] = array( 
			   	"ap" => $row['ap'],
				"re" => $row['re']
				);
	}else{

		$comites["{$row['LC_name']}"] = array(
			"a{$row['year']}" => array( 
			   	"ap" => $row['ap'],
				"re" => $row['re']
				)
			);
	}

	
    
} 


echo json_encode($comites);



mysql_close($conn);


?>