<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'dob',
        'address',
        'phone',
        'identity_number',
        'identity_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Get the users not having role admin
    public function scopeNotAdmin($query): void
    {
        $query->withoutRole('SUPER ADMIN PERENCANAAN');
    }

    // Get relationship of employee, user that has type of employee (has nik/nip/nidn,position,work unit)
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function employee_staff(): HasOne
    {
        return $this->hasOne(Employee::class)->with('headOf');
    }
}
