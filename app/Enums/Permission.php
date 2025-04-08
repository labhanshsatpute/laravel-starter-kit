<?php 

namespace App\Enums;

enum Permission: string
{
    case VIEW_ACCESS = 'VIEW_ACCESS';
    case ADD_ACCESS = 'ADD_ACCESS';
    case EDIT_ACCESS = 'EDIT_ACCESS';
    case DELETE_ACCESS = 'DELETE_ACCESS';

    case MANAGE_ROLES_AND_PERMISSION = 'MANAGE_ROLES_AND_PERMISSION';

    public function label(): string {
        return ucwords(str_replace('_',' ',strtolower($this->name)));
    }
}