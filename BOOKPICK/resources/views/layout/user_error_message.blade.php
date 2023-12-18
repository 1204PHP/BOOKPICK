@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="error-text">{{ $error }}</div>
    @endforeach
@endif