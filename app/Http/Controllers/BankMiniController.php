<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Menyesuaikan dengan model User

class BankMiniController extends Controller
{
    // Show all siswa data
    public function index()
    {
        // Retrieve users with the 'siswa' and 'bank_mini' roles
        $siswaUsers = Account::where('role', 'siswa')->get(); // Assuming 'role' column in users table
        $transactions = Transaction::whereDate('created_at', now()->toDateString())->get();
        $transactionCount = $transactions->count();
        $totalTransfers = Transaction::whereDate('created_at', now()->toDateString())
                                ->where('type', 'transfer')
                                ->sum('amount'); // Sum of all transfer amounts today

        $topupRequests = Transaction::with('account') // Eagerly load the related account (student)
                                ->where('status', 'pending')
                                ->get();

        $transactionHistory = Transaction::orderBy('created_at', 'desc')->get();  // All historical transactions

                                
        // Pass the data to the view
        return view('bank_mini.dashboard', compact('siswaUsers', 'transactions', 'transactionCount', 'totalTransfers', 'topupRequests', 'transactionHistory'));
    }

    // Show daily transaction report
    public function transactionHistory()
{
    // Retrieve today's transactions
    $transactions = Transaction::whereDate('created_at', now()->toDateString())->get();

    // Pass the data to the view
    return view('bank_mini.transaction-history', compact('transactions'));
}

    

    // Top-up balance for siswa
    public function topUp(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);
    
        $account = Account::findOrFail($id);
        $account->saldo += $validated['amount'];
        $account->save();
    
        // Create transaction record - account_id must be provided
        Transaction::create([
            'account_id' => $account->id,  // Use account id directly
            'type' => 'topup',
            'amount' => $validated['amount'],
            'status' => 'completed'
        ]);
    
        return redirect()->back()->with('success', 'Top-up successful');
    }
    
    // Withdraw balance for siswa
    public function withdraw(Request $request, $id)
{
    $request->validate([
        'amount' => 'required|numeric|min:1'
    ]);

    $account = Account::findOrFail($id);

    if ($account->saldo < $request->amount) {
        return redirect()->back()->with('error', 'Insufficient balance!');
    }

    $account->saldo -= $request->amount;
    $account->save();

    // Save transaction - account_id must be provided
    Transaction::create([
        'account_id' => $account->id, // Correct field name is account_id
        'type' => 'withdraw',
        'amount' => $request->amount,
        'status' => 'completed',
    ]);

    return redirect()->back()->with('success', 'Withdrawal successful!');
}


    // Transfer balance from one user to another
    public function transfer(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'recipient_id' => 'required|exists:accounts,id', // Validates recipient exists in accounts table
        ]);
    
        $senderAccount = Account::findOrFail($id);
        $recipientAccount = Account::findOrFail($request->recipient_id);
    
        if ($senderAccount->saldo < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance!');
        }
    
        // Perform transfer
        $senderAccount->saldo -= $request->amount;
        $recipientAccount->saldo += $request->amount;
        $senderAccount->save();
        $recipientAccount->save();
    
        // Save transaction - both account_id and recipient_id must be provided
        Transaction::create([
            'account_id' => $senderAccount->id, // Sender's account_id
            'recipient_id' => $recipientAccount->id, // Recipient's account_id
            'type' => 'transfer',
            'amount' => $request->amount,
            'status' => 'completed',
        ]);
    
        return redirect()->back()->with('success', 'Transfer successful!');
    }

    public function approveTopUp($id)
    {
        // Find the top-up request
        $topUpRequest = Transaction::findOrFail($id);
    
        // Check if the request is already approved or rejected
        if ($topUpRequest->status != 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }
    
        // Increase the saldo for the student (account)
        $account = $topUpRequest->account;
        $account->saldo += $topUpRequest->amount;
        $account->save();
    
        // Update the top-up request status to 'approved'
        $topUpRequest->status = 'approved';
        $topUpRequest->save();
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Top-up approved successfully!');
    }

    public function approveWithdraw($id)
    {
        // Find the withdrawal request
        $withdrawRequest = Transaction::findOrFail($id);
        
        // Check if the request is already approved or rejected
        if ($withdrawRequest->status != 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }
        
        // Process the withdrawal (e.g., decrease the saldo of the account)
        $account = $withdrawRequest->account;
        $account->saldo -= $withdrawRequest->amount;
        $account->save();
        
        // Update the withdrawal request status to 'approved'
        $withdrawRequest->status = 'approved';
        $withdrawRequest->save();
        
        // Redirect with success message
        return redirect()->back()->with('success', 'Withdrawal approved successfully!');
    }
    
    
    // Reject the top-up request
    public function rejectTopUp($id)
    {
        // Find the top-up request
        $topUpRequest = Transaction::findOrFail($id);
    
        // Check if the request is already approved or rejected
        if ($topUpRequest->status != 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }
    
        // Update the top-up request status to 'rejected'
        $topUpRequest->status = 'rejected';
        $topUpRequest->save();
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Top-up rejected successfully!');
    }

    public function store(Request $request)
{
    // Validate request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:accounts',
        'password' => 'required|min:6',
        'role' => 'required|in:siswa',
    ]);

    // Create account only (since we're using a single accounts table)
    $account = Account::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'siswa',
        'saldo' => 0, // Initialize with zero balance
    ]);

    return redirect()->back()->with('success', 'Student created successfully');
}

    /**
     * Update the specified student user in storage.
     */
    public function update(Request $request, $id)
    {
    
        // Cek apakah account dengan ID ini ada
        $user = Account::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('accounts')->ignore($id),
            ],
            'password' => 'nullable|string|min:8'
        ]);
    
        // Update data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();
    
        return redirect()->back()->with('success', 'Student updated successfully');
    }
    
    /**
     * Remove the specified student user from storage.
     */
    public function destroy($id)
    {
        // Find user and associated account
        $user = Account::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Student deleted successfully');
    }
}


