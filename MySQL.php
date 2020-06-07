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
        //echo $str;
        $sql = $str;   // table documents and output
        $result = mysqli_query($this->conn, $sql);
        if($result === FALSE)
        {
            //throw new exception("db error");
            //print_r($result);
            return NULL;
        }
        $result=mysqli_insert_id($this->conn);
        return $result;
    }

    public function deletion($str)
    {
        //echo $str;
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

    public function create_oper($id, $type) //1-insert 2-deletion
    {
        if($type==1)
        {
            $this->insert("INSERT INTO `operation`(`oper_type`, `file_id`) VALUES($type, $id)");
        }
        if($type==2)
        {
            $this->deletion("INSERT INTO `operation`(`oper_type`, `file_id`) VALUES($type, $id)");
        }
    }

}
?>



