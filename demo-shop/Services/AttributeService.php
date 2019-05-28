<?php

class AttributeService // create a class
{
    private $db; // make the $db variable private

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=bensshop', 'ben', '3zHlv3&5'); //set the db variable to the database connection
    }

    
    public function getAll()
    {
        $attributes = array(); //create an array called attributes
        foreach ($this->db->query('SELECT * FROM attributes') as $row) { //select everything from the attributes table in the database and put it in a variable then do the following for each...

            array_push($attributes, $this->parseRow($row)); // fill the attributes array with each parsed row
        }
        return $attributes; //return the array
    }

    public function getByID($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM attributes WHERE ID = :ID'); //select everything from the attributes table in the database where the ID = the value of the :ID peramiter
        $stmt->bindParam(':ID', $id); //set the value of the :ID peramiter to the value of the $id variable passed into the method
        if ($stmt->execute()) { // if the execute method is successful do the following..
            while ($row = $stmt->fetch()) { // go through every result of the query and create a row variable
                return $this->parseRow($row); // return the parsed row
            }
        }
    }

    private function parseRow($row)
    {
        $attribute = new Attribute(); // create a new instance of the attribute model
        $attribute->setID($row["ID"]); // set the id value to the row variable's id value
        $attribute->setName($row['Name']); // set the name value to the row variable's name value
        return $attribute; //return the attribute
    }

    public function getByProduct($product)
    {
        $attributes = array(); // create an array called attributes
        $stmt = $this->db->prepare('SELECT *
                                    FROM bensshop.attributes
                                    WHERE EXISTS (SELECT 1
                                                  FROM attributevalue
                                                  INNER JOIN products_attributevalues ON attributevalue.ID = products_attributevalues.AttributeValueID
                                                  WHERE attributevalue.Parent_ID = attributes.ID
                                                  AND products_attributevalues.ProductID = :ProductID)
                                    '); // select attributes where there is an association between an attribute value ID and the passed product ID in the 'products_attributevalues' table
        $stmt->bindValue(':ProductID', $product == null ? null : $product->getID()); //set the value of the :productID permaiter to null if there is no passed data oterwise set the value to the ID of the passed product
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                array_push($attributes, $this->parseRow($row));
            }
        }
        return $attributes;
    }

    public function create($attribute)
    {
        $stmt = $this->db->prepare('INSERT INTO attributes (Name) VALUES (:Name)'); // insert an attribute name into the attributes table
        $stmt->bindValue(':Name', $attribute->getName()); // set the :Name permaiter to the name of the passed attribute
        $stmt->execute(); // run the statment
    }

    public function update($attribute)
    {
        $stmt = $this->db->prepare('UPDATE attributes SET Name = :Name WHERE (ID = :ID);'); // update the attribute name in the attributes table where the Id = the passed attribute ID 
        $stmt->bindValue(':Name', $attribute->getName()); // set the value of the :Name permaiter to the name of the passed attribute
        $stmt->bindValue(':ID', $attribute->getID()); // set the value of the :ID permaiter to the ID of the passed attribute
        $stmt->execute(); //run the statment
    }
}
