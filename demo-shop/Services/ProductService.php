<?php

class ProductService 
{
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=bensshop', 'ben', '3zHlv3&5');
    }

    public function getAll()
    {
        $products = array();
        foreach ($this->db->query('SELECT * FROM products') as $row) {
           
            array_push($products, $this->parseRow($row));
        }
        return $products;
    }

    public function getByCatagory($catagory) 
    {        
        $products = array();
        $stmt = $this->db->prepare('SELECT * FROM products WHERE CatagoryID = :CatagoryID');
        $stmt->bindValue(':CatagoryID', $catagory == null ? null : $catagory->getID());
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                array_push($products, $this->parseRow($row));
            }
        }
        return $products;
    }

    public function getByCatagoryRecursive($catagory)
    {
        if ($catagory == null) {
            return array();
        }
        $catagoryService = new CatagoryService();
        $products = array();
        foreach ($this->getByCatagory($catagory) as $product)
        {
            array_push($products, $product);
        }
        foreach ($catagoryService->getByParent($catagory) as $tempCatagory)
        {
            foreach ($this->getByCatagoryRecursive($tempCatagory) as $product)
            {
                array_push($products, $product);
            }
        }
        return $products;
    }

    public function getByID($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE ID = :ID');
        $stmt->bindParam(':ID', $id);
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
               return $this->parseRow($row);
            }
        }
    }

    function parseRow($row) 
    {
        $product = new Product();
        $product->setID($row["ID"]);
        $product->setNumber($row['Number']);
        $product->setDescription($row['Description']);
        $product->setImgName($row['Img_Name']);
        $product->setCatagoryID($row['CatagoryID']);
        return $product;
    }

    public function create($product)
    {
        $stmt = $this->db->prepare('INSERT INTO products (Number) VALUES (:Number)');
        $stmt->bindValue(':Number', $product->getNumber());
        $stmt->execute();
    }

    public function update($product)
    {
        $stmt = $this->db->prepare('UPDATE products SET Number = :Number, Description = :Description, Img_Name = :imgName, CatagoryID = :CatagoryID WHERE ID = :ID;');
        $stmt->bindValue(':Number', $product->getNumber());
        $stmt->bindValue(':ID', $product->getID());
        $stmt->bindValue(':Description', $product->getDescription());
        $stmt->bindValue(':CatagoryID', $product->getCatagoryID());
        $stmt->bindValue(':imgName', $product->getImgName());
        $stmt->execute();
    }

    public function assignAttribute($product, $attributeValue)
    {
        $stmt = $this->db->prepare('INSERT INTO products_attributevalues (ProductID, AttributeValueID) VALUES (:productID, :attributeValueID)');
        $stmt->bindValue(':productID', $product->getID());
        $stmt->bindValue(':attributeValueID', $attributeValue->getID());
        $stmt->execute();
    }

    public function unassignAttribute($product, $attributeValue)
    {
        $stmt = $this->db->prepare('DELETE FROM products_attributevalues WHERE ProductID = :ProductID AND AttributeValueID = :ValueID');
        $stmt->bindValue(':ProductID', $product->getID());
        $stmt->bindValue(':ValueID', $attributeValue->getID());
        $stmt->execute();
    }
   

}