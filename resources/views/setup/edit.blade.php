<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Repo Manager</title>
</head>

<body>
    <div class="bg-slate-400 min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md px-8 py-6 max-w-md">
            <h1 class="flex justify-center mb-10 text-2xl font-bold">Repo Manager EDIT</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('setup.update', $setup->id) }}">
                @method('PUT')
                @csrf
                <label for="token">Token:</label>
                <input type="text" id="token" name="token" value="{{$setup->token}}" class="w-full mb-4 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:ring-1">
                <label for="directory_path">Directory Path:</label>
                <input type="text" id="directory_path" name="directory_path" value="{{$setup->directory_path}}" class=" w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:ring-1">
                <button type="submit" class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                <button type="button" onclick="window.location='{{ route('repos.index') }}'" class="mt-4 w-full bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Cancel</button>
            </form>
        </div>
    </div>
</body>

</html>