<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Social Login</div>
                    <div class="card-body">
                        <a href="{{ url('login/facebook') }}" class="btn btn-primary mb-3">Login with Facebook</a>
                        <a href="{{ url('auth/google/redirect') }}" class="btn btn-danger mb-3" id="googleLoginBtn">Login with Google</a>
                        <a href="{{ url('login/github') }}" class="btn btn-dark mb-3">Login with GitHub</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //   $('#googleLoginBtn').click(function(e) {
        //     e.preventDefault(); 
        //     alert('33');    
        //     $.ajax({
        //         url: '/auth/google/redirect',
        //         type: 'GET',
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             console.log(response);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Error:', error);
        //         }
        //     });
        // });
    </script>
</body>
</html>