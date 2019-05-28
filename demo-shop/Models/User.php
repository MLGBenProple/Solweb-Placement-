<?php

class User
{
    private $id;
    private $username;
    private $password;
    Private $isAdmin;

    public function getID()
    {
        return $this->id;
    }
    public function setID($value)
    {
        $this->id = $value;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($value)
    {
        $this->username = $value;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($value)
    {
        $this->password = $value;
    }
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
    public function setIsAdmin($value)
    {
        $this->isAdmin = $value;
    }
}