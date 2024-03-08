<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    public function getFormattedNameAttribute()
    {
        $roles = [
            'admin' => 'Admin',
            'operator' => 'Operator',
            'revenue_treasurer' => 'Bendahara Penerimaan',
            'asset_manager' => 'Pengelola Aset',
            'ppk_staff' => 'Staf PPK',
        ];

        return $roles[$this->name] ?? $this->name;
    }
}
