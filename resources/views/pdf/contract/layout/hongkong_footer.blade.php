<div class="footer" style="height: 60px !important">
    <div class="footer-title">
        <b>{{ $company }}</b>
        <p> Flat A11/F. Cheung Lung Ind Bldg 10 Cheung Yee ST,</p>
        <p> Cheung Sha Wan, Hong Kong</p>
        <p>www.intermediano.com</p>
    </div>
    @if($is_pdf)
    <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" style="height: 50px;">
    @else
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 50px;">
    @endif
</div>