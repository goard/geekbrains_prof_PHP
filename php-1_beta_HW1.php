<?php
// item 2
$name = readline("Привет! Как вас зовут? \n");
$age = readline("Сколько вам лет? \n");
echo "Вас зовут $name, вам $age лет. \n";

// item 3
(string) $name = readline("Привет! Как вас зовут? \n");
(string) $task1 = readline("Какая задача стоит перед вами сегодня? \n");
(int) $time1 = readline("Сколько примерно времени эта задача займет? \n");
(string) $task2 = readline("Какая задача стоит перед вами сегодня? \n");
(int) $time2 = readline("Сколько примерно времени эта задача займет? \n");
(string) $task3 = readline("Какая задача стоит перед вами сегодня? \n");
(int) $time3 = readline("Сколько примерно времени эта задача займет? \n");
$timeAll = $time1+$time2+$time3;


echo "$name, сегодня у вас запланировано 3 приоритетных задачи на день: - $task1 ($time1"."ч) - $task2 ($time2"."ч) - $task3 ($time3"."ч). Примерное время выполнения плана = " . $timeAll . "ч\n";
