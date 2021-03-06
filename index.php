<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dev-Lab URL shortner</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <h1>URL Shortner by Dev-Lab</h1>
        <h2>Le laboratoire du dev</h2>
        <br/>
        <form action="." method="post">
            <input type="text" name="url" id="url"/>
            <input type="submit" name="shortme" id="shortme" value="ShortMe">
        </form>
<?php
$conn = new mysqli("0.0.0.0:3306", "demouser", "demopassword", "shortnerdb");

// Check connection
if ($conn->connect_error) {
    die("Error BDD");
}

$regex_url = '(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})';
echo "\n <br>";
if ($_POST['shortme']){
        if ($url = trim($_POST['url'])) {
		if(substr($url,0,7)!="http://" &&  substr($url,0,8)!="https://"){
			$url = "http://".$url;
		}
            if(preg_match($regex_url,$url)){

                $res = $conn->query("Select hash from shorttable where url ='".$url."'");
                $res = $res->fetch_assoc();
                if ($res){
                    echo "Partagez le lien <a href='https://go.dev-lab.net/".$res['hash']. "'>go.dev-lab.net/".$res['hash']."</a> :) ";
                } else {
                    $fullhash = sha1($url);
                    $hash=substr($fullhash,0,6);
                    $res = $conn->query("Select 'x' from shorttable where hash ='".$hash."'");
                    $res = $res->fetch_assoc();
                    if($res){
                        $hash = substr($fullhash,0,7);
                    }
                    $conn->query("Insert into shorttable(url,hash,fullhash) values ('".$url."','".$hash."','".$fullhash."')");
                    if(!$conn->connect_error){
                        echo "<div>Partagez le lien <a href='https://go.dev-lab.net/".$hash. "'>go.dev-lab.net/".$hash."</a> :) </div>";
                    } else {
                        echo "<div>Internal error, try again please</div>";
                    }
                }
            }
            else {
                echo 'Entrez une URL au format "http://(www).exemple.com" ou "https://(www).exemple.com"';
            }
        }
        else {
            echo "Entrez une URL";
        }
    }
    mysqli_close($conn);
    ?>
    </body>
</html>
