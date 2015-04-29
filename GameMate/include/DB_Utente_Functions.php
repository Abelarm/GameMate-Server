<?php
 
class DB_Utente_Functions {
 
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
     * Storing new user
     * returns user details
     */
    public function storeUser($username, $password, $eta,$citta,$numAvatar) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $result = mysql_query("INSERT INTO Utente(unique_id, username, encrypted_password, salt, eta, citta, numero_avatar) VALUES('$uuid', '$username',  '$encrypted_password', '$salt', '$eta', '$citta','$numAvatar')");
        // check for successful store
        if ($result) {
            // get user details 
            $utente_id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM Utente WHERE utente_id = $utente_id");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
 
    /**
     * Get user by email and password
     */
    public function getUtenteByUsernameAndPassword($username, $password) {
        $result = mysql_query("SELECT * FROM Utente WHERE username = '$username'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($username) {
        $result = mysql_query("SELECT username from Utente WHERE username = '$username'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
    
    
    public function getDati($username){
    
     $result = mysql_query("SELECT numero_avatar from Utente WHERE username = '$username'");
     $riga = mysql_fetch_row($result);
     
     return $riga[0];   
    
    }

    public function aggiornaProfilo($username,$oldpass,$newpass,$eta,$citta,$numAvatar){
    	
        $result = mysql_query("SELECT * FROM Utente WHERE username = '$username'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
                        $hash = $this->hashSSHA($newpass);
        		$encrypted_password = $hash["encrypted"]; // encrypted password
        		$salt = $hash["salt"]; // salt
    			$result=mysql_query("UPDATE Utente SET encrypted_password = '$encrypted_password',salt='$salt', eta='$eta',  citta='$citta',numero_avatar='$numAvatar' WHERE username='$username' ");
    			 $result= mysql_query("SELECT * FROM Utente WHERE username = '$username'") or die(mysql_error());
                         return mysql_fetch_array($result);

    	}
    	else{
    			return $false;
    		}
    }
 
}
 
?>