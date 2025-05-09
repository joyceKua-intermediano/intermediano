<div class="footer">
    <div class="footer-title">
        <b style='line-height: 1.2 !important'>{{ $footerDetails['companyName'] }}</b>
        <p style='line-height: 1.2 !important' class="footer-address">{{  $footerDetails['address'] }}</p>
        <p style='line-height: 1.2 !important'>{{  $footerDetails['domain'] }}</p>
        <p style='line-height: 1.2 !important'>{{  $footerDetails['mobile'] }}</p>
        {{-- @if ($company !== 'Intermediano S.A.S.')
        <p>Rua Mario Covas Junior 215/504, Barra da Tijuca</p>
        <p>Rio de Janeiro, RJ - CEP: 22.631-030, Brasil</p>
        @endif
        <p>www.intermediano.com</p> --}}
    </div>
    @if($is_pdf)
    <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" style="height: 50px;">
    @else
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 50px;">
    @endif
</div>
