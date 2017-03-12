<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cassandra Test</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container">
    <h1><i class="fa fa-graduation-cap" aria-hidden="true"></i> FaceTeacher</h1>
    <hr>

    <div class="row">

        <?php

        $cluster = Cassandra::cluster()->build();

        $keyspace  = 'dev';
        $session  = $cluster->connect($keyspace);

        $teachers = $session->execute(new Cassandra\SimpleStatement("SELECT * from teachers"));

        foreach($teachers as $teacher) : ?>

            <div class="col-md-3">
                <?php
                    $img = '';
                    switch($teacher['name']) {
                        case 'Felipe':
                            $img = 'felipe.jpg';
                            break;
                        case 'Petronio':
                            $img = 'petronio.jpg';
                            break;
                        case 'Paulo Vitor':
                            $img = 'paulov.jpg';
                    }
                ?>
                <img src="img/<?php echo $img; ?>" class="img-rounded img-responsive" width="250" /><br>
                <?php echo $teacher['name']; ?> <br>

                <a href="#" id="<?php echo $teacher['id']; ?>" class="btn btn-success like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    <span id="<?php echo $teacher['id']; ?>like-value"><?php

                    $like = $session->execute(new Cassandra\SimpleStatement("SELECT count(*) from like where teacher = ".$teacher['id']));

                    echo $like[0]['count'];

                    ?></span>

                </a> &nbsp;&nbsp;<a href="#" id="<?php echo $teacher['id']; ?>" class="btn btn-warning unlike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i>

                    <span id="<?php echo $teacher['id']; ?>unlike-value"><?php

                    $like = $session->execute(new Cassandra\SimpleStatement("SELECT count(*) from unlike where teacher = ".$teacher['id']));

                    echo $like[0]['count'];

                    ?></span>
                </a>

            </div>



        <?php endforeach ?>


    </div>

</div>

<script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {

        $(".like").on('click', function(){

            var $this = $(this);

            var teacher_uuid = $this.attr('id');

            var likeValue = parseInt($("#"+teacher_uuid+"like-value").text());

            $.ajax({
                method: 'POST',
                url: 'persist.php',
                data: {type: 'LIKE', 'teacher_uuid': teacher_uuid},
                success: function(data) {
                    $("#"+teacher_uuid+"like-value").text(likeValue+1);
                }
            });

        });

        $(".unlike").on('click', function(){

            var $this = $(this);

            var teacher_uuid = $this.attr('id');

            var likeValue = parseInt($("#"+teacher_uuid+"unlike-value").text());

            $.ajax({
                method: 'POST',
                url: 'persist.php',
                data: {type: 'UNLIKE', 'teacher_uuid': teacher_uuid},
                success: function(data) {
                    $("#"+teacher_uuid+"unlike-value").text(likeValue+1);
                }
            });

        });


    })
</script>

</body>
</html>