<div id="messages-area">
    @if(isset($errors) && $errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-warning">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (session('error'))
        @if (is_array(session('error')))
            @foreach (session('error') as $message)
                <div class="alert alert-warning">
                    {{ $message }}
                </div>
            @endforeach
        @else
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif
    @endif

    @if (session('success'))
        @if (is_array(session('success')))
            @foreach (session('success') as $message)
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endforeach
        @else
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    @endif
</div>