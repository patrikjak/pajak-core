@foreach($navigation()->groups() as $group)
    @if($group->label !== null)
        <x-pajak::sidebar-section :label="__($group->label)" />
    @endif

    @foreach($group->items as $item)
        <x-pajak::sidebar-item
            :href="$item->href"
            :label="__($item->label)"
            :active="$item->active"
        >
            @if($item->icon !== null)
                <x-slot:icon>@svg($item->icon)</x-slot:icon>
            @endif

            @foreach($item->children as $child)
                <x-pajak::sidebar-sub-item :href="$child->href" :label="__($child->label)" :active="$child->active" />
            @endforeach
        </x-pajak::sidebar-item>
    @endforeach
@endforeach
