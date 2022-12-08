<?php //user login page
    echo("<h1>user login</h1>");
    echo("<br>");   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tRVMS USER LOGIN</title>
</head>
<body>
    <button id="backtoindex" class="float-left submit-button" >back to index</button>

    <script type="text/javascript">
        document.getElementById("backtoindex").onclick = function () {
            location.href = "/index.php";
        };
    </script>
</body>
</html>