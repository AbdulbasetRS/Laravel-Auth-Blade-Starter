<?php

namespace App\Services\Google;

class GoogleService
{
    public function auth(): GoogleAuthService
    {
        return new GoogleAuthService();
    }

    public function drive(): GoogleDriveService
    {
        return new GoogleDriveService();
    }
}
