<?php

declare(strict_types=1);

namespace Pajak\Core\Models\Concerns;

use Pajak\Core\Models\Invitation;
use Pajak\Core\Models\Permission;
use Pajak\Core\Models\Role;
use Pajak\Core\Models\Setting;
use Pajak\Core\Models\User;
use Pajak\Core\Support\Models;

trait ResolvesCoreModels
{
    /**
     * @return class-string<User>
     */
    protected function userModel(): string
    {
        return $this->coreModels()->userClass();
    }

    /**
     * @return class-string<Role>
     */
    protected function roleModel(): string
    {
        return $this->coreModels()->roleClass();
    }

    /**
     * @return class-string<Permission>
     */
    protected function permissionModel(): string
    {
        return $this->coreModels()->permissionClass();
    }

    /**
     * @return class-string<Invitation>
     */
    protected function invitationModel(): string
    {
        return $this->coreModels()->invitationClass();
    }

    /**
     * @return class-string<Setting>
     */
    protected function settingModel(): string
    {
        return $this->coreModels()->settingClass();
    }

    private function coreModels(): Models
    {
        return app(Models::class);
    }
}
