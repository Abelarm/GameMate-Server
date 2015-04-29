<?php

if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];

    // include db handler
    require_once 'include/DB_Giocatore_Functions.php';
    $db = new DB_Giocatore_Functions();
    
    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
    
	
    
    if($tag=='inserisciGiocatore'){
    	$giocatoreUsername=$_POST['Username'];
    	$giocatoreNomeGioco=$_POST['NomeGioco'];
    	$giocatorePiattaforma=$_POST['Piattaforma'];
    	$nickname=$_POST['Nickname'];
    	$latitudine=(double)$_POST['lat'];
    	$longitudine=(double)$_POST['long'];
    	
    	$giocatore=$db->aggiungiGiocatore($giocatoreUsername,$giocatoreNomeGioco,$giocatorePiattaforma,$nickname,$latitudine,$longitudine);
    	if($giocatore){
    		// giocatore registrati
	            $response["success"] = 1;
				$response["message"] = "Giocatore registrato";
	         	$response["player"]["TAG_USERNAME"] = $giocatore["giocatore_username"];
	        	$response["player"]["TAG_NOMEGIOCO"] = $giocatore["giocatore_nomegioco"];
	        	$response["player"]["TAG_PIATTAFORMA"] = $giocatore["giocatore_piattaforma"];
	        	$response["player"]["TAG_NICKNAME"] = $giocatore["nickname"];
	        	$response["player"]["TAG_LAT"] = $giocatore["latitudine"];
	        	$response["player"]["TAG_LON"] = $giocatore["longitudine"];
	        	echo json_encode($response);
    	}else{
    		// giocatore non registrati
	        $response["error"] = 1;
	        $response["error_msg"] = "Errore nella Registrazione";
	        echo json_encode($response);
    	}
    }
    
    
    if($tag=='getGiocatore'){
    	$giocatoreUsername=$_POST['Username'];
    	$giocatore=$db->getGiocatore($giocatoreUsername);
    	if($giocatore){
    	 		$response["success"] = 1;
				$response["message"] = "Giocatore trovato";
	         	$response["player"]["TAG_USERNAME"] = $giocatore["giocatore_username"];
	        	$response["player"]["TAG_NOMEGIOCO"] = $giocatore["giocatore_nomegioco"];
	        	$response["player"]["TAG_PIATTAFORMA"] = $giocatore["giocatore_piattaforma"];
	        	$response["player"]["TAG_NICKNAME"] = $giocatore["nickname"];
	        	$response["player"]["TAG_LAT"] = $giocatore["latitudine"];
	        	$response["player"]["TAG_LON"] = $giocatore["longitudine"];
	        	echo json_encode($response);
    	}else{
    		// amici non registrati
	        $response["error"] = 1;
	        $response["error_msg"] = "Errore nella ricerca";
	        echo json_encode($response);
    	}
    	
    }
    
    if($tag=='getAllGiocatoriBy'){
    	$giocatoreNomeGioco=$_POST['NomeGioco'];
    	$giocatorePiattaforma=$_POST['Piattaforma'];
	$latitudineUtente = $_POST['Latitudine'];
	$longitudineUtente = $POST['Longitudine'];
		
    	$giocatore=$db->getAllGiocatori($giocatoreNomeGioco,$giocatorePiattaforma);
    	if($giocatore){
    		$response["success"] = 1;
		$response["message"] = "Giocatori trovati";
                $response["players"]=array();
     		while($row = mysql_fetch_array($giocatore)){
                        $player=array();
	         	$player["TAG_USERNAME"] = $row["giocatore_username"];
	        	$player["TAG_NOMEGIOCO"] = $row["giocatore_nomegioco"];
	        	$player["TAG_PIATTAFORMA"] = $row["giocatore_piattaforma"];
	        	$player["TAG_NICKNAME"] = $row["nickname"];
	        	$player["TAG_LAT"] = $row["latitudine"];
	        	$player["TAG_LON"] = $row["longitudine"];
				
			$latitudineGiocatore = $row["latitudine"];
			$longitudineGiocatore = $row["longitudine"];
				
			$distanza = $db->getDistance($latitudineUtente,$longitudineUtente,$latitudineGiocatore,$longitudineGiocatore);
				
			$player["TAG_DISTANZA"] = $distanza;
			
	                array_push($response["players"],$player);
     		}
                
                echo json_encode($response);
     	}else{
    		// giocatori non trovati
	        $response["error"] = 1;
	        $response["error_msg"] = "Errore nella ricerca";
	        echo json_encode($response);
    	}
    }
    
    if($tag=='isOnline'){
    	$giocatoreUsername=$_POST['Username'];
    	$result=$db->isGiocatoreAttivo($giocatoreUsername);
    	if($result){
    		//resitutisco true se gli amici sono stati rimossi bene
    		$response["success"] = 1;
			$response["message"] = "E' online";
			echo json_encode($response);
    	}else{
    		// amici non cancellati
	    	$response["error"] = 1;
	    	$response["error_msg"] = "Non è online";
	    	echo json_encode($response);
    	}
    }
    
    
    if($tag=='rimuoviGiocatore'){
    	$giocatoreUsername=$_POST['Username'];
    	$result=$db->removeGiocatore($giocatoreUsername);
    	if($result){
    		//resitutisco true se gli amici sono stati rimossi bene
    		$response["success"] = 1;
			$response["message"] = "Rimozione effettuata con successo";
			echo json_encode($response);
    	}else{
    		// amici non cancellati
	    	$response["error"] = 1;
	    	$response["error_msg"] = "Errore nella rimozione";
	    	echo json_encode($response);
    	}
    }
}

else{
    	return "Tag sbagliato";
    }
 
?>