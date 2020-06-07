<?php

$checker  = 0; //0 if upload 1 if check
include 'MySQL.php';

$a = new MySQL;
$students = $a->request("SELECT * FROM students");
$documents = $a->request("SELECT * FROM document");
$groups = $a->request("SELECT * FROM groups");
$projects = $a->request("SELECT * FROM project");



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

              <div class="left_name15"><?php
                  if($checker == 0 ):?>

                      <a href="/UploadVKR.php?id=<?= $stid["id"] ?>"><?= $stid["first_name"] ?> <?= $stid["middle_name"] ?></a>


                  <?php else: if($checker == 1) :?>


                      <a href = "/proverkaVKR.php?id=<?=$stid["id"]?>"><?=$stid["first_name"]?> <?=$stid["middle_name"]?></a>
                  <?php endif;?>
                  <?php endif;?>



              </div>

              <div class = "text">
                  <div class ="progress2 first">
                    <?php
                    $doc = $a->request_array("SELECT document1_id,document2_id,document3_id,document4_id,document5_id,document6_id FROM `project` WHERE `student_id`=".$stid["id"]);
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
                        $progress = $a->request("SELECT * FROM `document` WHERE `id` IN ($id_docs)");
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
              </div>

              <div class = "text">
                  <div class ="progress2 second">

                      <?php
                      $progress = $a->request("SELECT `id` FROM `file` WHERE `document_id` IN ($id_docs)");

                      $f=0;
                      foreach($doc as $docs)
                      {

                          $progress = $a->request("SELECT `id` FROM `file` WHERE `document_id` IN ($docs)");
                          if(!empty($progress))
                              $f++;

                      }
                      if ($f==6){?>
                          <div class = "pr100 on"></div>
                          <?php
                      }?>
                      <?php
                      if ($f<6){?>
                          <div class = "pr100 "></div>
                      <?php }?>


                  </div>
              </div>

              <div class = "text">
                  <div class ="progress2 third">
                      <?php
                      if ($f==6){?>
                          <div class = "pr100 on"></div>
                          <?php
                      }?>
                      <?php
                      if ($f<6){?>
                          <div class = "pr100 "></div>
                      <?php }?>

                  </div>
              </div>

              <div class = "text">
                  <div class ="progress2 fourth">
                      <?php
                      if($stid["register"] == 1):?>

                      <div class = "pr100 on space3"></div>
                      <?php endif; ?>
                      <?php
                      if($stid["register"] == 0):?>
                      <div class = "pr100 space3"></div>
                      <?php endif; ?>
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
                      <div class = "file">

                          <?php
                          $request = $a->request_array("SELECT document1_id FROM `project` WHERE student_id =". $stid["id"]);
                          //var_dump($request );
                          if($request!= NULL)
                          {
                              $file = $a->request("SELECT * FROM `file` WHERE document_id=". $request["document1_id"]);
                              //var_dump($file);
                              $i=1;
                              if($file!= NULL)
                              {
                                  foreach($file as $littlefile):?>


                                      <div ><a href="<?=$littlefile["path"]?>">Файл №<?=$i?>(залито <?= date("d.m.Y H:i",strtotime($littlefile["uploaded"]))?>)</a></div>




                                  <?php $i++; endforeach;} else echo "Нет файлов";} else echo "Документа нет в бд документов" ?>
                      </div>


                          <?php
                          $flag = 0;

                          $req = $a->request_array("SELECT document1_id FROM `project` WHERE student_id =". $stid["id"]);
                          if(!empty($req))
                          {
                              $doc = NULL;
                              $doc = $a->request_array("SELECT * FROM document WHERE id = ". $req["document1_id"]);

                          ?>
                          <?php if ($doc["positive"] == 0): ?>
                            <div class = "metka good">

                              <?php
                              $flag = 1;

                              if(!empty($doc)) {
                                  $flag = 1;
                                  echo $doc["check_answer"];
                              }

                              else echo "error";
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

                              else echo "error";
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

                              else echo "error";
                              ?>

                          </div>
                      <?php endif ;} else echo "не проверено"; ?>
                  </div>
                  <div class = "clear"> </div>
                  <div class = "miniblock">
                      <div class = "namespace">Текст ВКР:</div>
                          <div class = "file">

                              <?php
                              $request = $a->request_array("SELECT document2_id FROM `project` WHERE student_id =". $stid["id"]);
                              //var_dump($request );
                              if($request!= NULL)
                              {
                                  $file = $a->request("SELECT * FROM `file` WHERE document_id=". $request["document2_id"]);
                                  //var_dump($file);
                                  $i=1;
                                  if($file!= NULL)
                                  {
                                      foreach($file as $littlefile):?>


                                          <div ><a href="<?=$littlefile["path"]?>">Файл №<?=$i?>(залито <?= date("d.m.Y H:i",strtotime($littlefile["uploaded"]))?>)</a></div>




                                          <?php $i++; endforeach;} else echo "Нет файлов";} else echo "Документа нет в бд документов" ?>
                          </div>

                      <?php

                      $req = $a->request_array("SELECT document2_id FROM `project` WHERE student_id = " . $stid["id"]);
                      if(!empty($req))
                      {
                          $doc = NULL;
                          $doc = $a->request_array("SELECT * FROM document WHERE id = ". $req["document2_id"]);
                      ?>
                      <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php

                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
                              ?>

                          </div>
                      <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }

                              else echo "error";

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

                              else echo "error";
                              ?>

                          </div>
                      <?php endif ;} else echo "не проверено"; ?>



                  </div>
                  <div class = "clear"></div>
                  <br>
                  <div class = "miniblock">
                      <div class = "namespace red">Граф. Материалы:</div>

                      <div class = "file">

                          <?php
                          $request = $a->request_array("SELECT document3_id FROM `project` WHERE student_id =". $stid["id"]);
                          //var_dump($request );
                          if($request!= NULL)
                          {
                              $file = $a->request("SELECT * FROM `file` WHERE document_id=". $request["document3_id"]);
                              //var_dump($file);
                              $i=1;
                              if($file!= NULL)
                              {
                                  foreach($file as $littlefile):?>


                                      <div ><a href="<?=$littlefile["path"]?>">Файл №<?=$i?>(залито <?= date("d.m.Y H:i",strtotime($littlefile["uploaded"]))?>)</a></div>




                                      <?php $i++; endforeach;} else echo "Нет файлов";} else echo "Документа нет в бд документов" ?>
                      </div>
                      <?php
                      $flag = 0;
                      $req = $a->request_array("SELECT document3_id FROM `project` WHERE student_id = $stid[id]");
                      if(!empty($req))
                      {
                          $doc = NULL;
                          $doc = $a->request_array("SELECT * FROM document WHERE id = $req[document3_id]");
                          ?>
                          <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
                              ?>

                          </div>
                      <?php endif ?>

                          <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
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

                              else echo "error";
                              ?>

                          </div>
                      <?php endif ;} else echo "не проверено"; ?>
                  </div>


                  <div class = "miniblock">
                      <div class = "namespace">Исх. тексты:</div>
                      <div class = "file">

                          <?php
                          $request = $a->request_array("SELECT document4_id FROM `project` WHERE student_id =". $stid["id"]);
                          //var_dump($request );
                          if($request!= NULL)
                          {
                              $file = $a->request("SELECT * FROM `file` WHERE document_id=". $request["document4_id"]);
                              //var_dump($file);
                              $i=1;
                              if($file!= NULL)
                              {
                                  foreach($file as $littlefile):?>


                                      <div ><a href="<?=$littlefile["path"]?>">Файл №<?=$i?>(залито <?= date("d.m.Y H:i",strtotime($littlefile["uploaded"]))?>)</a></div>




                                      <?php $i++; endforeach;} else echo "Нет файлов";} else echo "Документа нет в бд документов" ?>
                      </div>
                      <?php
                      $flag = 0;
                      $req = $a->request_array("SELECT document4_id FROM `project` WHERE student_id = $stid[id]");
                      if(!empty($req))
                      {
                          $doc = NULL;
                          $doc = $a->request_array("SELECT * FROM document WHERE id = $req[document4_id]");
                      ?>
                      <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
                              ?>

                          </div>
                      <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
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

                              else echo "error";
                              ?>

                          </div>
                      <?php endif ;} else echo "не проверено"; ?>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Отзыв руководителя:</div>
                      <div class = "file">

                          <?php
                          $request = $a->request_array("SELECT document5_id FROM `project` WHERE student_id =". $stid["id"]);
                          //var_dump($request );
                          if($request!= NULL)
                          {
                              $file = $a->request("SELECT * FROM `file` WHERE document_id=". $request["document5_id"]);
                              //var_dump($file);
                              $i=1;
                              if($file!= NULL)
                              {
                                  foreach($file as $littlefile):?>


                                      <div ><a href="<?=$littlefile["path"]?>">Файл №<?=$i?>(залито <?= date("d.m.Y H:i",strtotime($littlefile["uploaded"]))?>)</a></div>




                                      <?php $i++; endforeach;} else echo "Нет файлов";} else echo "Документа нет в бд документов" ?>
                      </div>
                      <?php

                      $req = $a->request_array("SELECT document5_id FROM `project` WHERE student_id = $stid[id]");
                      if(!empty($req))
                      {
                          $doc = NULL;
                          $doc = $a->request_array("SELECT * FROM document WHERE id = $req[document5_id]");
                      ?>
                      <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
                              ?>

                          </div>
                      <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
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

                              else echo "error";
                              ?>

                          </div>
                      <?php endif ;} else echo "не проверено"; ?>
                  </div>
                  <div class = "miniblock">
                      <div class = "namespace">Рецензия:</div>
                      <div class = "file">

                          <?php
                          $request = $a->request_array("SELECT document6_id FROM `project` WHERE student_id =". $stid["id"]);
                          //var_dump($request );
                          if($request!= NULL)
                          {
                              $file = $a->request("SELECT * FROM `file` WHERE document_id=". $request["document6_id"]);
                              //var_dump($file);
                              $i=1;
                              if($file!= NULL)
                              {
                                  foreach($file as $littlefile):?>


                                      <div ><a href="<?=$littlefile["path"]?>">Файл №<?=$i?>(залито <?= date("d.m.Y H:i",strtotime($littlefile["uploaded"]))?>)</a></div>




                                      <?php $i++; endforeach;} else echo "Нет файлов";} else echo "Документа нет в бд документов" ?>
                      </div>
                      <?php

                      $req = $a->request_array("SELECT document6_id FROM `project` WHERE student_id = $stid[id]");
                      if(!empty($req))
                      {
                          $doc = NULL;
                          $doc = $a->request_array("SELECT * FROM document WHERE id = $req[document6_id]");
                         // var_dump($doc);
                      ?>
                      <?php if ($doc["positive"] == 0): ?>
                          <div class = "metka good">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
                              ?>

                          </div>
                      <?php endif ?>

                      <?php if ($doc["positive"] == 1): ?>
                          <div class = "metka bad">

                              <?php
                              if(!empty($doc)) {

                                  echo $doc["check_answer"];
                              }
                              else echo "error";
                              ?>

                          </div>
                      <?php endif ?>

                          <?php if ($doc["positive"] == 2): ?>
                              <div class = "metka okay">

                                  <?php
                                  if(!empty($doc)) {

                                      echo $doc["check_answer"];
                                  }
                                  else echo "error";
                                  ?>

                              </div>

                      <?php endif ;} else echo "не проверено"; ?>
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