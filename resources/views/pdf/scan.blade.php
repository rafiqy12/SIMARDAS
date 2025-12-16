<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        img {
            width: 100%;
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach($images as $img)
    <img src="{{ $img }}">
    @endforeach
</body>

</html>