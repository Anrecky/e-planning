<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function getHeads(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $limit = $request->input('limit', 10);

            $query = Employee::query()
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->limit($limit);

            if (!empty($search)) {
                $query->where('employees.id', 'LIKE', "%{$search}%");
                $query->orWhere('users.name', 'LIKE', "%{$search}%");
            }
            $heads = $query->get(['employees.id', 'users.name']);
            return response()->json($heads);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal menarik data pegawai');
        }
    }

    public function searchPPK(Request $request)
    {
        try {;
            $res = $this->search($request->input('search', ''), $request->input('limit', 10), 'PPK');
            return response()->json($res);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal menarik data pegawai');
        }
    }
    public function searchTreasurer(Request $request)
    {
        try {;
            $res = $this->search($request->input('search', ''), $request->input('limit', 10), 'BENDAHARA');
            return response()->json($res);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal menarik data pegawai');
        }
    }
    public function searchPelaksana(Request $request)
    {
        try {;
            $res = $this->search($request->input('search', ''), $request->input('limit', 10), false);
            return response()->json($res);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal menarik data pegawai');
        }
    }

    public function searchPengikut(Request $request)
    {
        try {;
            $res = $this->search($request->input('search', ''), $request->input('limit', 10), false, $request->input('pelaksana'));
            return response()->json($res);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal menarik data pegawai');
        }
    }
    private function search($search, $limit, $role = false, $ex_role = false)
    {
        $query = Employee::with('user')->select('employees.id', 'employees.user_id', 'users.name')
            ->join('users', 'employees.user_id', 'users.id')->limit($limit);
        if (!empty($search)) {
            $query->where('employees.id', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }
        if (!empty($ex_role)) {
            $query->where('employees.user_id', '<>', $ex_role);
        }

        if (!empty($role)) {
            $ppkRole = Role::where('name', $role)->first();
            if ($ppkRole) {
                $query->whereHas('user', function ($q) use ($ppkRole) {
                    $q->whereHas('roles', function ($r) use ($ppkRole) {
                        $r->where('role_id', $ppkRole->id);
                    });
                });
            }
        }

        return $query->get(['employees.id', 'users.name']);
    }
}
