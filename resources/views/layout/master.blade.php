<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6 mx-auto mt-2">
                <div class="my-3">
                    <nav class="navbar navbar-expand-sm bg-light">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="/product" class="nav-link home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link add">Add product</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div id="content-page">
                    @yield('main')
                </div>

            </div>
        </div>
    </div>

</body>
<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/utils.js"></script>
@yield('script')

</html>