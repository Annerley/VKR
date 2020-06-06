<?php
include 'MySQL.php';


$p = new MySQL();
if(!empty($_POST["mark_bad"]))
{
    if(!empty($p->request(" SELECT `id` FROM `document` WHERE `id`=".$_POST["doc_id"])))
    {
        $p->insert("UPDATE `document` SET `check_answer`='".$_POST["text"]."' WHERE `id`=".$_POST["doc_id"]);
        //echo "UPDATE `document` SET `check_answer`=".$_POST["text"]." WHERE `id`=".$_POST["doc_id"];
        $p->insert("UPDATE `document` SET `positive`=1"." WHERE `id`=".$_POST["doc_id"]);
        //echo"<br>";
        //echo "UPDATE `document` SET `positive`=1"." WHERE `id`=".$_POST["doc_id"];
    }
    else
        echo "DB Error";
}
else
{
    $p->insert("UPDATE `document` SET `check_answer`='Проверено' WHERE `id`=".$_POST["doc_id"]);
    //echo "UPDATE `document` SET `check_answer`='Проверено' WHERE `id`=".$_POST["doc_id"];
    $p->insert("UPDATE `document` SET `positive`= 0"." WHERE `id`=".$_POST["doc_id"]);
}
   // INSERT INTO `file`(`document_id`, `path`) VALUES ($id,'$fileNewName')
header("Location:".$_SERVER["HTTP_REFERER"]);
?>