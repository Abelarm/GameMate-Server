<?php
 
 class DB_Gioco_Functions{
 
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
    
    
     /**
     * Registrare un nuovo gioco
     * restituisce i dettagli del gioco
     */
    public function storeGioco($nomegioco, $piattaforma, $genere) {
    	$i = 1;
        
        $result = mysql_query("INSERT INTO Gioco(nome_gioco, piattaforma, genere, numero_giocatori) VALUES('$nomegioco', 	'$piattaforma',  '$genere', '$i')");
        // check for successful store
        if ($result) {
            // get user details 
            $gioco_id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM Gioco WHERE gioco_id = $gioco_id");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
    
    
    /**
     * Get gioco dal nome e piattaforma
     */
    public function getGiocoByNomeAndPiattaforma($nomegioco, $piattaforma) {
        $result = mysql_query("SELECT * FROM Gioco WHERE nome_gioco = '$nomegioco' AND piattaforma = '$piattaforma'") or die	(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            
                // 
                return $result;
        } else {
            // gioco non trovato
            return false;
        }
    }
    
    
    
     /**
     * Controlla se il gioco esiste o no
     */
    public function isGiocoExisted($nomegioco,$piattaforma) {
        $result = mysql_query("SELECT nome_gioco,piattaforma FROM Gioco WHERE nome_gioco = '$nomegioco' AND piattaforma = '$piattaforma'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // gioco c'è 
            return true;
        } else {
            // gioco non c'è
            return false;
        }
    }
    
    
    /**
     * prende tutti i giochi registrati
     */
    public function getAllGiochi(){
    	// get all products from products table
		$result = mysql_query("SELECT *FROM Gioco") or die(mysql_error());
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
    *	Cancella
    */
    
    
    /**
    * Aggiorna il numero dei giocatori
    */
    public function aggiornaNumeroGiocatori($nomegioco, $piattaforma){
    	
    	
    	$result = mysql_query("UPDATE Gioco SET numero_giocatori = numero_giocatori+1 WHERE nome_gioco = '$nomegioco' AND piattaforma = '$piattaforma'");
    	if (mysql_affected_rows() > 0) {
            // gioco c'è 
            return true;
        } else {
            // gioco non c'è
            return false;
        }
    
    }
 
 
 
 
 
 
 
 
 
 }
 
 
 
 
 
 
 
 
 
?>
