@if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

@if ($errors->any())
    <div class="alert-error">
        @foreach ($errors->all() as $error)
            {{ $error }} <br>
        @endforeach
    </div>
@endif
