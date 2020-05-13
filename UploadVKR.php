<?php
include 'MySQL.php';
$p = new MySQL;

$student = $p->request_array("SELECT * FROM students WHERE id=".$_GET["id"]);
$group_id = $p->request_array("SELECT * FROM students_to_group WHERE student_id=".$_GET["id"]);

$group_name = $p->request_array("SELECT * FROM groups WHERE id=".$group_id["group_id"]);

$l[1] = $p->request_array("SELECT `document1_id` FROM `project` WHERE student_id=".$_GET["id"]);
$l[2] = $p->request_array("SELECT `document2_id` FROM `project` WHERE student_id=".$_GET["id"]);
$l[3] = $p->request_array("SELECT `document3_id` FROM `project` WHERE student_id=".$_GET["id"]);
$l[4] = $p->request_array("SELECT `document4_id` FROM `project` WHERE student_id=".$_GET["id"]);
$l[5] = $p->request_array("SELECT `document5_id` FROM `project` WHERE student_id=".$_GET["id"]);
$l[6] = $p->request_array("SELECT `document6_id` FROM `project` WHERE student_id=".$_GET["id"]);

$q[1] = $p->request_array("SELECT COUNT(*) as quantity FROM file WHERE document_id =".$l[1]["document1_id"]);
$q[2] = $p->request_array("SELECT COUNT(*) as quantity FROM file WHERE document_id =".$l[2]["document2_id"]);
$q[3] = $p->request_array("SELECT COUNT(*) as quantity FROM file WHERE document_id =".$l[3]["document3_id"]);
$q[4] = $p->request_array("SELECT COUNT(*) as quantity FROM file WHERE document_id =".$l[4]["document4_id"]);
$q[5] = $p->request_array("SELECT COUNT(*) as quantity FROM file WHERE document_id =".$l[5]["document5_id"]);
$q[6] = $p->request_array("SELECT COUNT(*) as quantity FROM file WHERE document_id =".$l[6]["document6_id"]);
//echo $q[1]["quantity"];

function GetNewName($student, $num, $q)
{
    return $result =  $student["id"].$student["middle_name"]."_doc".$num."_".$q[$num]["quantity"];
}

function getExtension ($mime_type,$filename){

    $extensions = array('image/jpeg' => 'jpeg',
        'text/xml' => 'xml',
        'image/bmp'                                                                 => 'bmp',
        'image/x-bmp'                                                               => 'bmp',
        'image/x-bitmap'                                                            => 'bmp',
        'image/x-xbitmap'                                                           => 'bmp',
        'image/x-win-bitmap'                                                        => 'bmp',
        'image/x-windows-bmp'                                                       => 'bmp',
        'image/ms-bmp'                                                              => 'bmp',
        'image/x-ms-bmp'                                                            => 'bmp',
        'image/jpx'                                                                 => 'jp2',
        'image/jpm'                                                                 => 'jp2',
        'image/jpeg'                                                                => 'jpeg',
        'image/pjpeg'                                                               => 'jpeg',
        'application/x-javascript'                                                  => 'js',
        'application/json'                                                          => 'json',
        'text/json'                                                                 => 'json',
        'application/pdf'                                                           => 'pdf',
        'application/octet-stream'                                                  => 'pdf',
        'application/x-rar'                                                         => 'rar',
        'application/rar'                                                           => 'rar',
        'application/x-rar-compressed'                                              => 'rar',
        'application/x-tar'                                                         => 'tar',
        'application/x-gzip-compressed'                                             => 'tgz',
        'image/tiff'                                                                => 'tiff',
        'font/ttf'                                                                  => 'ttf',
        'text/plain'                                                                => 'txt',
        'video/x-ms-asf'                                                            => 'wmv',
        'application/xhtml+xml'                                                     => 'xhtml',
        'application/excel'                                                         => 'xl',
        'application/msexcel'                                                       => 'xls',
        'application/x-msexcel'                                                     => 'xls',
        'application/x-ms-excel'                                                    => 'xls',
        'application/x-excel'                                                       => 'xls',
        'application/x-dos_ms_excel'                                                => 'xls',
        'application/xls'                                                           => 'xls',
        'application/x-xls'                                                         => 'xls',
        'application/xml'                                                           => 'xml',
        'text/xml'                                                                  => 'xml',
        'text/xsl'                                                                  => 'xsl',
        'application/xspf+xml'                                                      => 'xspf',
        'application/x-compress'                                                    => 'z',
        'application/x-zip'                                                         => 'zip',
        'application/zip'                                                           => 'zip',
        'application/x-zip-compressed'                                              => 'zip',
        'application/s-compressed'                                                  => 'zip',
        'multipart/x-zip'                                                           => 'zip',
        'text/x-scriptzsh'                                                          => 'zsh',
       /* 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
        'application/x-empty'                                                       => 'docx',
        'application/msword'                                                        => 'doc',
       */
    );
    if (empty($extensions[$mime_type]))
    {
        if (preg_match('/\.([^$]*)/imsu',$filename,$res))
        {
            $ext = $res[1];
          //  print_r($res);
        }
    }
    else
    {
        $ext = $extensions[$mime_type];
    }

    return $ext;
}

