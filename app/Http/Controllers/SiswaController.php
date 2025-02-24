<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Transaction;

class SiswaController extends Controller
{

    public function index(Request $request)  // Add Request parameter here
    {
        // Retrieve the account for the currently authenticated user
        $account = Account::where('id', Auth::id())->first(); // Get the account of the logged-in user
    
        $saldo = $account ? $account->saldo : 0; 
    
        $currentMonth = now()->startOfWeek();
    
        $transactionsQuery = Transaction::where('account_id', $account->id);
    
        // Apply date filter if provided
        if ($request->has('date_range')) {
            $days = $request->date_range;
            if ($days) {
                $startDate = now()->subDays($days);
                $transactionsQuery->where('created_at', '>=', $startDate);
            }
        }
        
        // Apply transaction type filter if provided
        if ($request->has('type') && $request->type !== 'all') {
            $transactionsQuery->where('type', $request->type);
        }
    
        // Get paginated transactions
        $transactions = $transactionsQuery
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
            $totalTopUp = Transaction::where('account_id', $account->id)
            ->where('type', 'topup')
            ->whereIn('status', ['completed', 'approved'])  // Check for 'completed' or 'approved'
            ->sum('amount');
        
        $totalWithDraw = Transaction::where('account_id', $account->id)
            ->where('type', 'withdraw')
            ->whereIn('status', ['completed', 'approved'])  // Check for 'completed' or 'approved'
            ->sum('amount');
        
        $lastMonth = now()->subMonth()->startOfMonth();
        $lastMonthTopUp = Transaction::where('account_id', $account->id)
            ->where('type', 'topup')
            ->where('status', ['completed', 'approved'])
            ->whereBetween('created_at', [$lastMonth, $currentMonth])
            ->sum('amount');
    
        $lastMonthWithDraw = Transaction::where('account_id', $account->id)
            ->where('type', 'withdraw')
            ->where('status', ['completed', 'approved'])
            ->whereBetween('created_at', [$lastMonth, $currentMonth])
            ->sum('amount');
    
        // Hitung persentase perubahan (hindari pembagian oleh nol)
        $topUpChange = $lastMonthTopUp > 0 ? (($totalTopUp - $lastMonthTopUp) / $lastMonthTopUp) * 100 : 0;
        $withDrawChange = $lastMonthWithDraw > 0 ? (($totalWithDraw - $lastMonthWithDraw) / $lastMonthWithDraw) * 100 : 0;

        // Append any active filters to pagination links
        $transactions->appends(['tab' => 'history'])->appends($request->query());    

                $lastYear = now()->subYear()->startOfYear();
        $lastYearSaldo = Transaction::where('account_id', $account->id)
            ->where('status', 'completed')
            ->where('created_at', '<', $lastYear)
            ->sum('amount'); 

        $balanceChange = $lastYearSaldo > 0 ? (($saldo - $lastYearSaldo) / $lastYearSaldo) * 100 : 0;

        $currentWeekStart = now()->startOfWeek();  // Get the start of the current week
        $currentWeekEnd = now()->endOfWeek();      // Get the end of the current week
        
        // Get total top-up this week
        $totalTopUpThisWeek = Transaction::where('account_id', $account->id)
            ->where('type', 'topup')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
            ->sum('amount');
        
        // Get total withdrawal this week
        $totalWithDrawThisWeek = Transaction::where('account_id', $account->id)
            ->where('type', 'withdraw')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
            ->sum('amount');

        
        return view('siswa.dashboard', compact('account', 'saldo', 
                                                                                            'totalTopUp', 
                                                                                            'totalWithDraw', 
                                                                                            'topUpChange', 
                                                                                            'withDrawChange', 
                                                                                            'transactions', 
                                                                                            'balanceChange',
                                                                                            'totalTopUpThisWeek',
                                                                                            'totalWithDrawThisWeek'));
    }
    
    
    // Mengajukan top-up saldo (memerlukan persetujuan)
    public function requestTopUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|in:credit_card,bank_transfer,ewallet,mobile_banking',
            'description' => 'nullable|string|max:255',
        ]);
    
        $account = Account::where('id', Auth::id())->first();
    
        // Create the transaction with pending status
        $transaction = Transaction::create([
            'account_id' => $account->id,
            'recipient_id' => null,
            'amount' => $request->amount,
            'type' => 'topup',
            'status' => 'pending',
            'payment_method' => $request->payment_method, // Make sure this is saved
            'description' => $request->description, // Make sure this is saved
        ]);
    
        return response()->json([
            'message' => 'Top-up request submitted successfully. Waiting for approval from bank mini.',
            'transaction_id' => $transaction->id
        ]);
    }
    

    // Menyetujui top-up (hanya bisa dilakukan oleh admin/bank mini)
    public function approveTopUp($transactionId)
    {
        $transaction = Transaction::where('id', $transactionId)->where('status', 'pending')->first();
        if (!$transaction) {
            return response()->json(['message' => 'Invalid transaction or already approved'], 400);
        }

        // Update saldo siswa
        $account = Account::find($transaction->account_id);
        $account->topUp($transaction->amount);
        
        // Ubah status transaksi menjadi 'approved'
        $transaction->status = 'approved';
        $transaction->save();

        return response()->json(['message' => 'Top-up approved successfully.']);
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);
    
        $account = Account::where('id', Auth::id())->first();
    
        if (!$account) {
            return response()->json(['error' => 'Account not found.'], 404);
        }
    
        // Create a pending withdrawal request
        $transaction = Transaction::create([
            'account_id' => $account->id,
            'recipient_id' => null, // No recipient for withdrawals
            'amount' => $request->amount,
            'type' => 'withdraw',
            'status' => 'pending',
            'payment_method' => null,  // Or specify the method
            'description' => $request->description, // Optional description
        ]);
    
        return response()->json([
            'message' => 'Withdrawal request submitted successfully. Waiting for approval from bank mini.',
            'transaction_id' => $transaction->id
        ]);
    }
    
     // Add a method to export transactions if needed
     public function exportTransactions(Request $request)
     {
         $account = Account::where('id', Auth::id())->first();
         
         $transactionsQuery = Transaction::where('account_id', $account->id);
 
         // Apply filters similar to index method
         if ($request->has('date_range')) {
             $days = $request->date_range;
             if ($days) {
                 $startDate = now()->subDays($days);
                 $transactionsQuery->where('created_at', '>=', $startDate);
             }
         }
 
         if ($request->has('type') && $request->type !== 'all') {
             $transactionsQuery->where('type', $request->type);
         }
 
         $transactions = $transactionsQuery->orderBy('created_at', 'desc')->get();
 
         // Here you would generate and return the export file
         // You can use Laravel Excel or create a CSV manually
         
         return response()->json(['message' => 'Export functionality to be implemented']);
     }
    
    
    // Transfer saldo ke sesama siswa
    public function transfer(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1000',
        ]);
    
        $sender = Account::where('id', Auth::id())->first();
        $recipient = Account::find($request->recipient_id);
    
        if (!$sender) {
            return response()->json(['error' => 'Sender account not found.'], 404);
        }
    
        if ($sender->id === $recipient->id) {
            return response()->json(['error' => 'Cannot transfer to yourself.'], 400);
        }
    
        try {
            $sender->withdraw($request->amount);
            $recipient->topUp($request->amount);
    
            // Simpan transaksi
            Transaction::create([
                'account_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'amount' => $request->amount,
                'type' => 'transfer',
                'status' => 'completed',
            ]);
    
            return response()->json(['message' => 'Transfer successful.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function checkRecipient($id)
{
    $user = Account::find($id);
    
    if ($user && $user->id != auth()->id()) { // Don't allow transfer to self
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ]
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'User not found'
    ]);
}
    
}
