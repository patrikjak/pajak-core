<?php

declare(strict_types=1);

use Pajak\Core\Http\Middleware\AuthenticateAdmin;
use Pajak\Core\Http\Middleware\EnsureUserIsActive;
use Pajak\Core\Http\Middleware\RedirectIfAuthenticatedAdmin;
use Pajak\Core\Models\Invitation;
use Pajak\Core\Models\Permission;
use Pajak\Core\Models\Role;
use Pajak\Core\Models\Setting;
use Pajak\Core\Models\User;
use Pajak\Core\Modules\Dashboard\DashboardModule;

return [

    'app_name' => env('APP_NAME', 'App'),

    // Feature units (subclasses of Pajak\Core\Modules\Module) that are enabled. A module not
    // listed here contributes nothing: no routes, navigation, permissions, migrations, widgets,
    // settings or commands. Auth/Users/Roles/Profile/Settings modules are added in later phases.
    'modules' => [
        DashboardModule::class,
    ],

    // Maps the five core models to their concrete classes. Consumers may point any of these at a
    // subclass (registered here plus, for the user, auth.providers.users.model) to add columns or
    // behaviour without replacing core code.
    'models' => [
        'user' => User::class,
        'role' => Role::class,
        'permission' => Permission::class,
        'invitation' => Invitation::class,
        'setting' => Setting::class,
    ],

    'route' => [
        'prefix' => env('PAJAK_CORE_ROUTE_PREFIX', 'admin'),
        'domain' => env('PAJAK_CORE_ROUTE_DOMAIN'),
    ],

    'middleware' => [
        'web' => ['web'],
        'auth' => [AuthenticateAdmin::class, EnsureUserIsActive::class],
        'guest' => [RedirectIfAuthenticatedAdmin::class],
        'api' => ['throttle:60,1'],
    ],

    // Runtime toggles for sub-features inside modules, read through Pajak\Core\Support\Features.
    // Consumers may add their own keys and use the @feature directive / EnsureFeatureEnabled
    // middleware with them.
    'features' => [
        'password_reset' => true,
        'invitations' => true,
        'registration' => env('PAJAK_CORE_FEATURE_REGISTRATION', false),
        'google_login' => env('PAJAK_CORE_FEATURE_GOOGLE_LOGIN', false),
        'captcha' => env('PAJAK_CORE_FEATURE_CAPTCHA', false),
    ],

    'auth' => [
        'guard' => 'web',
        'password_broker' => 'users',
        'login_max_attempts' => 5,
        'registration' => ['default_role' => null],
        'invitations' => ['expires_days' => 7],
        'captcha' => [
            'site_key' => env('TURNSTILE_SITE_KEY'),
            'secret_key' => env('TURNSTILE_SECRET_KEY'),
        ],
    ],

    'authorization' => [
        'system_roles' => [
            'super_admin' => ['name' => 'Super admin'],
            'admin' => ['name' => 'Admin'],
        ],
        'superadmin_role' => 'super_admin',
        'sync_on_migrate' => true,
        'cache_ttl' => 3600,
    ],

    'branding' => [
        'logo' => null,
        'favicon' => null,

        // <link> pulled into the admin/auth <head> for the pajak/ui type family (Outfit).
        // Set to null to self-host or use a different font.
        'font_url' => env(
            'PAJAK_CORE_FONT_URL',
            'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap',
        ),
    ],

    'locales' => ['en', 'sk', 'cs'],

];
