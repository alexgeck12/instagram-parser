<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>test app</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

@include('navigation')

    <!-- Page Content -->
    <div class="container">
        <h2>Users</h2>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>@username</th>
                <th>Photos</th>
                <th>Likes</th>
                <th>Comments</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i = 0; $i < count($users); $i++){
            ?>

                <tr>
                    <td><a href="./<?php echo 'user/'.$users[$i]->id;?>"><?php echo $users[$i]->user_name ?></a></td>
                    <td><?php echo $users[$i]->countPhotos ?></td>
                    <td><?php echo $users[$i]->countLikes ?></td>
                    <td><?php echo $users[$i]->countComments ?></td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
