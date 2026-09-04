<?php

declare(strict_types=1);

namespace Pajak\Core\Support;

use Illuminate\Contracts\Config\Repository;
use Pajak\Core\Modules\Module;

final readonly class CoreConfig
{
    public function __construct(private Repository $repository)
    {
    }

    public function appName(): string
    {
        return (string) $this->repository->get('pajak-core.app_name', 'App');
    }

    /**
     * @return array<int, class-string<Module>>
     */
    public function modules(): array
    {
        return array_values($this->repository->get('pajak-core.modules', []));
    }

    public function routePrefix(): string
    {
        return trim((string) $this->repository->get('pajak-core.route.prefix', 'admin'), '/');
    }

    public function routeDomain(): ?string
    {
        $domain = $this->repository->get('pajak-core.route.domain');

        return $domain === null ? null : (string) $domain;
    }

    /**
     * @return array<int, string>
     */
    public function middleware(string $group): array
    {
        return array_values($this->repository->get(sprintf('pajak-core.middleware.%s', $group), []));
    }

    /**
     * @return array<int, string>
     */
    public function locales(): array
    {
        return array_values($this->repository->get('pajak-core.locales', ['en']));
    }

    public function superadminRoleSlug(): string
    {
        return (string) $this->repository->get('pajak-core.authorization.superadmin_role', 'super_admin');
    }

    /**
     * @return array<string, array{name: string}>
     */
    public function systemRoles(): array
    {
        return $this->repository->get('pajak-core.authorization.system_roles', []);
    }

    public function syncAuthorizationOnMigrate(): bool
    {
        return (bool) $this->repository->get('pajak-core.authorization.sync_on_migrate', true);
    }

    public function invitationExpiresDays(): int
    {
        return (int) $this->repository->get('pajak-core.auth.invitations.expires_days', 7);
    }

    public function authGuard(): string
    {
        return (string) $this->repository->get('pajak-core.auth.guard', 'web');
    }

    public function passwordBroker(): string
    {
        return (string) $this->repository->get('pajak-core.auth.password_broker', 'users');
    }

    public function brandingLogo(): ?string
    {
        $logo = $this->repository->get('pajak-core.branding.logo');

        return $logo === null ? null : (string) $logo;
    }

    public function brandingFavicon(): ?string
    {
        $favicon = $this->repository->get('pajak-core.branding.favicon');

        return $favicon === null ? null : (string) $favicon;
    }

    public function brandingFontUrl(): ?string
    {
        $fontUrl = $this->repository->get('pajak-core.branding.font_url');

        return $fontUrl === null || $fontUrl === '' ? null : (string) $fontUrl;
    }
}
