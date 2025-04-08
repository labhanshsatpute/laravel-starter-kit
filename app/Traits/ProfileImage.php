<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;

trait ProfileImage
{
    public function generateAdminProfile() {

        if (!Storage::disk('local')->exists('admins/profile-image')) {
            Storage::disk('local')->makeDirectory('admins/profile-image');
        }

        $avatar = new Avatar();
        $path =  "admins/profile-image/".Str::random(40).".png";
        $avatar->create($this->name)
            ->setTheme('colorful')
            ->setChars(1)
            ->setShape('square')
            ->setBorder(0, '#fff', 10)
            ->setFontSize(42)
            ->save(storage_path('app/'.$path), 100);
        $this->profile_image = $path;
        $this->save();
    }

    public function generateUserProfile() {

        if (!Storage::disk('local')->exists('users/profile-image')) {
            Storage::disk('local')->makeDirectory('users/profile-image');
        }

        $avatar = new Avatar();
        $path =  "users/profile-image/".Str::random(40).".png";
        $avatar->create($this->name)
            ->setTheme('colorful')
            ->setChars(1)
            ->setShape('square')
            ->setBorder(0, '#fff', 10)
            ->setFontSize(42)
            ->save(storage_path('app/'.$path), 100);
        $this->profile_image = $path;
        $this->save();
    }

}