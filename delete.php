<?php
include 'MySQL.php';
$filename = $_GET["path"];
unlink($filename);
$id=$_GET["id"];
$p = new MySQL();
$p->deletion("DELETE FROM `file` WHERE `id`=".$id);
//echo "DELETE FROM `file` WHERE `id`=".$id;
$p->create_oper($id, 2);
header('Location:'.$_SERVER["HTTP_REFERER"]);
?>