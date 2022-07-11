<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response recorded</title>
</head>
<body>
<center>
<?php


$conn = mysqli_connect('localhost', 'ap', '123456', 'ajay');

$name = $_POST['name'];
$email= $_POST['email'];
$comments = $_POST['comments'];


$sql = "INSERT INTO `response` (`name`, `email`, `query`) VALUES ('$name', '$email', '$comments')";
    
    if(mysqli_query($conn, $sql)){
        $html = "<br><br><br><h1 style=\"color:green;text-align:center\">Your response is recorded</h1>
        <h2 style=\"color:green;text-align:center\">We will get back to you soon</h2>";
    }

    else{
        echo "failed";
    }

     echo $html;
    mysqli_close($conn);
?>
</center>
</body>
</html>


