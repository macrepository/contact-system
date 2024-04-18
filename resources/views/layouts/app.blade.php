@include('includes.header')

<main class="container">
    <div>
        @include('includes.messages')
    </div>
    @yield('content')
</main>

@include('includes.footer')