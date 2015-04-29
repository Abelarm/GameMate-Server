<?php
/**
 * File to handle all API requests
 * Accepts GET and POST
 * 
 * Each request will be identified by TAG
 * Response will be JSON data
 
  /**
 * check for POST request 
 */
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];
 
    // include db handler
    require_once 'include/DB_Utente_Functions.php';
    $db = new DB_Utente_Functions();
 
    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
 
    // check for tag type
    if ($tag == 'login') { // login
    	

        // Request type is check Login
        $username = $_POST['username'];
        $password = $_POST['password'];
        
         // check if user is already existed
        if ($db->isUserExisted($username)) {
           
		    // check for user
		    $user = $db->getUtenteByUsernameAndPassword($username, $password);
		    if ($user != false) {
		        // user found
		        // echo json with success = 1
		        $response["success"] = 1;
		        $response["TAG_UNIQUE_ID"] = $user["unique_id"];            
		        $response["user"]["TAG_USERNAME"] = $user["username"];
		        $response["user"]["TAG_ETA"] = $user["eta"];
		        $response["user"]["TAG_CITTA"] = $user["citta"];
		        $response["user"]["TAG_NUMERO_AVATAR"] = $user["numero_avatar"];
		        echo json_encode($response);
		    } else {
		        // utente non trovato (dati sbagliati)
		        // echo json with error = 1
		        $response["error"] = 1;
		        $response["error_msg"] = "Username o Passwornd errate!";
		        echo json_encode($response);
		    }
    	}
    	else{
    		// utente non è registrato
    		$response["error"] = 2;
		    $response["error_msg"] = "Utente non registrato!";
		    echo json_encode($response);
    		
    	}
    }
    
    // registrazione utente
    else if ($tag == 'register') {
    

        // Request type is Register new user
		
        $username = $_POST['username'];
        $password = $_POST['password'];
        $eta = $_POST['eta'];
        $citta = $_POST['citta'];
        $numero_avatar = $_POST['numero_avatar'];
 
        // check if user is already existed
        if ($db->isUserExisted($username)) {
            // user is already existed - error response
            $response["error"] = 2;
            $response["error_msg"] = "Utente gia registrato!";
            echo json_encode($response);
        } 
        else {
            // store user
            $user = $db->storeUser($username, $password, $eta, $citta, $numero_avatar);
            if ($user) {
                // user stored successfully
                $response["success"] = 1;
             	$response["TAG_UNIQUE_ID"] = $user["unique_id"];            
            	$response["user"]["TAG_USERNAME"] = $user["username"];
            	$response["user"]["TAG_ETA"] = $user["eta"];
            	$response["user"]["TAG_CITTA"] = $user["citta"];
            	$response["user"]["TAG_NUMERO_AVATAR"] = $user["numero_avatar"];
                echo json_encode($response);
            } 
            else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Errore nella Registrazione";
                echo json_encode($response);
            }
        }
    } // fine registrazione utente
     
     
    else if($tag == 'getDati'){
    
    	 $username = $_POST['username'];
    	 
    	 $avatar = $db->getDati($username);
    	 if($avatar){
    	  		$response["success"] = 1;
             	$response["user"]["TAG_NUMERO_AVATAR"] = $avatar;
                echo json_encode($response);
      	 } 
         else {
                // user failed to store
         	$response["error"] = 1;
            $response["error_msg"] = "Errore nella richiesta";
            echo json_encode($response);
       	 }
    	 	
    	     
    } // fine getDati
    
     else if($tag=='aggiornaProfilo'){
    	
    	$username = $_POST['username'];
        $oldpass = $_POST['oldpass'];
        $newpass = $_POST['newpass'];
        $eta = $_POST['eta'];
        $citta = $_POST['citta'];
        $numAvatar = $_POST['numero_avatar'];
        
        $user = $db->aggiornaProfilo($username,$oldpass,$newpass,$eta,$citta,$numAvatar);
        if($user){
        // user stored successfully
                $response["success"] = 1;
             	$response["TAG_UNIQUE_ID"] = $user["unique_id"];            
            	$response["user"]["TAG_USERNAME"] = $user["username"];
            	$response["user"]["TAG_ETA"] = $user["eta"];
            	$response["user"]["TAG_CITTA"] = $user["citta"];
            	$response["user"]["TAG_NUMERO_AVATAR"] = $user["numero_avatar"];
                echo json_encode($response);
            } 
            else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = $user;
                echo json_encode($response);
            }

 
    	
    }
    
    
    
	// fine
    else {
        echo "Invalid Request";
    }
} else {
    echo "Access Denied";
}
?>