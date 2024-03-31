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
    <form action="{{ route('repos.index') }}" method="GET">
        <input type="text" name="search" placeholder="Search for a repository" class="border border-gray-300 p-2 rounded-lg">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">Search</button>
    </form>
    <a href="{{ route('setup.edit', $setup) }}" class="text-blue-500">Edit setup</a>

    @if (isset($error))
    <div class="bg-red-100 p-4 my-4">
        {{$error}}
    </div>
    @else
    @foreach ($repos as $repo)
    <div class="bg-gray-100 p-4 my-4">
        <h2 class="text-xl font-bold">{{ $repo['name'] }}</h2>
        <p class="text-gray-600">{{ $repo['description'] }}</p>
    </div>
    @endforeach
    @endif
</body>

</html>