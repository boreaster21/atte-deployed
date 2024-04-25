<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">Atte</a>
            @yield('nav')
        </div>

    </header>

    <main class='main'>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer__inner">
            <a href="/" class="footer__logo">Atte, inc.</a>
        </div>
    </footer>
</body>

</html>