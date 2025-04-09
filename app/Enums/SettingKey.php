<?php 

namespace App\Enums;

enum SettingKey:string 
{
    case APPLICATION_NAME = "APPLICATION_NAME";
    case APPLICATION_SUMMARY = "APPLICATION_SUMMARY";
    case APPLICATION_LOGO = "APPLICATION_LOGO";
    case APPLICATION_FAVICON = "APPLICATION_FAVICON";

    public function label(): string {
        return ucwords(str_replace('_',' ',strtolower($this->name)));
    }
}