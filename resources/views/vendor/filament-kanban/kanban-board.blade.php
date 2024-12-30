<x-filament-panels::page>
    {{-- <div x-data wire:ignore.self id="kanban-board" class="md:flex overflow-x-auto overflow-y-hidden gap-4 pb-4"> --}}
    <div x-data wire:ignore.self id="" class="md:flex md:space-x-2">
        @foreach($statuses as $status)
            @include(static::$statusView) 
        @endforeach

        <div wire:ignore>
            @include(static::$scriptsView)
        </div>
    </div>

    @unless($disableEditModal)
        <x-filament-kanban::edit-record-modal/>
    @endunless
</x-filament-panels::page>
