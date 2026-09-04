@use('Pajak\Ui\Common\Enums\Popover\PopoverPlacement')
@use('Pajak\Ui\Common\Enums\AvatarSize')

@if($currentUser !== null)
    <button
        type="button"
        class="pajak-core-user-menu"
        data-pajak-popover-trigger="{{ $popoverId }}"
        aria-haspopup="true"
    >
        <x-pajak::avatar :initials="$currentUser->initials()" :size="AvatarSize::Sm" />

        <span class="pajak-core-user-menu__identity">
            <span class="pajak-core-user-menu__name">{{ $currentUser->fullName() }}</span>
            <span class="pajak-core-user-menu__email">{{ $currentUser->email }}</span>
        </span>
    </button>

    <x-pajak::popover :id="$popoverId" :placement="PopoverPlacement::Top" :dismissible="false">
        <div class="pajak-core-user-menu-pop">
            @if(Route::has('pajak-core.profile.edit'))
                <a href="{{ route('pajak-core.profile.edit') }}">
                    <x-heroicon-o-user-circle width="16" height="16" aria-hidden="true" />
                    {{ __('pajak-core::navigation.profile') }}
                </a>
            @endif

            @if(Route::has('pajak-core.auth.logout'))
                <form method="POST" action="{{ route('pajak-core.auth.logout') }}">
                    @csrf
                    <button type="submit">
                        <x-heroicon-o-arrow-right-on-rectangle width="16" height="16" aria-hidden="true" />
                        {{ __('pajak-core::navigation.logout') }}
                    </button>
                </form>
            @endif
        </div>
    </x-pajak::popover>
@endif
