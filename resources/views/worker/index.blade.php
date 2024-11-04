<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
Index
<div>
    @foreach($workers as $worker)
        <div>
        {{$worker->name}}
        </div>
        <hr>
    @endforeach
</div>
</body>
</html>
