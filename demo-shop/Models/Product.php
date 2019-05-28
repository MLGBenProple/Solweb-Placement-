<?php

class Product
{
    private $id;
    private $number;
    private $description;
    private $catagoryID;

public function getID()
{
    return $this->id;
}
public function setID($value)
{
    $this->id = $value;
}

    public function getNumber()
    {
        return $this->number;
    }
    public function setNumber($value)
    {
        $this->number = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getImgName()
    {
        return $this->imgName;
    }
    public function setImgName($value)
    {
        $this->imgName = $value;
    }

    public function getCatagoryID()
    {
        return $this->catagoryID;
    }
    public function setCatagoryID($value)
    {
        $this->catagoryID = $value;
    }
}