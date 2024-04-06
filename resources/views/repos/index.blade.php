<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repo Manager</title>
    @vite('resources/css/app.css')
</head>

<body>
    <header class="flex justify-between items-center py-4 bg-gray-800 text-white">
        <h1 class="text-xl font-bold mx-3">Repo Manager</h1>
        <a href="{{ route('setup.edit', $setup['id']) }}" class="text-blue-500 hover:underline mx-3">Edit setup</a>
    </header>

    <nav>
        <form action="{{ route('repos.next') }}" method="POST">
            @csrf
            @php
            $isLastPage = false;
            if ($links['next'] === $links['last']) {
            $isLastPage = true;
            }
            @endphp
            <input type="hidden" name="url" value="{{ $links['next'] }}">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg disabled:bg-gray-400" @disabled($isLastPage)>Next</button><br>
            {{ var_dump($isLastPage)}} <br>
            {{ $links['next'] }} <br>
            {{ $links['last'] }} <br>
        </form>
    </nav>

    <main class="container mx-auto px-4 py-8">
        <section class="search-form mb-4">
            <form action="{{ route('repos.index') }}" method="GET">
                <input type="text" name="search" placeholder="Search for a repository" class="search-input border border-gray-300 p-2 rounded-lg">
                <button type="submit" class="search-button bg-blue-500 text-white p-2 rounded-lg">Search</button>
            </form>
        </section>

        @if (isset($error))
        <div class="alert alert-danger p-4 my-4">
            {{ $error }}
        </div>
        @endif

        @if (isset($repos))
        <section class="repo-list"> @foreach ($repos as $repo)
            <article class="repo-item bg-gray-100 p-4 my-4 rounded-lg shadow-md">
                <h2 class="repo-title text-xl font-bold">{{ $repo['name'] }}</h2>
                <p class="repo-description text-gray-600">Description: {{ $repo['description'] ? $repo['description'] : 'N/A' }}</p>
                <p class="repo-language text-gray-600">Language: {{ $repo['language'] }}</p>

                <?php
                $libraryPath = $setup['directory_path'] . $repo['name'];
                $libraryExists = file_exists($libraryPath);
                $nodeModulesExists = file_exists($libraryPath . '/node_modules');
                ?>

                <div class="repo-actions flex mt-4">
                    <form action="{{ route('cloneRepo') }}" method="POST" class="mr-2">
                        @csrf
                        <input type="hidden" name="library_name" value="{{ $repo['name'] }}">
                        <input type="hidden" name="clone_url" value="{{ $repo['ssh_url'] }}">
                        @if (!$libraryExists)
                        <button type="submit" class="clone-button bg-blue-500 text-white p-2 rounded-lg">Clone Repo</button>
                        @else
                        <button type="button" class="clone-button bg-gray-300 text-white p-2 rounded-lg disabled">Repo already exists</button>
                        @endif
                    </form>

                    <form action="{{ route('deleteRepo') }}" method="POST">
                        @csrf
                        <input type="hidden" name="library_name" value="{{ $repo['name'] }}">
                        @if ($libraryExists)
                        <button type="submit" class="delete-button bg-red-500 text-white p-2 rounded-lg">Delete Repo From Disk</button>
                        @endif
                    </form>

                    <form action="{{ route('installDependencies') }}" method="POST" class="ml-2">
                        @csrf
                        <input type="hidden" name="library_name" value="{{ $repo['name'] }}">
                        <input type="hidden" name="language" value="{{ $repo['language'] }}">

                        @if ($libraryExists && $repo['language'])
                        <button type="submit" class="clone-button bg-green-500 text-white p-2 rounded-lg">Install Dependencies</button>
                        @endif
                    </form>

                    <form action="{{ route('removeDependencies') }}" method="POST" class="ml-2">
                        @csrf
                        <input type="hidden" name="library_name" value="{{ $repo['name'] }}">
                        <input type="hidden" name="language" value="{{ $repo['language'] }}">

                        @if ($libraryExists && $repo['language'] && $nodeModulesExists)
                        <button type="submit" class="remove-button bg-red-500 text-white p-2 rounded-lg">Remove Dependencies</button>
                        @elseif ($libraryExists && $repo['language'] && !$nodeModulesExists)
                        <button type="button" class="remove-button bg-gray-300 text-white p-2 rounded-lg disabled">Dependencies not installed</button>
                        @endif
                    </form>
                </div>
            </article> @endforeach
        </section>
        @endif
    </main>
</body>