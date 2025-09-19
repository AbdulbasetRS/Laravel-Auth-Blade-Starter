<?php

namespace App\Enums;

enum UserType: string
{
    case User     = 'user';
    case Admin    = 'admin';
    case IT       = 'it';
    case Tester   = 'tester';
    case Employee = 'employee';
}
