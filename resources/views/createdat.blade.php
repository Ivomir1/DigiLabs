<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Records Created Around This Month</title>
</head>
<body>
    <h1>Records Created -1/+1 Month from Now</h1>
    <ul>
        @foreach ($data as $item)
            <li>{{ $item['name'] }} - Created at: {{ $item['createdAt'] }}</li>
        @endforeach
    </ul>
</body>
</html>
