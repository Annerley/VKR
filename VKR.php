<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "vkr";
/*try 
{
	$conn =  new PDO("mysql:host=$servername; dbname=vkr", $username, $password);
	echo "Connection succesfull";
}
catch(PDOException $e)
{
	echo "Connection failed: ".$e -> getMessage(); //another type of connect
}
*/
$conn = new mysqli($servername, $username, $password, $database);
if($conn -> connect_error)
{
	die("Connection failed:" .$conn->connect_error);
}
echo "Connection succesfull";

/*echo "<br>";
foreach($documents as $doc)
{
    echo $doc["id"];
    echo " ";
    echo $doc["doc_type"];
    echo " ";
    echo $doc["project_id"];
    echo "<br>";
}

*/
/*$sql = "INSERT INTO document (doc_type, project_id, check_answer, positive)
		VALUES('1','2','NICETRY','1')"	;

if($conn -> query($sql) === TRUE)
{
	echo "Record created";
}

*/ // insert in db
$sql = "SELECT * FROM document";   // table documents and output
$result = mysqli_query($conn, $sql);
$documents = mysqli_fetch_all($result, MYSQLI_ASSOC);


$allstudents = "SELECT * FROM students";   // table students
$result = mysqli_query($conn, $allstudents);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC); //из таблицы студентов


$allgroup = "SELECT * FROM groups";   // table group and output
$result = mysqli_query($conn, $allgroup);
$groups = mysqli_fetch_all($result, MYSQLI_ASSOC);

$allproject = "SELECT * FROM project";   // table project
$result = mysqli_query($conn, $allproject);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);


/*?>

<?php
$allstudents = "SELECT * FROM students";   // table group and output
$result = mysqli_query($conn, $allstudents);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo "<br>";
foreach($students as $student)
{
echo $student["first_name"];
echo " ";
echo $student["middle_name"];
echo "<br>";
}
*/
?>
<?php



?>

<!DOCTYPE HTML PUBLIC >
<html>
 <head>
  <link rel="stylesheet" href="VKR_style.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <title></title>
 </head>
 <body>
  
  <div class = "wrapper"> 
	<h2 class="">Выпускные квалификационные работы</h2>
      <?php foreach ($groups as $group): ?>
      <div class = "load_block">
          <div>
              <div class ="type left_name">Группа</div>
              <div class = "name"><?php echo $group["name"]; ?> </div>
              <div class = "clear"></div>
              <br>
          </div>
          <div class = "block">
              <div class = "name2"></div>
              <div class = "name2">документы оформляются</div>
              <div class = "name2">документы собраны</div>
              <div class = "name2">документы проверены</div>
              <div class = "name2">предзащита пройдена</div>
              <div class = "name2">записан на защиту</div>
          </div>

         <?php $sttogrp = "SELECT * FROM students_to_group WHERE group_id=$group[id]";
          $result = mysqli_query($conn, $sttogrp);
          $student = mysqli_fetch_all($result, MYSQLI_ASSOC); // из таблицы связей?>
          <?php  foreach ($student as $studentid): ?>
          <?php  $id = $studentid["student_id"]; //id студента нужного ?>
              <?php foreach ($students as $stid): ?>
                <?php if ($stid["id"] == $id): ?>



          <div class = "state ">

              <div class = "arrow"></div>

              <div class="left_name15"><?=$stid["first_name"]?> <?=$stid["middle_name"]?></div>

              <div class = "text">
                  <div class ="progress2 progress4only first">

                      <div class = "square"></div>
                      <div class = "square"></div>
                      <div class = "square"></div>
                      <div class = "square"></div>
                      <div class = "square"></div>
                      <div class = "square"></div>
                  </div>
              </div>

              <div class = "text">
                  <div class ="progress2 second">
                      <div class = "pr100"></div>
                  </div>
              </div>

              <div class = "text">
                  <div class ="progress2 third">
                      <div class = "pr100 space2"></div>
                  </div>
              </div>

              <div class = "text">
                  <div class ="progress2 fourth">
                      <div class = "pr100 on space3"></div>
                  </div>

              </div>
              <div class = "text">
                  <div class ="progress2 last">
                      <div class = "last"> 17.02.2001 14:30</div>
                  </div>

              </div>

              <div class="clear"></div>
              <div class = "switcher">
                  <div class = "miniblock">
                      <div class = "namespace">Задание на ВКР:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <div class = "metka good">проверено</div>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Текст ВКР:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <div class = "metka bad">нет отметки о согласовании с руководителем ВКР</div>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace red">Граф. Материалы:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <input type = "text"></input>
                      <button>Ответить</button>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Исх. тексты:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <div class = "metka okay">не проверено</div>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Отзыв руководителя:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <div class = "metka okay">не проверено</div>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Рецензия:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <div class = "metka okay">не проверено</div>
                  </div>

              </div>
          </div>
                  <?php endif ?>


              <?php endforeach; ?>
          <?php endforeach; ?>







          
      <?php endforeach; ?>

	</div>
	<script>
		$(document).ready(function()
		{
			
			$('.arrow').on('click', function(){
			
				$(this).parent('.state').toggleClass('active');
				
			
				
			});	
			
		});
	</script>
 
 
 </body>
</html>