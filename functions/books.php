<?php

require_once('database.php');

class Book {
    public $info = array();
    
    public function  __construct($info = array()) {
        if (isset($info['bk_id'])) {
            $this->set_book($info['bk_id'], "bk_id");
        }
        if (isset($info['isbn'])) {
            $this->set_book($info['isbn'], "isbn");
        }
    }
    
    public function set_book($key, $key_type = "isbn") {
        global $db;
        
        $key = $db->real_escape_string($key);
        $sql = "SELECT * FROM book WHERE '$key_type' = '$key'";
        
        $result = $db->query($sql);
        
        //fail
        if (!is_object($result)) {
            printf("Error: %s, %s\n", $db->sqlstate, $db->error);
            return false;
        }
        if ($result->num_rows != 1) {
            trigger_error("The '$key_type' you search does not exist.",  E_USER_WARNING);
            return false;
        }
        
        //success
        $this->info = $result->fetch_assoc();
        
        return true;
    }
    
    public function update_book_info($info) {
        global $db;
        if (!isset($info['bk_id'])    ||
            !isset($info['isbn'])     ||
            !isset($info['bookname']) ||
            !isset($info['author'])   ||
            !isset($info['press'])    ||
            !isset($info['count'])    ||
            !isset($info['res'])
           ) return false;
      
        $bk_id = $db->real_escape_string($info['bk_id']);
        $isbn = $db->real_escape_string($info['isbn']);
        $bookname = $db->real_escape_string($info['bookname']);
        $author = $db->real_escape_string($info['author']);
        $press = $db->real_escape_string($info['press']);
        $count = $db->real_escape_string($info['count']);
        $res = $db->real_escape_string($info['res']);
        
        $sql = "UPDATE book SET isbn = '$isbn', bookname = '$bookname', author = '$author', count = '$count', res = '$res' where bk_id = '$bk_id'";
        
        $result = $db->query($sql);
        
        if (!$result) {
            printf("Error: %s, %s\n", $db->sqlstate, $db->error);
            return false;
        }
        
        
        return true;
    }
    
    public static function create_book($info) {
        global $db;
        if (//!isset($info['bk_id'])    ||
            !isset($info['isbn'])     ||
            !isset($info['bookname']) ||
            !isset($info['author'])   ||
            !isset($info['press'])    ||
            !isset($info['count'])
           ) return false;
        if (!isset($info['res'])) $info['res'] = $info['count'];
        
      //  $info['bk_id'] = $db->real_escape_string($info['bk_id']);
        $isbn = $db->real_escape_string($info['isbn']);
        $bookname = $db->real_escape_string($info['bookname']);
        $author = $db->real_escape_string($info['author']);
        $press = $db->real_escape_string($info['press']);
        $count = $db->real_escape_string($info['count']);
        $res = $db->real_escape_string($info['res']);
        
        $sql = "INSERT INTO book(isbn, bookname, author, press, count, res) VALUES('$isbn', '$bookname', '$author', '$press', '$count', '$count')";
        
        $result = $db->query($sql);
        
        if (!$result) {
            printf("Error: %s, %s\n", $db->sqlstate, $db->error);
            return false;
        }
        
        return true;
    }
    
}


//     public function borrow_book()
//     public function return_book()   
//     public function book_in_hand()
//     public function history()

function borrow_book_by_isbn($user, $isbn) {    //unfinished
    global $db;
    $book = new Book(array('isbn' => $isbn));
  //  if ()
    
    if ($book->info['res'] <= 0) {
        trigger_error("There are no books rest.",  E_USER_WARNING);
        return false;
    }
    
}


?>