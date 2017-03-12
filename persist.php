<?php

$cluster = Cassandra::cluster()->build();

$keyspace  = 'dev';
$session  = $cluster->connect($keyspace);


if(!empty($_POST)) {

    if($_POST['type'] === 'LIKE' and $_POST['teacher_uuid'] !== '') {

        try {
            $teacherUUID = $_POST['teacher_uuid'];

            $statement = $session->execute(new Cassandra\SimpleStatement(
                "INSERT INTO like (teacher, date) VALUES ({$teacherUUID}, toUnixTimestamp(now()))"
            ));

            return json_encode(['success' => true]);
        } catch (\Exception $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }


    } elseif($_POST['type'] === 'UNLIKE' and $_POST['teacher_uuid'] !== '') {

        try {
            $teacherUUID = $_POST['teacher_uuid'];

            $statement = $session->execute(new Cassandra\SimpleStatement(
                "INSERT INTO unlike (teacher, date) VALUES ({$teacherUUID}, toUnixTimestamp(now()))"
            ));

            return json_encode(['success' => true]);
        } catch (\Exception $e) {
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    }

}



