<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Let start</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6 mx-auto mt-2">
                <form class="text-center border border-light p-5" id="form1">
                    @csrf
                    <p class="h4 mb-4">Login</p>
                    <input type="text" class="form-control mb-4" placeholder="Username" id="username">
                    <input type="password" class="form-control mb-4" placeholder="Password" id="password">
                    <p class="text-left text-danger error d-none">&nbsp;</p>
                    <button class="btn btn-success btn-block my-4 sign-in1" type="submit">Sign in</button>
                    <p><a href="#" class="txt-primary sign-up1">Sign up an account</a></p>
                </form>
                <form class="text-center border border-light p-5 d-none" id="form2">
                    @csrf
                    <p class="h4 mb-4">Sign up an account</p>
                    <input type="text" class="form-control mb-4" placeholder="Username" id="username2">
                    <input type="password" class="form-control mb-4" placeholder="Password" id="password2">
                    <p class="text-left text-danger error d-none">&nbsp;</p>
                    <button class="btn btn-success btn-block my-4 sign-up2" type="submit">Sign up</button>
                    <p><a href="#" class="txt-primary sign-in2">Sign in</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/utils.js"></script>
<script src="/js/login.js"></script>
<script>
    $(document).ready(function() {
        $('.sign-up1').on('click', function(e) {
            e.preventDefault();
            $('.error').empty();
            $('#form1').addClass('d-none');
            $('#form2').removeClass('d-none');
        });
        $('.sign-in2').on('click', function(e) {
            e.preventDefault();
            $('#form1').removeClass('d-none');
            $('#form2').addClass('d-none');
        });

        // Dang ki user
        $('.sign-up2').on('click', function(e) {
            e.preventDefault();
            let username = $('#username2').val();
            let password = $('#password2').val();
            $.ajax({
                url: '/api/user/signup',
                method: 'post',
                data: {
                    username: username,
                    password: password
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#form1').removeClass('d-none');
                        $('#form2').addClass('d-none');
                    } else {
                        console.log(response);
                        let error = response.error;
                        $('.error').removeClass('d-none');
                        $('.error').text(response.error);
                    }
                }
            });
        });
    });
</script>

</html>