<?php

declare(strict_types=1);

namespace Pajak\Core\View;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Pajak\Core\Models\User;

final class UserMenu extends Component
{
    public readonly ?User $currentUser;

    public function __construct(Guard $guard, public string $popoverId = 'pajak-core-user-menu')
    {
        $authenticatable = $guard->user();
        $this->currentUser = $authenticatable instanceof User ? $authenticatable : null;
    }

    public function render(): View
    {
        return view('pajak-core::components.user-menu');
    }
}
