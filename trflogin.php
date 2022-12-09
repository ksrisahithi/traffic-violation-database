<?php //traffic polic login page
    echo("<h1>traffic login</h1>");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <!-- <link rel="stylesheet" href="css/trflogin.css"> -->
    <title>TRVMS TRAFFIC LOGIN</title>
</head>
<body>
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form action="trflogin.php" method="post">
                    <fieldset class="border p-2">
                        <legend class="float-none w-auto p-2">LOGIN</legend>
                        <label for="id" class="form-label">ID</label><br>
                        <input type="text" name="id" id="id" class="form-control"><br>
                        <label for="zone" class="form-label">Zone</label><br>
                        <select name="zone" id="zone" class="form-select">
                            <option value="north">NORTH</option>
                            <option value="south">SOUTH</option>
                            <option value="northeast">NORTHEAST</option>
                            <option value="southeast">SOUTHEAST</option>
                            <option value="west">WEST</option>
                            <option value="central">CENTRAL</option>
                        </select> <br>
                        <input type="submit" value="submit">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <button id="backtoindex">back to index</button>
    <script type="text/javascript">
        document.getElementById("backtoindex").onclick = function () {
            location.href = "/index.php";
        };
    </script>
    <button id="trfregister">register</button>
    <script type="text/javascript">
        document.getElementById("trfregister").onclick = function () {
            location.href = "/trfregister.php";
        };
    </script>

</body>
</html>