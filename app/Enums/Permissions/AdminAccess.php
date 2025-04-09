<?php 

namespace App\Enums\Permissions;

enum AdminAccess: string
{
    case VIEW = 'VIEW';
    case ADD = 'ADD';
    case EDIT = 'EDIT';
    case DELETE = 'DELETE';
    
    public function label(): string {
        return ucwords(str_replace('_',' ',strtolower($this->name)));
    }
}