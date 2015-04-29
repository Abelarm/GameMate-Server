<?php

if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];

    // include db handler
    require_once 'include/DB_Gioco_Functions.php';
    $db = new DB_Gioco_Functions();

    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);

	if($tag == 'contolloGioco'){
		$nomegioco = $_POST['nomegioco'];
	   	$piattaforma = $_POST['piattaforma'];
		
		if($db->isGiocoExisted($nomegioco,$piattaforma)){
			$response["success"] = 1;
   			$response["message"] = "Gioco esistente!";
   			// echoing JSON response
       		echo json_encode($response);
		}
		else{
		    $response["error"] = 1;
	        $response["error_msg"] = "Gioco non esistente!";
	        echo json_encode($response);
		}
	}
	
	// registrazione gioco
    if($tag == 'registrazioneGioco'){

		$nomegioco = $_POST['nomegioco'];
	   	$piattaforma = $_POST['piattaforma'];
		$genere = $_POST['genere'];

	 	$gioco = $db->storeGioco($nomegioco,$piattaforma,$genere);
 			if($gioco){
	 			// gioco registrato
	            $response["success"] = 1;
				$response["message"] = "Gioco registrato!";
	         	$response["gioco"]["TAG_GIOCO_ID"] = $gioco["gioco_id"];
	        	$response["gioco"]["TAG_NOME_GIOCO"] = $gioco["nome_gioco"];
	        	$response["gioco"]["TAG_PIATTAFORMA"] = $gioco["piattaforma"];
	        	$response["gioco"]["TAG_GENERE"] = $gioco["genere"];
	        	$response["gioco"]["TAG_NUMERO_GIOCATORI"] = $gioco["numero_giocatori"];
               	echo json_encode($response);
	        }
	        else {
	            // gioco non registrato
	            $response["error"] = 1;
	            $response["error_msg"] = "Errore nella Registrazione";
	            echo json_encode($response);
	        }
 		

    }// fine registrazione gioco

    // per prendere i dettagli di un gioco
    if($tag == 'getGioco'){

   		$nomegioco = $_POST['nomegioco'];
	   	$piattaforma = $_POST['piattaforma'];

	 	if($db->isGiocoExisted($nomegioco,$piattaforma)){ // il gioco c'è aggiorno il numero giocatori

	 		$gioco = $db->getGiocoByNomeAndPiattaforma($nomegioco,$piattaforma);
	 		if($gioco){
				// gioco trovato
		        $response["success"] = 1;
		       	$response["gioco"]["TAG_GIOCO_ID"] = $gioco["gioco_id"];
		       	$response["gioco"]["TAG_NOME_GIOCO"] = $gioco["nome_gioco"];
		       	$response["gioco"]["TAG_PIATTAFORMA"] = $gioco["piattaforma"];
		       	$response["gioco"]["TAG_GENERE"] = $gioco["genere"];
		       	$response["gioco"]["TAG_NUMERO_GIOCATORI"] = $gioco["numero_giocatori"];
           		echo json_encode($response);
		    }
		    else {
		        // gioco non registrato
		        $response["error"] = 2;
		        $response["error_msg"] = "Errore nella ricerca!";
		        echo json_encode($response);
		    }
		}
		else{
		  	// gioco non trovato
        	$response["error"] = 1;
       		$response["message"] = "Gioco non trovato!";
         	// echo no users JSON
        	echo json_encode($response);

		}
	}// fine getGioco

	
	if($tag == 'aggiornamentoGioco'){
		
		$nomegioco = $_POST['nomegioco'];
	   	$piattaforma = $_POST['piattaforma'];
		
		$result = $db->aggiornaNumeroGiocatori($nomegioco, $piattaforma);
	
		// check if row inserted or not
		if ($result) {
			// successfully updated
			$response["success"] = 1;
			$response["message"] = "Aggiornamento effettuato.";
 
			// echoing JSON response
			echo json_encode($response);
		} else {
			$response["error"] = 1;
			$response["error_message"] = "Gioco non aggionato.";
		}
	
	}// fine aggiornamento
	
     // per prendere i dati di tutti i giochi
    if($tag == 'getAllGiochi'){

		$giochi = $db->getAllGiochi();

     	if($giochi){
     		while($row = mysql_fetch_array($giochi)){

     			$response["gioco"]["TAG_GIOCO_ID"] = $row["gioco_id"];
		        $response["gioco"]["TAG_NOME_GIOCO"] = $row["nome_gioco"];
		        $response["gioco"]["TAG_PIATTAFORMA"] = $row["piattaforma"];
		        $response["gioco"]["TAG_GENERE"] = $row["genere"];
		        $response["gioco"]["TAG_NUMERO_GIOCATORI"] = $row["numero_giocatori"];

     		}
     		// success
    		$response["success"] = 1;
 			// echoing JSON response
    		echo json_encode($response);
     	}
     	else{
     		// gioco non trovato
        	$response["error"] = 1;
       		$response["message"] = "Gioco non trovato!";
         	// echo no users JSON
        	echo json_encode($response);
     	}



    }// fine getAllGiochi

 // fine
    else {
        echo "Tag Sbagliato";
    }
} else {
    echo "Access Denied";
}


?>
