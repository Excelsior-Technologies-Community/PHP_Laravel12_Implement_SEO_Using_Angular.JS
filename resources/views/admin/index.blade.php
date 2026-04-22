<!DOCTYPE html>
<html>

<head>
    <title>Admin SEO Pages</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="max-w-7xl mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6">SEO Pages</h2>

        <div class="flex justify-between mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" placeholder="Search..." class="border px-3 py-2 rounded">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
            </form>

            <div class="space-x-2">
                <a href="/admin/create" class="bg-green-500 text-white px-4 py-2 rounded">+ Add</a>
                <a href="/admin/trash" class="bg-red-500 text-white px-4 py-2 rounded">Trash</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Slug</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Keywords</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                    <tr class="border-t text-center">
                        <td class="p-3">{{ $page->id }}</td>
                        <td class="p-3">{{ $page->slug }}</td>
                        <td class="p-3">{{ $page->title }}</td>
                        <td class="p-3">{{ $page->description }}</td>
                        <td class="p-3">{{ $page->keywords }}</td>
                        <td class="p-3">
                            <a href="/admin/toggle/{{ $page->id }}"
                                class="px-3 py-1 rounded text-white {{ $page->status ? 'bg-green-500' : 'bg-gray-500' }}">
                                {{ $page->status ? 'Active' : 'Inactive' }}
                            </a>
                        </td>
                        <td class="p-3 space-x-2">
                            <a href="/admin/edit/{{ $page->id }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                            <a href="/admin/delete/{{ $page->id }}"
                                onclick="return confirm('Are you sure you want to delete this SEO page?');"
                                class="bg-red-500 text-white px-3 py-1 rounded">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pages->links() }}
        </div>
    </div>

</body>

</html>