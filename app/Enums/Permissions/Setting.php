<?php 

namespace App\Enums\Permissions;

enum Setting: string
{
    case ROLES_AND_PERMISSION = 'ROLES_AND_PERMISSION';
    case APPLICATION_SETTING = 'APPLICATION_SETTING';
    case SYSTEM_PREFRENCES = 'SYSTEM_PREFRENCES';
    
    public function label(): string {
        return ucwords(str_replace('_',' ',strtolower($this->name)));
    }
}