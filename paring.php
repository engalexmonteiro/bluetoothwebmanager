<html>
 <head>
  <title>PHP Teste</title>
 </head>
 <body>
<?php


function scanBlue(){
        $cmd = "hcitool scan";
        $result = shell_exec($cmd);

	echo "<center>Selecione o dispositivo</br>";

	$list = explode('	', $result);

//	echo "<center><div class=\"list-group\">";

	echo  "<form action=\"paring.php\" method=\"post\" ><select name=\"mac\" >";

	$n = count($list);

	for($i=1; $i < $n; $i=$i+2){
//		print($list[i] . "    " . $list[$i+1] . "</br>" ); 
		echo  "<option value=\"" . $list[$i] . "\">" . $list[$i+1] . "</option>";
//		  echo "<a href=\"./&op=cc&mac=" . $list[$i] . "&auth=6779\" class=\"list-group-item\">" .  $list[$i+1] . "</a></br>";
	} 
	echo "</select></br>PIN Code</br>";
	

	echo "<input type=\"hidden\" name=\"op\" value=\"cc\">";
 
	echo "<input type=\"text\" name=\"pin\"><br>";

	echo "<input type=\"submit\" value=\"Conectar\">";

	echo "</form></center>";

//	echo "</div></center>";

       }

function connectBlue($mac,$pin){
  	 $cmd = "./paring.sh paring " . $mac . " " . $pin . " | bluetoothctl";
	 $result = shell_exec($cmd);
  	 print($result);
}


	switch($_POST['op']){
			case 'sc': echo "</br>";
				scanBlue();
 				break;
			case 'cc':
				connectBlue($_POST['mac'],$_POST['pin']);
				break;
			case 'rm':
				$cmd =  "./paring.sh remove 20:14:05:21:34:67 | bluetoothctl";
				$result = shell_exec($cmd);
				echo $result;
			
				break;
	}


?>
<center>

	<h1>Bluetooth Web Manager</h1>

        <form action="" method="post">
            <button name="op" value="sc">Adicionar</button></br>
	    <button name="op" value="rm">Remover</button>
        </form>

</center>
 </body>
</html>
