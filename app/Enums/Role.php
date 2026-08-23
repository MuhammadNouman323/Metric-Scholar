<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Faculty = 'faculty';
    case Student = 'student';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Faculty => 'Faculty',
            self::Student => 'Student',
        };
    }

    public function dashboardRoute(): string
    {
        return match ($this) {
            self::Admin => '/admin/dashboard',
            self::Faculty => '/faculty/dashboard',
            self::Student => '/student/dashboard',
        };
    }
}
