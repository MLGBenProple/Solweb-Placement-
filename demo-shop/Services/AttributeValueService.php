<?php

class AttributeValueService // create a class 
{
    private $db; // make the $db variable private

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=bensshop', 'ben', '3zHlv3&5'); //set the db variable to the database connection
    }

    public function getAll()
    {
        $attributeValues = array(); //create an array called attributeValues
        foreach ($this->db->query('SELECT * FROM attributevalue') as $row) {  //select everything from the attributevalue table in the database and put it in a variable then do the following for each...

            array_push($attributeValues, $this->parseRow($row)); // fill the attributeValues array with each parsed row
        }
        return $attributeValues; //return the array
    }

    public function getByID($id)
    {

        $stmt = $this->db->prepare('SELECT * FROM attributevalue WHERE ID = :ID'); //select everything from the attributevalue table in the database where the ID = the value of the :ID peramiter
        $stmt->bindParam(':ID', $id); //set the value of the :ID peramiter to the value of the $id variable passed into the method
        if ($stmt->execute()) { // if the execute method is successful do the following..
            while ($row = $stmt->fetch()) { // go through every result of the query and create a row variable

                return $this->parseRow($row); // return the parsed row
            }
        }
    }

    private function parseRow($row)
    {
        $attributevalue = new AttributeValue(); // create a new instance of the attribute value model
        $attributevalue->setID($row["ID"]); // set the id value to the row variable's id value
        $attributevalue->setValue($row['Value']); // set the value to the row variable's value
        return $attributevalue; //return the attribute value
    }

    public function getByParent($attribute)
    {
        $values = array(); // create an array called values
        $stmt = $this->db->prepare('SELECT * FROM attributevalue WHERE Parent_ID = :Parent_ID'); // select everything from the attributevalue table in the database where the parent ID = the ID of the passed attribute
        $stmt->bindValue(':Parent_ID', $attribute->getID()); //set the parent ID peramiter to the ID the passed attribute
        if ($stmt->execute()) { // if the execute method is successful do the following..
            while ($row = $stmt->fetch()) { // go through every result of the query and create a row variable
                array_push($values, $this->parseRow($row)); //fill the values array with the parsed row
            }
        }
        return $values; // return the values array
    }

    public function getByAttributeAndProduct($attribute, $product)
    {
        $values = array(); 
        $stmt = $this->db->prepare('SELECT *
                                    FROM attributevalue
                                    WHERE EXISTS (SELECT 1
			                                      FROM products_attributevalues
                                                  WHERE products_attributevalues.AttributeValueID = attributevalue.ID
                                                  AND products_attributevalues.ProductID = :ProductID)
                                    AND attributevalue.Parent_ID = :AttributeID'); // select attribute values where there is an association between the passed attribute value ID and the passed product ID in the 'products_attributevalues' table
        $stmt->bindValue(':ProductID', $product->getID()); // set the value to the :ProductID peramiter to the ID of the passed product
        $stmt->bindValue(':AttributeID', $attribute->getID()); // set the value to the :AttributeID peramiter to the ID of the passed attribute
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                array_push($values, $this->parseRow($row));
            }
        }
        return $values;
    }

    public function create($attributeValue)
    {
        $stmt = $this->db->prepare('INSERT INTO attributevalue (Value, Parent_ID) VALUES (:Value, :ParentID)'); // insert an attribute value and parent ID into the attributevalue table
        $stmt->bindValue(':Value', $attributeValue->getValue()); // set the value to the :Value peramiter to the value of the passed attribute value
        $stmt->bindValue(':ParentID', $attributeValue->getParentID()); // set the value to the :ParentID peramiter to the ID of the passed attribute value
        $stmt->execute(); //run the statment
    }

    public function update($attributeValue)
    {
        $stmt = $this->db->prepare('UPDATE attributevalue SET Value = :Value WHERE (ID = :ID);'); // update the attribute value name in the attributevalue table where the Id = the passed attributevalue ID
        $stmt->bindValue(':Value', $attributeValue->getValue()); // set the value of the :Value permaiter to the value of the passed attributeValue
        $stmt->bindValue(':ID', $attributeValue->getID()); // set the value of the :ID permaiter to the ID of the passed attribute value
        $stmt->execute();
    }
    public function delete($attributeValue)
    {
        $stmt = $this->db->prepare('DELETE FROM attributevalue WHERE ID = :ID'); // delete from the attributevalue table everything where the ID = the ID of the passed attribute value
        $stmt->bindValue(':ID', $attributeValue->getID()); //set the value of the :ID peramiter to the ID of the pased attribute Value
        $stmt->execute(); // run the statment
    }
}
