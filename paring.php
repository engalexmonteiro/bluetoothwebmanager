<html>
 <head>
  <title>BlueWman</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">  </script>


 </head>



 <body>

<script type="text/javascript">  

function bLoad() {
   var text = document.getElementById("bLoad").firstChild;
   text.data = "Searching";
}

</script>

<?php


function scanBlue(){
        $cmd = "hcitool scan";
        $result = shell_exec($cmd);

	echo "<center>";

	$list = explode('	', $result);


	echo  "<form action=\"paring.php\" method=\"post\">";

	        echo  "<div class=\"form-group\">";

 	        	echo "<label for=\"mac\">Selecione o dispositivo</label>";

        	        echo "<select class=\"form-control\" id=\"mac\" name=\"mac\" style=\"width:350px;\">";


			$n = count($list);

			for($i=1; $i < $n; $i=$i+2){
				echo  "<option value=\"" . $list[$i] . "\">" . $list[$i+1] . "</option>";
			} 
		
			echo "</select></br>";

		echo "</div>";

	
		echo "<input type=\"hidden\" name=\"op\" value=\"cc\">";
 
		echo "<div class=\"form-group\">";
			echo "<label for=\"pin\">PIN Code:</label>";
			echo "<input type=\"text\" class=\"form-control\" id=\"pin\" name=\"pin\" style=\"width:100px;\">";
		echo "</div>";

        echo "<button type=\"submit\" class=\"btn btn-default\">Conectar</button>";

	echo "</form></center>";


       }

function connectBlue($mac,$pin){
  	 $cmd = "./paring.sh paring " . $mac . " " . $pin . " | bluetoothctl";
	 $result = shell_exec($cmd);
//         print($cmd . "</br>");

//	 $cmd = "./paring.sh parieds | bluetoothctl";
//         $result = shell_exec($cmd);
//	 $result = str_replace("[0","</br>",$result);
  //	 print($result);
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


function get_paried_devices(){
         $cmd = "./paring.sh paireds | bluetoothctl";

         $console = shell_exec($cmd);

         $teste = get_string_between($console,"devices\n","[0;94m");

 	 $teste = str_replace("Device ","",$teste);
	 $list_temp = explode("\n",$teste);

	 array_pop($list_temp);

 	 $list = [];

	 foreach($list_temp as $dev_temp){
		$temp = explode(" ",$dev_temp);

		$device =  array( "mac"  => $temp[0], "name" => $temp[1]);

		array_push($list,$device);
	}


	return $list;

}



?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<center>

	<h1>Bluetooth Web Manager</h1>



        <form action="paring.php" method="post">

		<?php 
		   
		   $list_devs = get_paried_devices();

		   if(count($list_devs) > 0){
		?>


			 <div class="form-group">

                        <label for="mac">Dispositivo pareados</label>
                        <select class="form-control" id="mac" name="mac" style="width:350px;">

			<?php 
	  	           foreach($list_devs as $device){
		                echo  "<option value=\"" . $device['mac'] . "\">" . $device['name'] . "</option>";
	        	   }
			?>

			 </select></br>	

	                </div>	
	<?php   } ?>


		 <div class="form-group">
			  <button class="btn btn-primary">Refresh</button>
			  <button name="op" value="sc" class="btn btn-primary" id="bLoad" onclick="bLoad()">Adicionar</button>
			  <button name="op" value="rm" class="btn btn-primary">Remover</button>
			  <button name="op" value="esp" class="btn btn-primary">Enable Serial</button>
  		 </div> 


        </form>

	</br>

        <?php

	 switch($_POST['op']){
                        case 'sc': echo "</br>";
                                scanBlue();
                                break;
                        case 'cc':
                                connectBlue($_POST['mac'],$_POST['pin']);
                                break;
                        case 'rm':
                                $cmd =  "./paring.sh remove " . $_POST['mac'] . " | bluetoothctl";
//				echo $cmd . "</br>";
                                $result = shell_exec($cmd);
//                                echo $result;

                                break;
                        case 'esp':
                                $cmd =  "rfcomm connect /dev/rfcomm0 " . $_POST['mac'] . " &";
                                $result = shell_exec($cmd);
                                echo $result;
                                break;

        }


	?>




</center>
 </body>
</html>
