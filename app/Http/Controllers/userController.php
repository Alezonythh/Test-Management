<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        }
    
        $users = $query->paginate(10);
        return view('users.index', compact('users'));
    }


    public function create()
    {
   
    }

    /**
     * Store a newly created user in the database.
     */
    public function store(Request $request)
    {
        // Validasi data
            $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Simpan data pengguna
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); 
        return view('users.edit', compact('user')); 
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6', // Password tidak wajib diisi
        ]);
    
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);
    
        // Update data user
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
        ]);
    
        // Redirect dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from the database.
     */
    public function destroy(User $user)
    {
        $user->delete(); // Delete the user
        return redirect()->route('users.index')->with('success', 'User Berhasil Dihapus.');
    }
}