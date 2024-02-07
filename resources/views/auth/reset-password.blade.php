<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        html,body { height: 100%; }

        body{
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            background-color: #f5f5f5;
        }

        form{
            padding-top: 10px;
            font-size: 14px;
            margin-top: 30px;
        }

        .card-title{ font-weight:400; }

        .btn{
            font-size: 14px;
            margin-top:40px;
        }

        .login-form{ 
            width:400px;
            height: 400px;
            margin:20px;
        }

        .sign-up{
            text-align:center;
            padding:20px 0 0;
        }

        span{
            font-size:14px;
        }
    </style>
</head>
<body>
    <div class="card login-form">
        <div class="card-body">
            <h3 class="card-title text-center">Reset password</h3>
            @if(session('success'))
                <div class="p-6">
                    <div class="border border-t-0 rounded-bottom p-1 text-success">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            <div class="card-text">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input id="exampleInputEmail1" type="email" name="email" class="form-control form-control-sm mt-2" value="{{old('email', $request->email)}}" required autofocus autocomplete="username" >
                        @error('email')
                          <p class="text-danger p-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" class="form-control form-control-sm mt-2" required autocomplete="new-password">
                        @error('password')
                        <p class="text-danger p-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control form-control-sm mt-2" name="password_confirmation" required autocomplete="new-password" >
                        @error('password_confirmation')
                        <p class="text-danger p-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-dark btn-block text-white">Reset password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>