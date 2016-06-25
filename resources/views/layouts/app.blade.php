<!DOCTYPE html>
<html lang="en">
<head>
    @include('elements.head')
</head>
<body class="hold-transition skin-blue sidebar-mini" id="app">
<div class="wrapper">


    @include('elements.sidebar')

    @include('elements.header')

    <div class="content-wrapper">

        <section class="content-header">
            @yield('breadcrumbs')
        </section>

        @yield('content')

    </div>


    @include('elements.footer')

    @include('elements.scripts')

</div>
</body>
</html>
