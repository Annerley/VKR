<?php
include 'MySQL.php';
$p = new MySQL;

$student = $p->request_array("SELECT * FROM students WHERE id=".$_GET["id"]);
$group_id = $p->request_array("SELECT * FROM students_to_group WHERE student_id=".$_GET["id"]);

$group_name = $p->request_array("SELECT * FROM groups WHERE id=".$group_id["group_id"]);




function GetNewName($student, $num)
{
    $p = new MySQL;
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
    //echo $q[2];
    //echo "<br>";
    return $result =  $student["id"].$student["middle_name"]."_doc".$num."_".$q[$num]["quantity"];
}

function getExtension ($mime_type,$filename){

    $extensions = array(
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


if(isset($_FILES['image']))
{
    //var_dump($student);
    $res =$p->request_array("SELECT `document3_id` FROM `project` WHERE `student_id`=".$student["id"]);
    //echo "SELECT `document3_id` FROM `project` WHERE `student_id`=".$student["id"];
    //var_dump($res);
    $p->insert("UPDATE `document` SET check_answer='Не проверено' WHERE `id`=".$res["document3_id"]);
    $p->insert("UPDATE `document` SET positive=2 WHERE `id`=".$res["document3_id"]);
    $num = 3;
    foreach($_FILES['image']['name'] as $key => $filename)
    {
        $id = ($_POST['document_id']);
        $file_tmp =$_FILES['image']['tmp_name'][$key];
        $fileNewName = GetNewName($student, $num).".".getExtension(mime_content_type($file_tmp),  $filename);
        //echo $fileNewName;
        $errors = array();
        //echo $filename;
        if(empty($errors) == true)
        {
            // echo sys_get_temp_dir();
            // echo mime_content_type($file_tmp);
            // echo "Success";
            //echo getExtension(mime_content_type($file_tmp),  $filename);

            move_uploaded_file($file_tmp, $VKR.$fileNewName);

        }
        if (empty($p->insert("INSERT INTO `file`(`document_id`, `path`) VALUES ($id,'$fileNewName') ")))
        {
            throw new Exception('Load error');
        }
     //echo "\"INSERT INTO `file`(`document_id`, `path`) VALUES ($id,'$VKR.$fileNewName') \"))";

    }
}
if(isset($_FILES['zadanie']))
{
    $res =$p->request_array("SELECT `document1_id` FROM `project` WHERE `student_id`=".$student["id"]);
    $p->insert("UPDATE `document` SET check_answer='Не проверено' WHERE `id`=".$res["document1_id"]);
    $p->insert("UPDATE `document` SET positive=2 WHERE `id`=".$res["document1_id"]);
    $num = 1;
    foreach($_FILES['zadanie']['name'] as $key => $filename)
    {
        $id = ($_POST['document_id']);
        $file_tmp =$_FILES['zadanie']['tmp_name'][$key];
        $fileNewName = GetNewName($student, $num).".".getExtension(mime_content_type($file_tmp),  $filename);
        //echo $fileNewName;
        //echo $_FILES['text']['name'][$key];
        $errors = array();
        //echo $filename;
        if(empty($errors) == true)
        {
            // echo sys_get_temp_dir();
            // echo mime_content_type($file_tmp);
            // echo "Success";
            //echo getExtension(mime_content_type($file_tmp),  $file_name);

            move_uploaded_file($file_tmp, $VKR.$fileNewName);

        }
        else
        {
            echo "Error";
            print $errors;
        }
        if (empty($p->insert("INSERT INTO `file`(`document_id`, `path`) VALUES ($id,'$fileNewName') ")))
        {
            throw new Exception('Load error');
        }

    }
}

if(isset($_FILES['text']))
{
    $res =$p->request_array("SELECT `document2_id` FROM `project` WHERE `student_id`=".$student["id"]);
    $p->insert("UPDATE `document` SET check_answer='Не проверено' WHERE `id`=".$res["document2_id"]);
    $p->insert("UPDATE `document` SET positive=2 WHERE `id`=".$res["document2_id"]);
    $num = 2;
    foreach($_FILES['text']['name'] as $key => $filename)
    {
        $id = ($_POST['document_id']);
        $file_tmp =$_FILES['text']['tmp_name'][$key];
        $fileNewName = GetNewName($student, $num).".".getExtension(mime_content_type($file_tmp),  $filename);
        //echo $_FILES['text']['name'][$key];
        $errors = array();
        //echo $filename;
        if(empty($errors) == true)
        {
            // echo sys_get_temp_dir();
            // echo mime_content_type($file_tmp);
            // echo "Success";
            //echo getExtension(mime_content_type($file_tmp),  $file_name);

            move_uploaded_file($file_tmp, $VKR.$fileNewName);

        }
        else
        {
            echo "Error";
            print $errors;
        }
        if (empty($p->insert("INSERT INTO `file`(`document_id`, `path`) VALUES ($id,'$fileNewName') ")))
        {
            throw new Exception('Load error');
        }

    }
}

if(isset($_FILES['isxodniki']))
{
    $res =$p->request_array("SELECT `document4_id` FROM `project` WHERE `student_id`=".$student["id"]);
    $p->insert("UPDATE `document` SET check_answer='Не проверено' WHERE `id`=".$res["document4_id"]);
    $p->insert("UPDATE `document` SET positive=2 WHERE `id`=".$res["document4_id"]);
    $num = 4;
    foreach($_FILES['isxodniki']['name'] as $key => $filename)
    {
        $id = ($_POST['document_id']);
        $file_tmp =$_FILES['isxodniki']['tmp_name'][$key];
        $fileNewName = GetNewName($student, $num).".".getExtension(mime_content_type($file_tmp),  $filename);
        //echo $_FILES['text']['name'][$key];
        $errors = array();
        //echo $filename;
        if(empty($errors) == true)
        {
            // echo sys_get_temp_dir();
            // echo mime_content_type($file_tmp);
            // echo "Success";
            //echo getExtension(mime_content_type($file_tmp),  $file_name);

            move_uploaded_file($file_tmp, $VKR.$fileNewName);

        }
        else
        {
            echo "Error";
            print $errors;
        }
        if (empty($p->insert("INSERT INTO `file`(`document_id`, `path`) VALUES ($id,'$fileNewName') ")))
        {
            throw new Exception('Load error');
        }
    }
}

if(isset($_FILES['recenziya']))
{
    $res =$p->request_array("SELECT `document6_id` FROM `project` WHERE `student_id`=".$student["id"]);
    $p->insert("UPDATE `document` SET check_answer='Не проверено' WHERE `id`=".$res["document6_id"]);
    $p->insert("UPDATE `document` SET positive=2 WHERE `id`=".$res["document6_id"]);
    $num = 6;
    foreach($_FILES['recenziya']['name'] as $key => $filename)
    {
        $id = ($_POST['document_id']);
        $file_tmp =$_FILES['recenziya']['tmp_name'][$key];
        $fileNewName = GetNewName($student, $num).".".getExtension(mime_content_type($file_tmp),  $filename);
        //echo $_FILES['text']['name'][$key];
        $errors = array();
        //echo $filename;
        if(empty($errors) == true)
        {
            // echo sys_get_temp_dir();
            // echo mime_content_type($file_tmp);
            // echo "Success";
            //echo getExtension(mime_content_type($file_tmp),  $file_name);

            move_uploaded_file($file_tmp, $VKR.$fileNewName);

        }
        else
        {
            echo "Error";
            print $errors;
        }
        if (empty($p->insert("INSERT INTO `file`(`document_id`, `path`) VALUES ($id,'$fileNewName') ")))
        {
            throw new Exception('Load error');
        }

    }
}

if(isset($_FILES['comment']))
{
    $res =$p->request_array("SELECT `document5_id` FROM `project` WHERE `student_id`=".$student["id"]);
    $p->insert("UPDATE `document` SET check_answer='Не проверено' WHERE `id`=".$res["document5_id"]);
    $p->insert("UPDATE `document` SET positive=2 WHERE `id`=".$res["document5_id"]);
    $num = 5;
    foreach($_FILES['comment']['name'] as $key => $filename)
    {
        $id = ($_POST['document_id']);
        $file_tmp =$_FILES['comment']['tmp_name'][$key];
        $fileNewName = GetNewName($student, $num).".".getExtension(mime_content_type($file_tmp),  $filename);
        //echo $_FILES['text']['name'][$key];
        $errors = array();
        //echo $filename;
        if(empty($errors) == true)
        {
            // echo sys_get_temp_dir();
            // echo mime_content_type($file_tmp);
            // echo "Success";
            //echo getExtension(mime_content_type($file_tmp),  $file_name);

            move_uploaded_file($file_tmp, $VKR.$fileNewName);

        }
        else
        {
            echo "Error";
            print $errors;
        }
        if (empty($p->insert("INSERT INTO `file`(`document_id`, `path`) VALUES ($id,'$fileNewName') ")))
        {
            throw new Exception('Load error');
        }

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
            <div class ="progress2 first">
                <?php
                $doc = $p->request_array("SELECT document1_id,document2_id,document3_id,document4_id,document5_id,document6_id FROM `project` WHERE `student_id`=".$student["id"]);
                //var_dump($doc);

                if(empty($doc))
                {
                    //echo "Документ не существует";
                    ?>
                    <div class = "square"></div>
                    <div class = "square"></div>
                    <div class = "square"></div>
                    <div class = "square"></div>
                    <div class = "square"></div>
                    <div class = "square"></div>
                    <?php
                }
                else {
                    $id_docs = [];
                    foreach ($doc as $docs) {
                        if (empty($id_docs)) {
                            $id_docs = $docs;
                        } else {
                            $id_docs .= ',' . $docs;
                        }


                    }
                    //var_dump($id_docs);
                    $progress = $p->request("SELECT * FROM `document` WHERE `id` IN ($id_docs)");
                    //var_dump($progress);
                    $f=0;
                    for($i = 0; $i < 6; $i++)
                    {
                        //echo $progress[$i]["positive"];

                        if($progress[$i]["positive"] == 0){
                            $f++;
                            ?>
                            <div class = "square on"></div>
                        <?php } else { ?>
                            <div class = "square"></div>
                        <?php }
                    }


                }


                ?>




        </div>
			<div>документы оформляются</div>
		</div>
		<div class = "text">
            <div class ="progress2 second">
                <?php
                if ($f==6){?>
                    <div class = "pr100 on"></div>
                    <?php
                }?>
                <?php //переделать
                if ($f<6){?>
                    <div class = "pr100 "></div>
                <?php }?>

            </div>
			<div>документы собраны</div>
		</div>
		<div class = "text">
            <div class ="progress2 third">
                <?php
                if ($f==6){?>
                    <div class = "pr100 on"></div>
                    <?php
                }?>
                <?php //переделать
                if ($f<6){?>
                    <div class = "pr100 "></div>
                <?php }?>

            </div>
			<div>документы проверены</div>
		</div>
		<div class = "text">
            <div class ="progress2 fourth">
                <?php
                if($student["register"] == 1):?>

                    <div class = "pr100 on space3"></div>
                <?php endif; ?>
                <?php
                if($student["register"] == 0):?>
                    <div class = "pr100 space3"></div>
                <?php endif; ?>
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
                <?php $proj = $p->request_array("SELECT `document1_id` FROM project WHERE student_id =".$student["id"]); ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" multiple name="zadanie[]">
                    <input value = "<?=$proj['document1_id']?>" type="hidden" name ="document_id">
                    <input type = "submit">
                </form>
			</div>
            <?php

            $doc = $p->request_array("SELECT `check_answer`, `positive` FROM document WHERE id = ". $proj["document1_id"]);
            //echo $doc["positive"];
            //echo $doc["check_answer"];
            if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 1): ?>
            <div class = "result bad">
                <div><?=$doc["check_answer"]?></div>
            </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 2): ?>
            <div class = "result okay">
                <div><?=$doc["check_answer"]?></div>
            </div><div class="clear"></div><hr>


            <?php endif ?>


        </div>
		<div >
			<div class = "name left_name" >Текст ВКР:</div>
			<div class = "block ">
                <?php $proj = $p->request_array("SELECT `document2_id` FROM project WHERE student_id =".$student["id"]); ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" multiple name="text[]">
                    <input value = "<?=$proj['document2_id']?>" type="hidden" name ="document_id">
                    <input type = "submit">

                </form>
			</div>
            <?php

            $doc = $p->request_array("SELECT `check_answer`, `positive` FROM document WHERE id = ". $proj["document2_id"]);
            //echo $doc["positive"];
            //echo $doc["check_answer"];
            if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 1): ?>
                <div class = "result bad">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 2): ?>
                <div class = "result okay">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
		</div>
		<div >
			<div class = "name left_name" >Граф. материалы:</div>
			<div class = "block ">
                <?php $proj = $p->request_array("SELECT `document3_id` FROM project WHERE student_id =".$student["id"]); ?>
                <form action="" method="post" enctype="multipart/form-data">
				<input type = "file" multiple name="image[]">
                    <input value = "<?=$proj['document3_id']?>" type="hidden" name ="document_id">
				<input type = "submit">

                </form>
			</div>
            <?php

            $doc = $p->request_array("SELECT `check_answer`, `positive` FROM document WHERE id = ". $proj["document3_id"]);
            //echo $doc["positive"];
            //echo $doc["check_answer"];
            if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 1): ?>
                <div class = "result bad">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 2): ?>
                <div class = "result okay">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
		</div>
		<div >
			<div class = "name left_name" >Исходные тексты и дистрибутив:</div>
			<div class = "block ">
                <?php $proj = $p->request_array("SELECT `document4_id` FROM project WHERE student_id =".$student["id"]); ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" multiple name="isxodniki[]">
                    <input value = "<?=$proj['document4_id']?>" type="hidden" name ="document_id">
                    <input type = "submit">

                </form>
			</div>
            <?php

            $doc = $p->request_array("SELECT `check_answer`, `positive` FROM document WHERE id = ". $proj["document4_id"]);
            //echo $doc["positive"];
            //echo $doc["check_answer"];
            if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 1): ?>
                <div class = "result bad">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 2): ?>
                <div class = "result okay">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
		</div>
		<div >
			<div class = "name left_name" >Отзыв руководителя:</div>
			<div class = "block ">
                <?php $proj = $p->request_array("SELECT `document5_id` FROM project WHERE student_id =".$student["id"]); ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" multiple name="comment[]">
                    <input value = "<?=$proj['document5_id']?>" type="hidden" name ="document_id">
                    <input type = "submit">

                </form>
			</div>
            <?php

            $doc = $p->request_array("SELECT `check_answer`, `positive` FROM document WHERE id = ". $proj["document5_id"]);
            //echo $doc["positive"];
            //echo $doc["check_answer"];
            if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 1): ?>
                <div class = "result bad">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 2): ?>
                <div class = "result okay">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
		</div>
		<div >
			<div class = "name left_name" >Рецензия:</div>
			<div class = "block ">
                <?php $proj = $p->request_array("SELECT `document6_id` FROM project WHERE student_id =".$student["id"]); ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type = "file" multiple name="recenziya[]">
                    <input value = "<?=$proj['document6_id']?>" type="hidden" name ="document_id">
                    <input type = "submit">

                </form>
			</div>
            <?php

            $doc = $p->request_array("SELECT `check_answer`, `positive` FROM document WHERE id = ". $proj["document6_id"]);
            //echo $doc["positive"];
            //echo $doc["check_answer"];
            if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 1): ?>
                <div class = "result bad">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
            <?php if($doc["positive"] == 2): ?>
                <div class = "result okay">
                    <div><?=$doc["check_answer"]?></div>
                </div><div class="clear"></div><hr>


            <?php endif ?>
		</div>
		
	</div>
	
	
	<div class = "button">
		<button class = "center">Запись на предзащиту >></button>
	</div>
  </div>
 
 </body>
</html>