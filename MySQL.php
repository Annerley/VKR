<?php
class MySQL
{
    private $db = [
        "servername" => "localhost",
        "username" => "root",
        "password" => "",
        "database" => "vkr",
        ];
    public $conn;
    function __construct()
    {
        $this->conn = new mysqli($this->db["servername"],$this->db["username"], $this->db["password"], $this->db["database"]);
    }

    function __destruct()
    {
        mysqli_close($this->conn);
    }

    public function request($str)
    {
        $sql = $str;   // table documents and output
        $result = mysqli_query($this->conn, $sql);
        if($result === FALSE)
        {
            throw new exception("db error");
        }
        $documents = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $documents;
    }

    public function request_array($str)
    {
        $sql = $str;   // table documents and output
        $result = mysqli_query($this->conn, $sql);
        if($result === FALSE)
        {
            //throw new exception("db error");
            //print_r($result);
            return NULL;
        }
        $documents = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $documents;
    }
    public function insert($str)
    {
        echo $str;
        $sql = $str;   // table documents and output
        $result = mysqli_query($this->conn, $sql);
        if($result === FALSE)
        {
            //throw new exception("db error");
            //print_r($result);
            return NULL;
        }
        return TRUE;
    }
}
?>



