<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Initials Filter</title>
</head>
<body>
    <h1>People with Matching Initials</h1>
    <ul>
        @foreach ($data as $item)
            <li>{{ $item['name'] }}</li>
        @endforeach
    </ul>
</body>
</html>
