@if(!auth()->check())
    {{-- <div class="bg-[#7D2B1D] h-[40px] w-[250px] rounded-lg bg-center bg-no-repeat bg-contain" style="background-image: url({{ asset('images/logoh.jpg') }})"></div> --}}
    <div class="bg-[#7D2B1D] h-[150px] w-[150px] rounded-lg bg-center bg-no-repeat bg-contain" style="background-image: url({{ asset('images/logo.jpg') }})"></div>
@else
    <div class="bg-[#7D2B1D] h-[40px] w-[250px] rounded-lg bg-center bg-no-repeat bg-contain" style="background-image: url({{ asset('images/logoh.jpg') }})"></div>
@endif