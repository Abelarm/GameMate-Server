<?php

if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];

    // include db handler
    require_once 'include/DB_Amico_Functions.php';
    $db = new DB_Amico_Functions();
    
    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
    
    
    if($tag=='inserisciAmici'){
    	
    	$nick1=$_POST['nick1'];
    	$nick2=$_POST['nick2'];
    	
    	$amico= $db->storeFriends($nick1,$nick2);
    	if($amico){
	 	       // amici registrati
	                $response["success"] = 1;
			$response["message"] = "Amici registrati";
	         	$response["amico"]["TAG_NICKNAME1"] = $amico["Nickname1"];
	        	$response["amico"]["TAG_NICKNAME2"] = $amico["Nickname2"];
	        	echo json_encode($response);
	    }else{
	    	// amici non registrati
	        $response["error"] = 1;
	        $response["error_msg"] = "Errore nella Registrazione";
	        echo json_encode($response);
	    }
    
    }
    
    
    if($tag=='getAmici_di'){
    	
    	$nick1=$_POST['nick1'];
    	
    	$amici=$db->getFriends_of($nick1);
    	if($amici){
    		//restituisco tutti gli amici di una determinata persona
    		 $response["success"] = 1;
			 $response["message"] = "Amici registrati";
			 $response["amico"]["TAG_AMICI"]= $amici;    //questo campo dell'array contiene un array contenente tutti gli amici
			 echo json_encode($response);
    	}else{
    		//non ha amici
    		$response["error"] = 1;
	        $response["error_msg"] = "Questo utente non ha amici";
	        echo json_encode($response);
    	}
    }


	if($tag=='rimuoviAmico'){
		
    	$nick1=$_POST['nick1'];
    	$nick2=$_POST['nick2'];
    	
    	$amici=$db->removeFriends($nick1,$nick2);
    	if($amici){
    	//resitutisco true se gli amici sono stati rimossi bene
    	$response["success"] = 1;
		$response["message"] = "Amici cancellati";
		echo json_encode($response);
    	}else{
    	// amici non cancellati
	    $response["error"] = 1;
	    $response["error_msg"] = "Errore nella Cancellazione";
	    echo json_encode($response);
    	}
	}


	if($tag == 'sonoAmici'){
		$nick1=$_POST['nick1'];
    	$nick2=$_POST['nick2'];
    	
    	$amici=$db->areFriends($nick1,$nick2);
    	if($amici){
    	//resitutisco true se gli amici sono stati rimossi bene
    	$response["success"] = 1;
		$response["message"] = "Sono amici";
		echo json_encode($response);
    	}else{
    	// amici non cancellati
	    $response["error"] = 1;
	    $response["error_msg"] = "Non sono amici";
	    echo json_encode($response);
    	}
	}


}// fine


?>