<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar semua karyawan.
     */
    public function index()
    {
        $employees = Employee::with('user')->latest('join_date')->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Menampilkan form untuk membuat akun karyawan baru.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Menyimpan akun karyawan baru dan men-generate password.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        DB::beginTransaction();
        try {
            $temporaryPassword = Str::random(10);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($temporaryPassword),
                'role' => 'employee',
            ]);

            // Buat entri kosong di tabel employees dan user_profiles
            Employee::create(['user_id' => $user->id]);
            $user->profile()->create();

            DB::commit();

            // Simpan kredensial di session untuk ditampilkan sekali saja
            session()->flash('generated_credentials', [
                'email' => $user->email,
                'password' => $temporaryPassword,
            ]);

            return redirect()->route('admin.employees.index');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat akun. Silakan coba lagi.']);
        }
    }

    /**
     * Menampilkan detail lengkap satu karyawan.
     */
    public function show(Employee $employee)
    {
        $employee->load(['user.profile', 'user.educationHistory']);
        return view('admin.employees.show', compact('employee'));
    }
}
