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
	$ai = $_POST['ai']; 	//	Año inicial
}
if( isset($_POST['af']) ){
	$af = $_POST['af']; 	//	Año final
}
if( isset($_POST['mi']) ){
	$mi = $_POST['mi']; 	//	Mes inicial
}
if( isset($_POST['mf']) ){
	$mf = $_POST['mf']; 	//	Mes Final
}
if( isset($_POST['prog']) ){
	$prog = $_POST['prog']; // Programa que queremos consultar
}
if( isset($_POST['lc']) ){
	$lc = $_POST['lc']; 	// LC que queremos consultar
}

if( isset($_GET['ai']) ){
	$ai = $_GET['ai']; 		//	Año inicial
}
if( isset($_GET['af']) ){
	$af = $_GET['af']; 		//	Año final
}
if( isset($_GET['mi']) ){
	$mi = $_GET['mi']; 		//	Mes inicial
}
if( isset($_GET['mf']) ){
	$mf = $_GET['mf']; 		//	Mes Final
}
if( isset($_GET['prog']) ){
	$prog = $_GET['prog']; 	// Programa que queremos consultar
}
if( isset($_GET['lc']) ){
	$lc = $_GET['lc']; 		// LC que queremos consultar
}
//echo isset($_GET['mi']);

//echo "<br><br>";
//echo isset($_GET['mf']);

//echo "<br><br>";

//echo $mi;

//echo "<br><br>";
//echo $mf;

//echo "<br><br>";


$sql1 ="SELECT LC.LC_name , sum(operation.app_ach) as ap, sum(operation.re_ach) as re, operation.year
from LC inner join operation
on LC.idLC = operation.LC_idLC 
inner join program 
on operation.program_idprogram = program.idprogram
where operation.month between ". $mi ." and ". $mf ." 
group by LC.LC_name, operation.year";


echo $sql1;

echo "<br><br>";

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