$VKR = "VKR/";
$file_name2 = 'HUI';
if(isset($_FILES['image']))
{
    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    //$file_ext = strtolower(end(explode('.',$_FILES['image']['type'] )));
    $num = 3;
    $fileNewName = GetNewName($student, $num, $q);

    echo $fileNewName;
    if(empty($errors) == true)
    {
        // echo sys_get_temp_dir();
        // echo mime_content_type($file_tmp);
        // echo "Success";
        //echo getExtension(mime_content_type($file_tmp),  $file_name);

        move_uploaded_file($file_tmp, $VKR.$fileNewName.".".getExtension(mime_content_type($file_tmp),  $file_name));

    }
    else
    {
        echo "Error";
        print $errors;
    }
}
if(isset($_FILES['zadanie']))
{
    $errors = array();
    $file_name = $_FILES['zadanie']['name'];
    $file_size = $_FILES['zadanie']['size'];
    $file_tmp = $_FILES['zadanie']['tmp_name'];
    $file_type = $_FILES['zadanie']['type'];
    $num = 1;
    $fileNewName = GetNewName($student, $num, $q);

    echo $fileNewName;
    if(empty($errors) == true)
    {
        // echo sys_get_temp_dir();
        // echo mime_content_type($file_tmp);
        // echo "Success";
        //echo getExtension(mime_content_type($file_tmp),  $file_name);

        move_uploaded_file($file_tmp, $VKR.$fileNewName.".".getExtension(mime_content_type($file_tmp),  $file_name));

    }
    else
    {
        echo "Error";
        print $errors;
    }
}

if(isset($_FILES['text']))
{
    $errors = array();
    $file_name = $_FILES['text']['name'];
    $file_size = $_FILES['text']['size'];
    $file_tmp = $_FILES['text']['tmp_name'];
    $file_type = $_FILES['text']['type'];
    $num = 2;
    $fileNewName = GetNewName($student, $num, $q);

    echo $fileNewName;
    if(empty($errors) == true)
    {
        // echo sys_get_temp_dir();
        // echo mime_content_type($file_tmp);
        // echo "Success";
        //echo getExtension(mime_content_type($file_tmp),  $file_name);

        move_uploaded_file($file_tmp, $VKR.$fileNewName.".".getExtension(mime_content_type($file_tmp),  $file_name));

    }
    else
    {
        echo "Error";
        print $errors;
    }
}

if(isset($_FILES['isxodniki']))
{
    $errors = array();
    $file_name = $_FILES['isxodniki']['name'];
    $file_size = $_FILES['isxodniki']['size'];
    $file_tmp = $_FILES['isxodniki']['tmp_name'];
    $file_type = $_FILES['isxodniki']['type'];
    $num = 4;
    $fileNewName = GetNewName($student, $num, $q);

    echo $fileNewName;
    if(empty($errors) == true)
    {
        // echo sys_get_temp_dir();
        // echo mime_content_type($file_tmp);
        // echo "Success";
        //echo getExtension(mime_content_type($file_tmp),  $file_name);

        move_uploaded_file($file_tmp, $VKR.$fileNewName.".".getExtension(mime_content_type($file_tmp),  $file_name));

    }
    else
    {
        echo "Error";
        print $errors;
    }
}

if(isset($_FILES['recenziya']))
{
    $errors = array();
    $file_name = $_FILES['recenziya']['name'];
    $file_size = $_FILES['recenziya']['size'];
    $file_tmp = $_FILES['recenziya']['tmp_name'];
    $file_type = $_FILES['recenziya']['type'];
    $num = 6;
    $fileNewName = GetNewName($student, $num, $q);

    echo $fileNewName;
    if(empty($errors) == true)
    {
        // echo sys_get_temp_dir();
        // echo mime_content_type($file_tmp);
        // echo "Success";
        //echo getExtension(mime_content_type($file_tmp),  $file_name);

        move_uploaded_file($file_tmp, $VKR.$fileNewName.".".getExtension(mime_content_type($file_tmp),  $file_name));

    }
    else
    {
        echo "Error";
        print $errors;
    }
}

