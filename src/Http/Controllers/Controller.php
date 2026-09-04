<?php

declare(strict_types=1);

namespace Pajak\Core\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Translation\Translator;
use Pajak\Core\Models\User;
use Pajak\Core\Support\FlashToast;

abstract class Controller
{
    protected readonly ?User $user;

    public function __construct(
        protected readonly UrlGenerator $urlGenerator,
        protected readonly Application $application,
        protected readonly Translator $translator,
        protected readonly FlashToast $flashToast,
        Guard $guard,
    ) {
        $authenticatable = $guard->user();
        $this->user = $authenticatable instanceof User ? $authenticatable : null;
    }
}
