<?php

/**
 * Book Manager Software - User class
 * 
 * 
 * 2015.10.4
 * 
 */

require_once("database.php");

define("GUEST_USER", 0);
define("NORMAL_USER", 1);
define("ADMIN_USER", 3);

class User {
    public $uid = '';
    public $username = 'Guest';
    public $info = array();
    
    private $stat = GUEST_USER;
    
    public function __construct() {
        if (isset($_SESSION['uid'])) {
            $this->uid = $_SESSION['uid'];
            $this->username = htmlspecialchars($_SESSION['username']);
            
            $this->stat = NORMAL_USER;
        }
        
    }
    
    
    public function get_status() {
        return $this->stat;
    }
    
    public function login($username, $password) {
        global $db;
        
        //wait for check string
        
        $username = $db->real_escape_string($username);
        $password = $db->real_escape_string(md5($password));
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        
        $result = $db->query($sql);

        //fail
        if (!is_object($result)) {
            printf("Error: %s, %s\n", $db->sqlstate, $db->error);
            return false;
        }
        
        if ($result->num_rows != 1) {
            trigger_error("Username or password is wrong.",  E_USER_WARNING);
            return false;
        }
        
        //success
        $this->info = $result->fetch_assoc();
        
        $this->uid = $this->info['uid'];
        $this->username = $this->info['username'];
        $this->stat = NORMAL_USER;
        
        $_SESSION['uid'] = $this->uid;
        $_SESSION['username'] = $this->username;
        
        return true;
    }
    
    public function logout() {
        if ($this->stat == GUEST_USER) return;
        
        //reset info
        $this->uid = '';
        $this->username = 'Guest';
        $this->stat = GUEST_USER;
        $this->info = array();
        
        //clear session
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
    
    public function update_info() {
        
    }
    
//     public function borrow_book() {
        
//     }
    
//     public function return_book() {
        
//     }
    
//     public function book_in_hand() {
        
//     }
    
//     public function history() {
        
//     }
    
    public static function create_user($info) {
        global $db;
        //wait for check string

        $email    = $db->real_escape_string($info['email']);
        $username = $db->real_escape_string($info['username']);
        $password = $db->real_escape_string(md5($info['password']));
        
        $sql = "INSERT INTO users(email, username, password) VALUES ('$email', '$username', '$password')";
        
        $result = $db->query($sql);
        
        if (!$result) {
            printf("Error: %s, %s\n", $db->sqlstate, $db->error);
            return false;
        }
        
        return true;
    }
    
}

$cur_user = new User();


?>