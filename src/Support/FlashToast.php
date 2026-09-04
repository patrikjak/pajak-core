<?php

declare(strict_types=1);

namespace Pajak\Core\Support;

use Illuminate\Contracts\Session\Session;
use Pajak\Ui\Common\Dto\ToastData;

final readonly class FlashToast
{
    public function __construct(private Session $session)
    {
    }

    public function flash(ToastData $toast): void
    {
        $this->session->flash('toast', [
            'type' => $toast->type->value,
            'title' => $toast->title,
            'message' => $toast->message,
        ]);
    }
}
