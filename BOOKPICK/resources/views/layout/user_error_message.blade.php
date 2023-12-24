@if ($errors->any())
    @foreach ($errors->all() as $error)
        <span class="error-text">{{ $error }}</span>
    @endforeach
@endif