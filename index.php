<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CSV READER</title>
</head>

<body>
    <form action="read_csv.php" method="post" id="csv_form">
        <input type="file" name="csv_file" id="csv_file">
        <button type="button" id="button">Submit</button>
        <ol id="response"></ol>
    </form>

    <a href="clear_session.php">Clear session</a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="./js/custom.js"></script>
</body>

</html>