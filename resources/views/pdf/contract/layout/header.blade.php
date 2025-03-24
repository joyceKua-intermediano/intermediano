<div class="header">
    @if($is_pdf)
    <img src="{{ public_path('images/logo.jpg') }}" alt="Logo">
    @else
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    @endif
    <div class="header-title">
        {{ $company }}
    </div>
</div>
