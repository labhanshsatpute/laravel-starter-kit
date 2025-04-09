<?php 

namespace App\Enums\Permissions;

enum PermissionGroup: string
{
    case ADMIN_ACCESS = 'ADMIN_ACCESS';
    case SETTINGS = 'SETTINGS';

    public function label(): string {
        return ucwords(str_replace('_',' ',strtolower($this->name)));
    }
}