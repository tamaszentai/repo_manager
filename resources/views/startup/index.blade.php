<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Repo Manager</title>
</head>

<body>
    <form method="POST">
        @csrf
        <label for="token">Token:</label><br>
        <input type="text" id="token" name="token"><br>
        <label for="directory_path">Directory Path:</label><br>
        <input type="text" id="directory_path" name="directory_path"><br><br>
        <button type="submit">Save</button>
    </form>
</body>

</html>