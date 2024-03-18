<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Math Check</title>
</head>
<body>
    <h1>Records Matching Math Check</h1>
    <ul>
        @foreach ($data as $item)
            <li>{{ $item['firstNumber'] }} / {{ $item['secondNumber'] }} = {{ $item['thirdNumber'] }} (Even First Number)</li>
        @endforeach
    </ul>
</body>
</html>
