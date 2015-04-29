<?php


class DB_Giocatore_Functions{
 
 	private $db;
 	
 	 //put your code here
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
    
    public function aggiungiGiocatore($giocatoreUsername,$giocatoreNomeGioco,$giocatorePiattaforma,$nickname,$latitudine,$longitudine){
    
     	$result = mysql_query("INSERT INTO Giocatore_Attivo(giocatore_username, giocatore_nomegioco, giocatore_piattaforma, nickname, latitudine, longitudine) VALUES('$giocatoreUsername','$giocatoreNomeGioco', '$giocatorePiattaforma', '$nickname', '$latitudine','$longitudine')");
     
     	if($result){
      		$giocatore_id = mysql_insert_id(); // last inserted id
        	$result = mysql_query("SELECT * FROM Giocatore_Attivo WHERE giocatore_id = $giocatore_id");
            // return user details
        	return mysql_fetch_array($result);
     	} 
     	else {
     		return false;
     	}
    
    }
    
    /**
    * Restituisce i dati di un giocatore attivo
    */
     public function getGiocatore($giocatoreUsername) {
        $result = mysql_query("SELECT * FROM Giocatore_Attivo WHERE giocatore_username = '$giocatoreUsername'") or die	(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            return $result;
        } else {
            // giocatore non trovato
            return false;
        }
    }
    
    /**
    *	restituisce tutti i giocatori 
    */
    public function getAllGiocatori($NomeGioco,$Piattaforma){
    	// get all products from products table
		$result = mysql_query("SELECT * FROM Giocatore_Attivo WHERE  giocatore_nomegioco='$NomeGioco' AND giocatore_piattaforma='$Piattaforma'") or die(mysql_error());
		 // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            return $result;
        } else {
            // gioco non trovato
            return false;
        }
    }
    
    
    
     /**
     * Controlla se il giocatore esiste o no
     */
    public function isGiocatoreAttivo($giocatoreUsername) {
        $result = mysql_query("SELECT giocatore_username FROM Giocatore_Attivo WHERE giocatore_username = '$giocatoreUsername'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // giocatore c'è 
            return true;
        } else {
            // gioco non c'è
            return false;
        }
    }
    
    
    /**
    *	Rimuove il giocatore dalla lista degli giocatori attivi
    */
    public function removeGiocatore($giocatoreUsername){
    	 $result = mysql_query("DELETE FROM Giocatore_Attivo WHERE giocatore_username = '$giocatoreUsername'");
        if(mysql_affected_rows()>0)
    			return true;
    		else
    			return false;
    }

public function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {  
    $earth_radius = 6371;  
      
    $dLat = deg2rad($latitude2 - $latitude1);  
    $dLon = deg2rad($longitude2 - $longitude1);  
      
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
    $c = 2 * asin(sqrt($a));  
    $d = $earth_radius * $c;  
      
    return $d/1000;  
}  
    
    

}










?>
