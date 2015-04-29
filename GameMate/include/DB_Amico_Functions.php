<?php
 
 class DB_Amico_Functions{
 
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
    
    //funzione per inserire una nuova coppia di amici
    function storeFriends($nick1,$nick2){
    	$result=mysql_query("INSERT INTO Amico(Nickname1,Nickname2) VALUES ('$nick1','$nick2')");
    	if ($result) {
            // get user details 
            $amici_id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM Amico WHERE ID ='$amici_id'");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
	}
        
    
    //restituisce un array contenente tutti gli amici di un determinato utente false se non ne possiede
    function getFriends_of($nick1){
    	$result=mysql_query("SELECT * FROM Amico WHERE Nickname1='$nick1' OR Nickname2='$nick1'");
    	if(mysql_num_rows($result)==0)
    			return false;
    	$i=0;
    	while($riga=mysql_fetch_row(result)){
    		if($riga[1]==$nick1)
    			$risultato[$i]=$riga[2];
    		else
    			$risultato[$i]=$riga[1];
    		
    		$i++;
    		
    	}
    	return $risultato;
    }
    	
    
    //cancella una coppia di amici
    function removeFriends($nick1,$nick2){
    		$result=mysql_query("DELETE FROM Amico WHERE Nickname1='$nick1' AND Nickname2='$nick2'");
    		if(mysql_affected_rows()>0)
    			return true;
    		else
    			return false;
    	
    }
    	
        
    function areFriends($nick1,$nick2){
    	$result1=mysql_query("SELECT * FROM Amico WHERE Nickname1='$nick1' AND Nickname2='$nick2'");
    	$result2=mysql_query("SELECT * FROM Amico WHERE Nickname2='$nick1' AND Nickname1='$nick2'");
    	if(mysql_num_rows($result1)== 0 || mysql_num_rows($result2)==0)
			return true;
    	else
    		return false;
    }
	
	
}

?>
    
    
    