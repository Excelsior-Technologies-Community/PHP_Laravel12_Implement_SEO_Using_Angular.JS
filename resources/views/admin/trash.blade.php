<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Trash SEO Pages</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 30px; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px 10px; text-align: left; }
        th { background: #f1f1f1; }
        a { color: #007BFF; text-decoration: none; margin-right: 8px; }
        a:hover { text-decoration: underline; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
<div class="container">
    <h2>Deleted SEO Pages (Trash)</h2>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="/admin">Back to List</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Actions</th>
        </tr>

        @forelse($pages as $page)
        <tr>
            <td>{{ $page->id }}</td>
            <td>{{ $page->title }}</td>
            <td>
                <a href="/admin/restore/{{ $page->id }}">Restore</a> |
                <a href="/admin/force-delete/{{ $page->id }}" onclick="return confirm('Are you sure?')">Delete Permanently</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3">No deleted records found</td>
        </tr>
        @endforelse
    </table>
</div>
</body>
</html>