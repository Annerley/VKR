<?php

if(isset($_FILES['image']))
{
    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.',$_FILES['image']['name'] )));

    $expensions = array("jpeg", "jpg", "png");

    if(empty($errors) == true)
    {
        echo "Success";
        move_uploaded_file($file_tmp, "images/".$file_name);

    }
    else
    {
        echo "Gavno";
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
			<div class = "name">Иван Иванов Иванович</div>
		</div>
		<div>
			<div class ="type left_name">Учебная группа:</div>
			<div class = "name">КМБО-02-19</div>
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
				<input type = "file">
				<br><input type = "button" value = "+еще файл">
			
			</div>
			<div class = "result good">
				<div>Проверено</div>
			</div><div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Текст ВКР:</div>
			<div class = "block "> 
				<input type = "file">
				<br><input type = "button" value = "+еще файл">
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
				<input type = "file">
				<br><input type = "button" value = "+еще файл">
			</div>
			<div class = "result okay ">
				<div>Не проверено</div>
			</div><div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Отзыв руководителя:</div>
			<div class = "block "> 
				<input type = "file">
				<br><input type = "button" value = "+еще файл">
			</div>
			<div class = "result okay">
				<div>Не проверено</div>
			</div><div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Рецензия:</div>
			<div class = "block "> 
				<input type = "file">
				<br><input type = "button" value = "+еще файл">
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