if(isset($_FILES['comment']))
{
    $errors = array();
    $file_name = $_FILES['comment']['name'];
    $file_size = $_FILES['comment']['size'];
    $file_tmp = $_FILES['comment']['tmp_name'];
    $file_type = $_FILES['comment']['type'];
    $num = 5;
    $fileNewName = GetNewName($student, $num, $q);

    echo $fileNewName;
    if(empty($errors) == true)
    {
        // echo sys_get_temp_dir();
        // echo mime_content_type($file_tmp);
        // echo "Success";
        //echo getExtension(mime_content_type($file_tmp),  $file_name);

        move_uploaded_file($file_tmp, $VKR.$fileNewName.".".getExtension(mime_content_type($file_tmp),  $file_name));

    }
    else
    {
        echo "Error";
        print $errors;
    }
}

?>


<!DOCTYPE HTML PUBLIC >
<html>
 <head>
  <link rel="stylesheet" href="UploadVKR_style.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title></title>
 </head>
 <body>
  <div class = "wrapper"> 
	<h2 class="">Выпускная квалификационная работа</h2> 
	<div class="load_block">
		<div>
			<div class ="type left_name">Студент:</div>
			<div class = "name"><?=$student["first_name"]?> <?=$student["middle_name"]?> <?=$student["last_name"]?></div>
		</div>
		<div>
			<div class ="type left_name">Учебная группа:</div>
			<div class = "name"><?=$group_name["name"]?></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class = "state">
		<div class="left_name">Cостояние:</div>
		<div class = "text"> 
			<div class ="progress2 40pr first">

				<div class = "square"></div>
				<div class = "square"></div>
				<div class = "square"></div>
				<div class = "square"></div>
				<div class = "square"></div>
				<div class = "square"></div>
		
			</div>
			<div>документы оформляются</div>
		</div>
		<div class = "text"> 
			<div class ="progress2 second">
			<div class = "pr100"></div>
		
			</div>
			<div>документы собраны</div>
		</div>
		<div class = "text"> 
			<div class ="progress2 third">
			<div class = "pr100 space2"></div>
		
			</div>
			<div>документы проверены</div>
		</div>
		<div class = "text"> 
			<div class ="progress2 fourth">
			<div class = "pr100 space3"></div>
		
			</div>
			<div>предзащита пройдена</div>
		</div>
	</div>
	
	<div class="clear"></div>
	
	<div class="files">
			<div class ="name ">Документы:</div>
			<div class = "label">Результаты проверки:</div>
			
	</div>
	<div class = "clear"></div><hr>
	<div class = "add_files">
		<div >
			<div class = "name left_name" >Задание на ВКР:</div>
			<div class = "block ">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" name="zadanie">
                    <input type = "submit">
                    <br><input type = "button" value = "+еще файл">
                </form>
			</div>
			<div class = "result good">
				<div>Проверено</div>
			</div><div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Текст ВКР:</div>
			<div class = "block ">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" name="text">
                    <input type = "submit">
                    <br><input type = "button" value = "+еще файл">
                </form>
			</div>
			<div class = "result bad">
				<div>Нет отметки о согласовании с руководителем ВКР</div>
			</div><div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Граф. материалы:</div>
			<div class = "block ">
                <form action="" method="post" enctype="multipart/form-data">
				<input type = "file" name="image">
				<input type = "submit">
				<br><input type = "button" value = "+еще файл">
                </form>
			</div>
			<div class = "result okay">
				<div>Не проверено</div>
			</div><div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Исходные тексты и дистрибутив:</div>
			<div class = "block ">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" name="isxodniki">
                    <input type = "submit">
                    <br><input type = "button" value = "+еще файл">
                </form>
			</div>
			<div class = "result okay ">
				<div>Не проверено</div>
			</div><div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Отзыв руководителя:</div>
			<div class = "block ">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" name="comment">
                    <input type = "submit">
                    <br><input type = "button" value = "+еще файл">
                </form>
			</div>
			<div class = "result okay">
				<div>Не проверено</div>
			</div><div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Рецензия:</div>
			<div class = "block ">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" name="recenziya">
                    <input type = "submit">
                    <br><input type = "button" value = "+еще файл">
                </form>
			</div>
			<div class = "result okay">
				<div>Не проверено</div>
			</div><div class="clear"></div><hr>
		</div>
		
	</div>
	
	
	<div class = "button">
		<button class = "center">Запись на предзащиту >></button>
	</div>
  </div>
 
 </body>
</html>