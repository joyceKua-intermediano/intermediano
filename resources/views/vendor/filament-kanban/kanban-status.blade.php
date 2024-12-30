@props(['status'])

<div class="md:w-[24rem] flex-shrink-0 flex flex-col" style="width:15.5%; min-width: 240px; height: 74vh">
    @include(static::$headerView)

    <div
        teste="kanban-status"
        data-status-id="{{ $status['id'] }}"
        class="flex flex-col flex-grow overflow-y-auto gap-2 p-3 mx-3 bg-gray-200 dark:bg-gray-800 rounded-xl  h-[900px]"
    >
        @foreach($status['records'] as $record)
            @include(static::$recordView)
        @endforeach
    </div>
</div>
