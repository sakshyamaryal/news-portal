<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <h1>Welcome, {{ $name }}!</h1>
    <p>Thank you for joining us. Please visit the following link to get started:</p>
    <a href="{{ $url }}">{{ $url }}</a>
</body>
</html>
