<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class SearchEmployeeController extends Controller
{

    public function index(Request $request, $param)
    {
        $roles = [
            'ppk' => 'PPK',
            'spi' => 'SPI',
            'staff' => 'STAF PPK',
            'admin' => 'ADMIN FAKULTAS/UNIT',
            'kpa' => 'KPA (REKTOR)',
            'treasurer' => 'BENDAHARA',
            'Pelaksana' => 'Pelaksana Kegiatan'
        ];
        return $this->search_function($request, $roles[$param]);
    }

    private function search_function($request, $param)
    {
        // dd($param, $request);
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default to 10 if not provided

        $ppkRole = Role::where('name', $param)->first();
        if ($ppkRole) {
            $query = User::query()
                ->whereHas('roles', function ($query) use ($ppkRole) {
                    $query->where('role_id', $ppkRole->id);
                })->leftJoin('employees', 'employees.user_id', 'users.id');

            if (!empty($search)) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
            }
            $treasurers = $query->limit($limit)->get(['users.id', 'name', 'employees.id as identity_number']);
        } else {
            $treasurers = [];
        }

        return response()->json($treasurers);
    }
}
