<!DOCTYPE html>
<html>
<head>
    <title>Activation Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
       @if(session('message'))
           <h1>{{ session('message') }}</h1>
        @endif
        
    </div>
</body>
</html>
