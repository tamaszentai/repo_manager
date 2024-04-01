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

    <a href="{{ route('setup.edit', $setup['id']) }}" class="text-blue-500">Edit setup</a>

    @if (isset($error))
    <div class="bg-red-100 p-4 my-4">
        {{$error}}
    </div>
    @else
    @foreach ($repos as $repo)
    <div class="bg-gray-100 p-4 my-4">
        <h2 class="text-xl font-bold">{{ $repo['name'] }}</h2>
        <p class="text-gray-600">Description: {{ $repo['description'] ? $repo['description'] : 'N/A' }}</p>
        <p class="text-gray-600">Language: {{ $repo['language'] }}</p>

        @php
        $libraryPath = $setup['directory_path'] . $repo['name'];
        $libraryExists = file_exists($libraryPath);
        @endphp

        <form action="{{ route('cloneRepo') }}" method="POST">
            @csrf
            <input type="hidden" name="library_name" value="{{ $repo['name'] }}">
            <input type="hidden" name="clone_url" value="{{ $repo['ssh_url'] }}">
            @if(!$libraryExists)
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg disabled:bg-gray-300">
                Clone Repo
            </button>
            @else
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg disabled:bg-gray-300" disabled>
                Repo already exists
            </button>
            @endif
        </form>
    </div>
    @endforeach
    @endif
</body>

</html>