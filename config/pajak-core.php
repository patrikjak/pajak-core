<?php

declare(strict_types=1);

return [

    // Feature units (subclasses of Pajak\Core\Modules\Module) that are enabled. A module not
    // listed here contributes nothing: no routes, navigation, permissions, migrations, widgets,
    // settings or commands. Populated from Phase 1.
    'modules' => [],

    // Runtime toggles for sub-features inside modules (e.g. 'google_login', 'registration',
    // 'captcha'), read through Pajak\Core\Support\Features. Consumers may add their own keys.
    // Populated from Phase 1.
    'features' => [],

];
