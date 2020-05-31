<?php
include 'MySQL.php';
$p = new MySQL;

$student = $p->request_array("SELECT * FROM students WHERE id=".$_GET["id"]);
$group_id = $p->request_array("SELECT * FROM students_to_group WHERE student_id=".$_GET["id"]);

$group_name = $p->request_array("SELECT * FROM groups WHERE id=".$group_id["group_id"]);
?>
<!DOCTYPE HTML PUBLIC >
<html>
 <head>
  <link rel="stylesheet" href="proverkaVKR_style.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title></title>
 </head>

 <body>
  <div class = "wrapper"> 
	<h2 class="">Проверка материалов ВКР</h2> 
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
                $f=0;
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
                    <div class = "pr100"></div>
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
                    <div class = "pr100"></div>
                <?php }?>
		
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
                <?php
                $result = $p->request_array("SELECT `document1_id` FROM `project` WHERE `student_id` =".$student["id"]);
                $i = 1;
                $files = $p->request("SELECT `path` FROM `file` WHERE `document_id`=".$result["document1_id"]);
                foreach($files as $file): ?>

                    <?php
                    foreach($file as $minifile):?>
                        <div><a href ="/download.php?path=<?=$minifile?>">Файл <?=$i?> Скачать</a> <a href ="/VKR/<?=$minifile?>">Открыть</a></div>

                <?php $i++; endforeach; ?>
                <?php endforeach; ?>
				<input type = "file">
			</div>
            <div class = "new">
                <?php
                $proj = $p->request_array("SELECT `document1_id` FROM project WHERE student_id =".$student["id"]);
                $doc = $p->request_array("SELECT `check_answer`, `positive`, `id` FROM document WHERE id = ". $proj["document1_id"]);
                //echo $doc["positive"];
                //echo $doc["check_answer"];
                if($doc["positive"] == 0): ?>
                    <div class = "result good">
                        <div><?=$doc["check_answer"]?></div>



                <?php endif ?>
                <?php if($doc["positive"] == 1): ?>
                    <div class = "result bad">
                        <div><?=$doc["check_answer"]?></div>



                <?php endif ?>
                <?php if($doc["positive"] == 2): ?>
                    <div class = "result okay">
                        <div><?=$doc["check_answer"]?></div>



                <?php endif ?>
                <form action="/upload_message.php" method="post">
                    <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                    <input type="submit" class ="button_good" value = "Проверено" name="mark_good">
                </form>
                <form action="/upload_message.php" method="post">
                    <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                    <input class = "input" type = "text" name = "text">
                    <input type="submit" class ="button_bad" value = "Замечание" name = "mark_bad">
                </form>

            </div>
            <div class="clear"></div><hr>
		<div >
			<div class = "name left_name" >Текст ВКР:</div>
			<div class = "block ">
                <?php
                $result = $p->request_array("SELECT `document2_id` FROM `project` WHERE `student_id` =".$student["id"]);
                $i = 1;
                $files = $p->request("SELECT `path` FROM `file` WHERE `document_id`=".$result["document2_id"]);
                foreach($files as $file): ?>

                    <?php
                    foreach($file as $minifile):?>
                        <div><a href ="/download.php?path=<?=$minifile?>">Файл <?=$i?> Скачать</a> <a href ="/VKR/<?=$minifile?>">Открыть</a></div>

                        <?php $i++; endforeach; ?>
                <?php endforeach; ?>
                <input type = "file">
			</div>
            <div class = "new">
                <?php
                $proj = $p->request_array("SELECT `document2_id` FROM project WHERE student_id =".$student["id"]);
                $doc = $p->request_array("SELECT `check_answer`, `positive`, `id` FROM document WHERE id = ". $proj["document2_id"]);
                //echo $doc["positive"];
                //echo $doc["check_answer"];
                if($doc["positive"] == 0): ?>
                    <div class = "result good">
                        <div><?=$doc["check_answer"]?></div>



                <?php endif ?>
                <?php if($doc["positive"] == 1): ?>
                    <div class = "result bad">
                        <div><?=$doc["check_answer"]?></div>



                <?php endif ?>
                <?php if($doc["positive"] == 2): ?>
                    <div class = "result okay">
                        <div><?=$doc["check_answer"]?></div>



                <?php endif ?>
                <form action="/upload_message.php" method="post">
                    <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                    <input type="submit" class ="button_good" value = "Проверено" name="mark_good">
                </form>
                <form action="/upload_message.php" method="post">
                    <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                    <input class = "input" type = "text" name = "text">
                    <input type="submit" class ="button_bad" value = "Замечание" name = "mark_bad">
                </form>

            </div>
            <div class="clear"></div><hr>
		</div>
		<div >
			<div class = "name left_name" >Граф. материалы:</div>
			<div class = "block ">
                <?php
                $result = $p->request_array("SELECT `document3_id` FROM `project` WHERE `student_id` =".$student["id"]);
                $i = 1;
                $files = $p->request("SELECT `path` FROM `file` WHERE `document_id`=".$result["document3_id"]);
                foreach($files as $file): ?>

                    <?php
                    foreach($file as $minifile):?>
                        <div><a href ="/download.php?path=<?=$minifile?>">Файл <?=$i?> Скачать</a> <a href ="/VKR/<?=$minifile?>">Открыть</a></div>

                        <?php $i++; endforeach; ?>
                <?php endforeach; ?>
                <input type = "file">
			</div>
            <div class = "new">
                <?php
                $proj = $p->request_array("SELECT `document3_id` FROM project WHERE student_id =".$student["id"]);
                $doc = $p->request_array("SELECT `check_answer`, `positive`, `id` FROM document WHERE id = ". $proj["document3_id"]);
                //echo $doc["positive"];
                //echo $doc["check_answer"];
                if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>



                    <?php endif ?>
                    <?php if($doc["positive"] == 1): ?>
                    <div class = "result bad">
                        <div><?=$doc["check_answer"]?></div>



                        <?php endif ?>
                        <?php if($doc["positive"] == 2): ?>
                        <div class = "result okay">
                            <div><?=$doc["check_answer"]?></div>



                            <?php endif ?>
                            <form action="/upload_message.php" method="post">
                                <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                                <input type="submit" class ="button_good" value = "Проверено" name="mark_good">
                            </form>
                            <form action="/upload_message.php" method="post">
                                <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                                <input class = "input" type = "text" name = "text">
                                <input type="submit" class ="button_bad" value = "Замечание" name = "mark_bad">
                            </form>

                        </div>
                        <div class="clear"></div><hr>
                    </div>

		<div >
			<div class = "name left_name" >Исходные тексты и дистрибутив:</div>
			<div class = "block ">
                <?php
                $result = $p->request_array("SELECT `document4_id` FROM `project` WHERE `student_id` =".$student["id"]);
                $i = 1;
                $files = $p->request("SELECT `path` FROM `file` WHERE `document_id`=".$result["document4_id"]);
                foreach($files as $file): ?>

                    <?php
                    foreach($file as $minifile):?>
                        <div><a href ="/download.php?path=<?=$minifile?>">Файл <?=$i?> Скачать</a> <a href ="/VKR/<?=$minifile?>">Открыть</a></div>

                        <?php $i++; endforeach; ?>
                <?php endforeach; ?>
                <input type = "file">
			</div>
            <div class = "new">
                <?php
                $proj = $p->request_array("SELECT `document4_id` FROM project WHERE student_id =".$student["id"]);
                $doc = $p->request_array("SELECT `check_answer`, `positive`, `id` FROM document WHERE id = ". $proj["document4_id"]);
                //echo $doc["positive"];
                //echo $doc["check_answer"];
                if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>



                    <?php endif ?>
                    <?php if($doc["positive"] == 1): ?>
                    <div class = "result bad">
                        <div><?=$doc["check_answer"]?></div>



                        <?php endif ?>
                        <?php if($doc["positive"] == 2): ?>
                        <div class = "result okay">
                            <div><?=$doc["check_answer"]?></div>



                            <?php endif ?>
                            <form action="/upload_message.php" method="post">
                                <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                                <input type="submit" class ="button_good" value = "Проверено" name="mark_good">
                            </form>
                            <form action="/upload_message.php" method="post">
                                <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                                <input class = "input" type = "text" name = "text">
                                <input type="submit" class ="button_bad" value = "Замечание" name = "mark_bad">
                            </form>

                        </div>
                        <div class="clear"></div><hr>
                    </div>
		<div >
			<div class = "name left_name" >Отзыв руководителя:</div>
			<div class = "block ">
                <?php
                $result = $p->request_array("SELECT `document5_id` FROM `project` WHERE `student_id` =".$student["id"]);
                $i = 1;
                $files = $p->request("SELECT `path` FROM `file` WHERE `document_id`=".$result["document5_id"]);
                foreach($files as $file): ?>

                    <?php
                    foreach($file as $minifile):?>
                        <div><a href ="/download.php?path=<?=$minifile?>">Файл <?=$i?> Скачать</a> <a href ="/VKR/<?=$minifile?>">Открыть</a></div>

                        <?php $i++; endforeach; ?>
                <?php endforeach; ?>
                <input type = "file">
			</div>
            <div class = "new">
                <?php
                $proj = $p->request_array("SELECT `document5_id` FROM project WHERE student_id =".$student["id"]);
                $doc = $p->request_array("SELECT `check_answer`, `positive`, `id` FROM document WHERE id = ". $proj["document5_id"]);
                //echo $doc["positive"];
                //echo $doc["check_answer"];
                if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>



                    <?php endif ?>
                    <?php if($doc["positive"] == 1): ?>
                    <div class = "result bad">
                        <div><?=$doc["check_answer"]?></div>



                        <?php endif ?>
                        <?php if($doc["positive"] == 2): ?>
                        <div class = "result okay">
                            <div><?=$doc["check_answer"]?></div>



                            <?php endif ?>
                            <form action="/upload_message.php" method="post">
                                <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                                <input type="submit" class ="button_good" value = "Проверено" name="mark_good">
                            </form>
                            <form action="/upload_message.php" method="post">
                                <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                                <input class = "input" type = "text" name = "text">
                                <input type="submit" class ="button_bad" value = "Замечание" name = "mark_bad">
                            </form>

                        </div>
                        <div class="clear"></div><hr>
                    </div>
		<div >
			<div class = "name left_name" >Рецензия:</div>
			<div class = "block ">
                <?php
                $result = $p->request_array("SELECT `document6_id` FROM `project` WHERE `student_id` =".$student["id"]);
                $i = 1;
                $files = $p->request("SELECT `path` FROM `file` WHERE `document_id`=".$result["document6_id"]);
                foreach($files as $file): ?>

                    <?php
                    foreach($file as $minifile):?>
                        <div><a href ="/download.php?path=<?=$minifile?>">Файл <?=$i?> Скачать</a> <a href ="/VKR/<?=$minifile?>">Открыть</a></div>

                        <?php $i++; endforeach; ?>
                <?php endforeach; ?>
                <input type = "file">
			</div>
            <div class = "new">
                <?php
                $proj = $p->request_array("SELECT `document6_id` FROM project WHERE student_id =".$student["id"]);
                $doc = $p->request_array("SELECT `check_answer`, `positive`, `id` FROM document WHERE id = ". $proj["document6_id"]);
                //echo $doc["positive"];
                //echo $doc["check_answer"];
                if($doc["positive"] == 0): ?>
                <div class = "result good">
                    <div><?=$doc["check_answer"]?></div>



                    <?php endif ?>
                    <?php if($doc["positive"] == 1): ?>
                    <div class = "result bad">
                        <div><?=$doc["check_answer"]?></div>



                        <?php endif ?>
                        <?php if($doc["positive"] == 2): ?>
                        <div class = "result okay">
                            <div><?=$doc["check_answer"]?></div>



                            <?php endif ?>
                            <form action="/upload_message.php" method="post">
                                <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                                <input type="submit" class ="button_good" value = "Проверено" name="mark_good">
                            </form>
                            <form action="/upload_message.php" method="post">
                                <input type="hidden" value="<?=$doc["id"]?>" name="doc_id">
                                <input class = "input" type = "text" name = "text">
                                <input type="submit" class ="button_bad" value = "Замечание" name = "mark_bad">
                            </form>

                        </div>
                        <div class="clear"></div><hr>
                    </div>
	
	
	
  </div>
 
 </body>
</html>