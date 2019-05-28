<?php

class AttributeValue
{
    private $id;
    private $name;
    private $parentID;

    public function getID()
    {
        return $this->id;
    }
    public function setID($value)
    {
        $this->id = $value;
    }

    public function getValue()
    {
        return $this->name;
    }
    public function setValue($value)
    {
        $this->name = $value;
    }

    public function getParentID()
    {
        return $this->parentID;
    }
    public function setParentID($value)
    {
        $this->parentID = $value;
    }
}