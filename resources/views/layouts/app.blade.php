<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Include jQuery before other scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Other script includes ... -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>



    <!-- DataTables Bootstrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- AdminLTE  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">

    <!-- SmartMenus Bootstrap -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/smartmenus@1.1.0/dist/addons/bootstrap/jquery.smartmenus.bootstrap.css">



    <!-- Bootstrap Timepicker -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-timepicker@0.5.2/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowplayer/5.4.6/skin/all-skins.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.0/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.10/dist/select2-bootstrap.min.css">

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <!-- JSZip for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.8.0/jszip.min.js"></script>

    <!-- pdfMake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

    <!-- Buttons HTML5 for export options -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>


    <!-- IntlTelInput -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.12/build/css/intlTelInput.css">


    <!-- Include SweetAlert2 JS -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    :root:has(#pink:checked) {
        --background: #e663b8;
        --txt: #fff;
        --secondary: #fff;
        --title: #3C3D37;
    }

    :root:has(#red:checked) {
        --background: #e34057;
        --txt: #fff;
        --secondary: #fff;
        --title: #3C3D37;
    }

    :root:has(#dark:checked) {
        --background: #3C3D37;
        --txt: #ECDFCC;
        --secondary: #1E201E;
        --title: #ECDFCC;
        
    }

    :root:has(#blue:checked) {
        --background: #5B99C2;
        --txt: #fff;
        --secondary: #fff;
        --title: #3C3D37;
    }

    :root:has(#green:checked) {
        --background: #55AD9B;
        --txt: #fff;
        --secondary: #fff;
        --title: #3C3D37;
    }

    :root:has(#light:checked) {
        --background: white;
        --txt: #807e7e;
        --secondary: white;
        --title: #3C3D37;
    }

    :root {
        --background: #e663b8;
        --txt: #fff;
        --secondary: #fff;
        --title: #3C3D37;
    }

    body{
        background-color: var(--secondary) !important;
    }

    /* e663b8 */







    nav,
    .navbar-brand,
    .nav-link,
    .dropdown-item {

        color: var(--background) !important;

    }

    .navbar {
        box-shadow: 0 0 10px var(--txt) !important;
        background-color: var(--background) !important ;
     
    }

    #logo {
        object-fit: contain;

    }

    hr {
        background-color: rgba(0, 0, 0, .125);
    }

    input {
        border-radius: 5px;
        border: 1px #ccc;
    }

    #navbarSupportedContent {
        display: flex;
        justify-content: flex-end;
        margin-left: auto;
        /* Align to the right */

    }



    .card {
        background: var(--background) !important;
    }

    .card-body {
        padding: 30px;
        color: var(--background) !important;
        background-color: var(--txt) !important;
    }

    td,
    th {
        border-bottom: 1px solid #767675 !important;

        text-align: center;
    }

    .color-picker {
        display: none !important;
    }

    :root {
        --theadColor: var(--background);
    }

    body {
        font-family: "Open Sans", sans-serif;
    }

    table.dataTable {
        box-shadow: #bbbbbb 0px 0px 5px 0px;
    }

    thead {
        background-color: var(--theadColor);

    }

    thead>tr,
    thead>tr>th {
        background-color: transparent;
        color: #fff;
        font-weight: normal;
        text-align: start;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        border-bottom: 0px solid #111 !important;
    }

    .dataTables_wrapper>div {
        margin: 5px;
    }

    table.dataTable.display tbody tr.even>.sorting_1,
    table.dataTable.order-column.stripe tbody tr.even>.sorting_1 table.dataTable.display tbody tr.even,
    table.dataTable.display tbody tr.odd>.sorting_1,
    table.dataTable.order-column.stripe tbody tr.odd>.sorting_1,
    table.dataTable.display tbody tr.odd {
        background-color: #ffffff;
    }

    table.dataTable thead th {
        position: relative;
        background-image: none !important;
    }

    table.dataTable thead th.sorting:after,
    table.dataTable thead th.sorting_asc:after,
    table.dataTable thead th.sorting_desc:after {
        position: absolute;
        top: 12px;
        right: 8px;
        display: block;
        font-family: "Font Awesome\ 5 Free";
    }

    table.dataTable thead th.sorting:after {
        content: "\f0dc";
        color: #ddd;
        font-size: 0.8em;
        padding-top: 0.12em;
    }

    table.dataTable thead th.sorting_asc:after {
        content: "\f0de";
    }

    table.dataTable thead th.sorting_desc:after {
        content: "\f0dd";
    }

    table.dataTable.display tbody tr:hover>.sorting_1,
    table.dataTable.order-column.hover tbody tr:hover>.sorting_1 {
        background-color: #f2f2f2 !important;
        color: #000;
    }

    tbody tr:hover {
        background-color: #f2f2f2 !important;
        color: #000;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: none !important;
        border-radius: 50px;
        background-color: var(--theadColor) !important;
        color: #fff !important
    }

    .paginate_button.current:hover {
        background: none !important;
        border-radius: 50px;
        background-color: var(--theadColor) !important;
        color: #fff !important
    }



    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {

        border: 1px solid #979797;
        background: none !important;
        border-radius: 50px !important;
        background-color: #000 !important;
        color: #fff !important;
    }

    select {
        color: #767675 !important;
        border-color: #767675 !important;
    }

    .btn {
        background: var(--background) !important;
        color: var(--txt) !important;
    }

    .form-check-input {
        border-color: var(--background) !important;
    }

    .form-control {
        border-color: var(--background) !important;
    }

    .color-picker>fieldset {
        border: 0;
        display: flex;
        gap: 2rem;
        width: fit-content;

        padding: 1rem 3rem;
        margin-inline: auto;
        border-radius: 0 0 1rem 1rem;
    }

    .color-picker input[type="radio"] {
        appearance: none;
        width: 1.5rem;
        height: 1.5rem;
        outline: 3px solid var(--radio-color, currentColor);
        outline-offset: 3px;
        border-radius: 50%;
    }
    </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md p-3"  >
            <a class="navbar-brand" href="{{ route('home') }}" id="smile-nav" style="color: var(--txt) !important; " >
                <i class=" ml-5 mr-1 fa fa-teeth" aria-hidden="true"> </i> Smile Clinic
            </a>
            <div class="container" >

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown mr-auto" >
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:void(0)"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                v-pre style="color: var(--txt) !important;">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="background-color: var(--background) !important;">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="color: var(--txt) !important; background-color: var(--background);">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <form class="color-picker " action="">
            <fieldset>
                <legend class="visually-hidden">Pick a color scheme</legend>
                <label for="pink" class="visually-hidden">Pink theme</label>
                <input type="radio" id="pink" name="theme">

                <label for="red" class="visually-hidden">red</label>
                <input type="radio" name="theme" id="red" checked>

             
                <label for="blue" class="visually-hidden">Blue theme</label>
                <input type="radio" id="blue" name="theme">

                <label for="green" class="visually-hidden">Green theme</label>
                <input type="radio" id="green" name="theme">

                <label for="dark" class="visually-hidden">Dark theme</label>
                <input type="radio" id="dark" name="theme">
                <label for="light" class="visually-hidden">Light theme</label>
                <input type="radio" id="light" name="theme">

            </fieldset>
        </form>
        <main class="py-3 container">
            @yield('content')
        </main>
    </div>
    <script>
    const colorThemes = document.querySelectorAll('[name="theme"]');

    // store theme
    const storeTheme = function(theme) {
        localStorage.setItem("theme", theme);
    };

    // set theme when visitor returns
    const setTheme = function() {
        const activeTheme = localStorage.getItem("theme");
        colorThemes.forEach((themeOption) => {
            if (themeOption.id === activeTheme) {
                themeOption.checked = true;
            }
        });
        // fallback for no :has() support
        document.documentElement.className = activeTheme;
    };

    colorThemes.forEach((themeOption) => {
        themeOption.addEventListener("click", () => {
            storeTheme(themeOption.id);
            // fallback for no :has() support
            document.documentElement.className = themeOption.id;
        });
    });

    document.onload = setTheme();
    </script>


</body>

</html>