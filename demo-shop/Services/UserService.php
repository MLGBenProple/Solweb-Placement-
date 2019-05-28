<?php

class UserService
{
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=bensshop', 'ben', '3zHlv3&5');
    }

    function parseRow($row) 
    {
        $user = new User();
        $user->setID($row["ID"]);
        $user->setUserName($row['Username']);
        $user->setPassword($row['Password']);
        $user->setIsAdmin($row['IsAdmin']);
        return $user;
    }

    public function getAll()
    {
        $users = array();
        foreach ($this->db->query('SELECT * FROM users') as $row) {
           
            array_push($users, $this->parseRow($row));
        }
        return $users;
    }
   

    public function getByID($id)
    {        
        $stmt = $this->db->prepare('SELECT * FROM users WHERE ID = :ID');
        $stmt->bindParam(':ID', $id);
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {                
                return $this->parseRow($row);
            }
        }
    }

    public function getByUsername($username)
    {        
        $stmt = $this->db->prepare('SELECT * FROM users WHERE Username = :Username');
        $stmt->bindParam(':Username', $username);
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {                
                return $this->parseRow($row);
            }
        }
    }
   
    public function create($user)
    {
        $stmt = $this->db->prepare('INSERT INTO users (Username, Password, IsAdmin) VALUES (:Name, :Password, :IsAdmin)');
        $stmt->bindValue(':Name', $user->getUsername());
        $stmt->bindValue(':Password', $user->getPassword());
        $stmt->bindValue(':IsAdmin', $user->getIsAdmin());
        $stmt->execute();
        
        
    }

    public function update($user)
    {
        $stmt = $this->db->prepare('UPDATE users SET Username = :Name, Password = :Password, IsAdmin = :IsAdmin  WHERE (ID = :ID);');
        $stmt->bindValue(':Name', $user->getUsername());
        $stmt->bindValue(':Password', $user->getPassword());
        $stmt->bindValue(':ID', $user->getID());
        $stmt->bindValue(':IsAdmin', $user->getIsAdmin());
        $stmt->execute();
    }

    public function delete($user)
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE ID = :ID');
        $stmt->bindValue(':ID', $user->getID());
        $stmt->execute();
    }
}
?>