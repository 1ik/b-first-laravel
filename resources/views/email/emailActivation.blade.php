<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Bangladesh First!</title>
</head>
<body>
    <p>Hi {{$userData->name}}</p>
    <p>Welcome to Bangladesh First! To activate your account, please click the button below:</p>
    <p>
        <a href="{{ route('active-user-account', ['user' => $userData->id]) }}" target="_blank" style="padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Activate Account</a>
    </p>
    <p>Thank you for using Bangladesh First!</p>
</body>
</html>