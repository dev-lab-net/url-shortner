<?php
$hash =  "{$_SERVER['REQUEST_URI']}";
try {
    $conn = new mysqli("0.0.0.0:3306", "demouser", "demopassword", "shortnerdb");
    $res = $conn->query("Select url from shorttable where hash ='".substr($hash,1,strlen($hash))."'");
    $res->fetch_assoc();
    header('Location: '.$res);
    mysqli_close($conn);
    exit();
} catch (\Throwable $th) {
    echo <<<TEXT
    <!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>
    <h1>Dev-Lab 404</h1>
    <div>Cette page n'existe pas</div>
    </body>
TEXT;
}
?>