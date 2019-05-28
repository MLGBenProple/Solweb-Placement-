<?php

class Attribute
{
    private $id;
    private $name;
    private $values;

    public function getID()
    {
        return $this->id;
    }
    public function setID($value)
    {
        $this->id = $value;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($value)
    {
        $this->name = $value;
    }

    public function getValues()
    {
        return $this->values;
    }
    public function setValues($value)
    {
        $this->values = $value;
    }

  
}