<div class="pajak-core-page-header">
    @if(count($breadcrumbs) > 0)
        <x-pajak::breadcrumbs :items="$breadcrumbs" />
    @endif

    <div class="pajak-core-page-header__row">
        <div>
            @if($title !== '')
                <h1 class="pajak-core-page-header__title">{{ $title }}</h1>
            @endif

            @if($description !== null)
                <p class="pajak-core-page-header__description">{{ $description }}</p>
            @endif
        </div>

        @isset($actions)
            <div class="pajak-core-page-header__actions">{{ $actions }}</div>
        @endisset
    </div>
</div>
