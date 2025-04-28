<div class="footer" style="height: 60px !important">
    <div class="footer-title">
        <b>{{ $company }}</b>
        <p> 4388 Rue Saint-Denis Suite200 #763, Montreal, QC H2J 2L1, Canada</p>
        <p>www.intermediano.com</p>
        <p>+1 514 907 5393 </p>
    </div>
    @if($is_pdf)
    <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" style="height: 50px;">
    @else
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 50px;">
    @endif
</div>