<?php

class CatagoryService // create a class 
{
    private $db; // make the $db variable private

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=bensshop', 'ben', '3zHlv3&5'); //set the db variable to the database connection
    }

    function parseRow($row) 
    {
        $catagory = new Catagory(); // create a new instance of the catagory model
        $catagory->setID($row["ID"]); // set the id value to the row variable's id value
        $catagory->setName($row['Name']); // set the name value to the row variable's name value
        $catagory->setParentID($row['Parent']); // set the Parent ID value to the row variable's Parent ID value
        return $catagory; //return the catagory
    }

    public function getAll()
    {
        $catagories = array(); //create an array called catagories
        foreach ($this->db->query('SELECT * FROM catagories') as $row) { //select everything from the catagories table in the database and put it in a variable then do the following for each...
            array_push($catagories, $this->parseRow($row)); // fill the catagories array with each parsed row
        }
        return $catagories; //return the array
    }

    public function getByParent($category)
    {
        $catagories = array(); //create an array called catagories
        $stmt = $this->db->prepare('SELECT * FROM catagories WHERE (Parent IS NULL AND :ParentID IS NULL) OR  Parent = :ParentID'); //select everything from the catagories table in the database where the Parent ID = the id of the passed catagory or null.
        $stmt->bindValue(':ParentID', $category == null ? null : $category->getID()); //set the value of the :productID permaiter to null if there is no passed data oterwise set the value to the ID of the passed catagory
        if ($stmt->execute()) { //if the statment excecutes successfully do the following..
            while ($row = $stmt->fetch()) { // go through every result of the query and create a row variable
                array_push($catagories, $this->parseRow($row));// fill the catagories array with the parsed rows
            }
        }
        return $catagories; // return the array
    }

    public function getByID($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM catagories WHERE ID = :ID'); //select everything from the catagories table in the database where the ID = the value of the :ID peramiter
        $stmt->bindParam(':ID', $id); //set the value of the :ID permaiter to the value of the passed ID
        if ($stmt->execute()) { //if the statment excecutes successfully do the following..
            while ($row = $stmt->fetch()) { // go through every result of the query and create a row variable
                return $this->parseRow($row); // return the parsed row
            }
        }
    }

    public function create($catagory)
    {
        $stmt = $this->db->prepare('INSERT INTO catagories (Name) VALUES (:Name)'); // insert a catagory name into the catagory table
        $stmt->bindValue(':Name', $catagory->getName()); // set the :Name permaiter to the name of the passed catagory
        $stmt->execute(); // run the statment
    }

    public function update($catagory)
    {
        $stmt = $this->db->prepare('UPDATE catagories SET Name = :Name, Parent = :Parent WHERE ID = :ID;'); // update the catagory name and parent in the catagories table where the Id = the passed catagory ID 
        $stmt->bindValue(':Name', $catagory->getName()); // set the value of the :Name permaiter to the name of the passed catagory
        $stmt->bindValue(':ID', $catagory->getID()); // set the value of the :ID permaiter to the ID of the passed catagory
        $stmt->bindValue(':Parent', $catagory->getParentID()); // set the value of the :Parent permaiter to the parent ID of the passed catagory
        $stmt->execute(); // run the statment
    }
    public function delete($catagory)
    {
        $stmt = $this->db->prepare('DELETE FROM catagories WHERE ID = :ID'); // delete from the catagories table everything where the ID = the ID of the passed catagory
        $stmt->bindValue(':ID', $catagory->getID()); //set the value of the :ID peramiter to the ID of the pased catagory
        $stmt->execute(); // run the statment
    }
}