<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <!-- Include your styles here (CSS or Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <!-- Transaction History Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Transaction History</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="transaction-list">
                            @forelse ($transactions as $transaction)
                                <div class="transaction-item 
                                    {{ $transaction->type === 'topup' ? 'deposit' : 'withdrawal' }} 
                                    p-3 border-bottom">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $transaction->user->name }}</h6>
                                            <small class="text-muted">{{ ucfirst($transaction->type) }}</small>
                                        </div>
                                        <div class="{{ $transaction->type === 'topup' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type === 'topup' ? '+' : '-' }} 
                                            ${{ number_format($transaction->amount, 2) }}
                                        </div>
                                    </div>
                                    <div class="text-muted">
                                        <small>{{ $transaction->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-muted p-3">No recent transactions.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include your scripts here (JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
