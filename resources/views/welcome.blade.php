<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Repo Manager</title>
</head>

<body>
    <h1 class="text-2xl text-black">Repo Manager</h1>
    @foreach ($repos as $repo)
    <div class="bg-gray-100 p-4 my-4">
        <h2>{{ $repo }}</h2>
    </div>
    @endforeach
</body>

</html>