<?php

class Database 
{
    protected $db;

    public function __construct(string $host, string $user,string $pass,string $dbname, int $port)
    {
        $this->db = new mysqli($host, $user, $pass, $dbname, $port);

        if($this->db->connect_errno) {
            throw new Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        } 
    }

    public function query(string $sql)
    {
        $result = $this->db->query($sql);

        if(!$result ) {
            throw new Exception("Database Error: {$this->db->error}");
        }
        return $result;
    }
}