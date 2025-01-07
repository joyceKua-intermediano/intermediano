<div class="grid grid-cols-2 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6 mt-6">
    @foreach ($this->getHeaderWidgets() as $widget)
        @if ($widget === \App\Filament\Widgets\StatsDashboard::class)
            <div class="col-span-full	 xl:col-span-full	">
                @livewire($widget)
            </div>
        @else
            <div class="col-span-1">
                @livewire($widget)
            </div>
        @endif
    @endforeach
</div>
