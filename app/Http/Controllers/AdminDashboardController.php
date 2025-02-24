<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Retrieve users with the 'siswa' and 'bank_mini' roles
        $siswaUsers = Account::where('role', 'siswa')->get();
        $bankMiniUsers = Account::where('role', 'bank_mini')->get();
    
        // Calculate Total Transactions
        $totalTransactions = Transaction::count();
        
        // Calculate Completed/Approved Transactions
        $completedTransactions = Transaction::where('status', 'completed')->orWhere('status', 'approved')->count();
        
        // Calculate Pending Transactions
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        
        // Calculate Transfer Transactions (assuming there's a 'type' field or you can filter transfers)
        $transferTransactions = Transaction::where('type', 'transfer')->count();
    
        // Pass the data to the view
        return view('admin.dashboard', compact(
            'siswaUsers', 
            'bankMiniUsers', 
            'totalTransactions', 
            'completedTransactions', 
            'pendingTransactions', 
            'transferTransactions'
        ));
    }
    
    public function transactions()
    {
        // Retrieve all transactions
        $transactions = Transaction::with('account')->latest()->get();
        
        return view('admin.transaction', compact('transactions'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:siswa,bank_mini',
        ]);

        Account::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash password
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = Account::findOrFail($id);
        return view('admin.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required'
        ]);
    
        $user = Account::findOrFail($id);
        $user->update($request->all());
    
        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
    }
    
    public function destroy($id)
    {
        $user = Account::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Akun berhasil dihapus.');
    }
}