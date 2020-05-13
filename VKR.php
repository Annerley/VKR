<?php

include 'MySQL.php';

$a = new MySQL;
$students = $a->request("SELECT * FROM students");
$documents = $a->request("SELECT * FROM document");
$groups = $a->request("SELECT * FROM groups");
$projects = $a->request("SELECT * FROM project");


/*$sql = "INSERT INTO document (doc_type, project_id, check_answer, positive)
		VALUES('1','2','NICETRY','1')"	;

if($conn -> query($sql) === TRUE)
{
	echo "Record created";
}

*/ // insert in db




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

         <?php
         $c = new MySQL;
         $student = $c->request("SELECT * FROM students_to_group WHERE group_id=$group[id]");
         ?>
          <?php  foreach ($student as $studentid): ?>
          <?php  $id = $studentid["student_id"]; //id студента нужного ?>
              <?php foreach ($students as $stid): ?>
                <?php if ($stid["id"] == $id): ?>



          <div class = "state ">

              <div class = "arrow"></div>

              <div class="left_name15"><a href = "/UploadVKR.php?id=<?=$stid["id"]?>"><?=$stid["first_name"]?> <?=$stid["middle_name"]?></a></div>

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
                      <div class = "last">
                          <?php
                          if($stid["date"] == NULL) echo 'не назначено';
                          else echo date('Y-m-d H:i',strtotime($stid["date"]));
                          ?>
                      </div>
                  </div>

              </div>

              <div class="clear"></div>
              <div class = "switcher">
                  <div class = "miniblock">
                      <div class = "namespace">Задание на ВКР:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>



                          <?php
                          $flag = 0;

                          $pidor = $a->request_array("SELECT document1_id FROM `project` WHERE student_id = $stid[id]");
                          if(!empty($pidor))

                              $doc = $a->request_array("SELECT * FROM document WHERE id = $pidor[document1_id]");
                          ?>
                          <?php if ($doc["positive"] == 0): ?>
                            <div class = "metka good">

                              <?php
                              $flag = 1;
                              if(!empty($doc)) {
                                  $flag = 1;
                                  echo $doc["check_answer"];
                              }

                          else echo "lol";
                          ?>

                            </div>
                          <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {
                                  $flag = 1;
                                  echo $doc["check_answer"];
                              }

                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>
                      <?php if ($doc["positive"] == 2): ?>
                          <div class = "metka okay">

                              <?php
                              if(!empty($doc)) {
                                  $flag = 1;
                                  echo $doc["check_answer"];
                              }

                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Текст ВКР:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <?php

                      $pidor = $a->request_array("SELECT document2_id FROM `project` WHERE student_id = $stid[id]");
                      if(!empty($pidor))
                          $doc = $a->request_array("SELECT * FROM document WHERE id = $pidor[document2_id]");
                      ?>
                      <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php

                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }

                              else echo "lol";

                              ?>

                          </div>
                      <?php endif ?>
                      <?php if ($doc["positive"] == 2): ?>
                          <div class = "metka okay">

                              <?php
                              if(!empty($doc)) {
                                  $flag = 1;
                                  echo $doc["check_answer"];
                              }

                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>



                  </div>
                  <div class = "miniblock">
                      <div class = "namespace red">Граф. Материалы:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <input type = "text"></input>
                      <button> Ответить </button>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Исх. тексты:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <?php
                      $flag = 0;
                      $pidor = $a->request_array("SELECT document4_id FROM `project` WHERE student_id = $stid[id]");
                      if(!empty($pidor))
                          $doc = $a->request_array("SELECT * FROM document WHERE id = $pidor[document4_id]");
                      ?>
                      <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>
                      <?php if ($doc["positive"] == 2): ?>
                          <div class = "metka okay">

                              <?php
                              if(!empty($doc)) {
                                  $flag = 1;
                                  echo $doc["check_answer"];
                              }

                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Отзыв руководителя:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <?php

                      $pidor = $a->request_array("SELECT document5_id FROM `project` WHERE student_id = $stid[id]");
                      if(!empty($pidor))
                          $doc = $a->request_array("SELECT * FROM document WHERE id = $pidor[document5_id]");
                      ?>
                      <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>
                      <?php if ($doc["positive"] == 2): ?>
                          <div class = "metka okay">

                              <?php
                              if(!empty($doc)) {
                                  $flag = 1;
                                  echo $doc["check_answer"];
                              }

                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Рецензия:</div>
                      <div class = "file"><a href="">Файл(залито 15.45.9801 12:56)</a></div>
                      <?php

                      $pidor = $a->request_array("SELECT document6_id FROM `project` WHERE student_id = $stid[id]");
                      if(!empty($pidor))

                          $doc = $a->request_array("SELECT * FROM document WHERE id = $pidor[document6_id]");
                      ?>
                      <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "lol";
                              ?>

                          </div>
                      <?php endif ?>
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