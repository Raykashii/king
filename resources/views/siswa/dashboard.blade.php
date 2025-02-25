<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0066ff;
            --secondary-blue: #e6f0ff;
        }

        .top-section {
            background: var(--primary-blue);
            padding: 20px 0 120px;
            margin-bottom: -80px;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            width: 300px;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            border: none !important;
            padding: 10px 20px;
            margin-right: 5px;
        }

        .nav-link.active {
            background: none !important;
            color: white !important;
            border-bottom: 2px solid white !important;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .trend-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .avatar {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .spending-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 8px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .spending-item:hover {
            background-color: var(--secondary-blue);
        }

        .spending-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .amount-card {
            border: 2px solid transparent;
            transition: all 0.3s;
            cursor: pointer;
        }

        .amount-card:hover {
            border-color: var(--primary-blue);
            background: var(--secondary-blue);
        }

        .amount-card.selected {
            border-color: var(--primary-blue);
            background: var(--secondary-blue);
        }

        .payment-method-card {
            border: 2px solid transparent;
            transition: all 0.3s;
            cursor: pointer;
        }

        .payment-method-card:hover {
            border-color: var(--primary-blue);
            background: var(--secondary-blue);
        }

        .payment-method-card.selected {
            border-color: var(--primary-blue);
            background: var(--secondary-blue);
        }

        .pagination-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.pagination-arrow {
    border: none;
    background: none;
    padding: 8px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.pagination-arrow:hover {
    background-color: #f0f0f0;
}

.pagination-arrow:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-arrow svg {
    width: 20px;
    height: 20px;
    fill: none;
    stroke: #0d6efd;
    stroke-width: 2;
}

.pagination-numbers {
    display: flex;
    gap: 5px;
}

.page-number {
    padding: 5px 10px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    color: #0d6efd;
    text-decoration: none;
}

.page-number.active {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.page-number:hover:not(.active) {
    background-color: #f0f0f0;
}
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: var(--primary-blue);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-wallet2 me-2"></i>
                RapidCash
            </a>

            <div class="d-flex align-items-center flex-grow-1 mx-lg-4">
                <div class="position-relative flex-grow-1 d-none d-lg-block" style="max-width: 400px;">
                    <i class="bi bi-search position-absolute"
                        style="left: 10px; top: 10px; color: rgba(255,255,255,0.7);"></i>
                    <input type="search" class="search-input ps-4" placeholder="Search anything...">
                </div>
            </div>

            <div class="d-flex align-items-center">
                <button class="btn text-white me-3">
                    <i class="bi bi-bell"></i>
                </button>
                <div class="avatar me-3">A</div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="logout-btn">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </nav>

    <!-- Top Section -->
    <div class="top-section">
        <div class="container">
            <h2 class="text-white mb-2">Welcome Back, {{ $account->name ?? 'Guest' }}</h2>

            <p class="text-white-50 mb-4">This is your Monthly Overview Report</p>

            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-section="overview">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="topup">Top Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="withdraw">Withdraw</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="transfer">Transfer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-section="history">History</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Overview Section -->
        <div class="content-section active" id="overview-section">
            <div class="row">
                <!-- Stats Cards Row -->
                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-muted">Total Balance</h6>
                            <div class="bg-primary bg-opacity-10 p-2 rounded">
                                <i class="bi bi-wallet2 text-primary"></i>
                            </div>
                        </div>
                        <h3 class="mb-3">Rp {{ number_format($saldo, 2, ',', '.') }}</h3>
                        {{-- <span class="trend-badge bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-arrow-{{ $balanceChange >= 0 ? 'up' : 'down' }}-short"></i>
                            {{ number_format(abs($balanceChange), 2, ',', '.') }}% Last Year
                        </span>                         --}}
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-muted">Total Top up</h6>
                            <div class="bg-success bg-opacity-10 p-2 rounded">
                                <i class="bi bi-cash-coin text-success"></i>
                            </div>
                        </div>
                        <h3 class="mb-3">Rp {{ number_format($totalTopUp, 2, ',', '.') }}</h3>
                        {{-- <span class="trend-badge bg-success bg-opacity-10 text-success">
                            <i class="bi bi-arrow-up-short"></i>
                            {{ number_format(abs($topUpChange), 2, ',', '.') }}% this month
                        </span> --}}
                    </div>
                </div>


                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-muted">Total Withdraw</h6>
                            <div class="bg-danger bg-opacity-10 p-2 rounded">
                                <i class="bi bi-graph-down text-danger"></i>
                            </div>
                        </div>
                        <h3 class="mb-3">Rp {{ number_format($totalWithDraw, 2, ',', '.') }}</h3>
                        {{-- <span class="trend-badge bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-arrow-down-short"></i>
                            {{ number_format(abs($withDrawChange), 2, ',', '.') }}% this month
                        </span> --}}
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <!-- <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title">Balance Overview</h5>
                                <select class="form-select form-select-sm" style="width: auto;">
                                    <option>Last 6 month</option>
                                    <option>Last year</option>
                                </select>
                            </div>
                            <div class="chart-container">
                                <canvas id="balanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title">All Spending</h5>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary active">Weekly</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary">Monthly</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary">Yearly</button>
                                </div>
                            </div>
                            <div class="chart-container" style="height: 200px;">
                                <canvas id="spendingChart"></canvas>
                            </div>
                            <div class="mt-4">
                                <div class="spending-item">
                                    <div class="d-flex align-items-center">
                                        <div class="spending-dot" style="background: #0066ff;"></div>
                                        <span>Books</span>
                                    </div>
                                    <span class="fw-bold">46%</span>
                                </div>
                                <div class="spending-item">
                                    <div class="d-flex align-items-center">
                                        <div class="spending-dot" style="background: #00d4ff;"></div>
                                        <span>School Fees</span>
                                    </div>
                                    <span class="fw-bold">52%</span>
                                </div>
                                <div class="spending-item">
                                    <div class="d-flex align-items-center">
                                        <div class="spending-dot" style="background: #e6f0ff;"></div>
                                        <span>Supplies</span>
                                    </div>
                                    <span class="fw-bold">24%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <div class="content-section" id="topup-section">
            @csrf
            <div class="row">
                <!-- Amount Selection -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Select Amount</h5>

                            <!-- Quick Amount Selection -->
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="amount-card rounded p-3 text-center" data-amount="50000">
                                        <h6 class="mb-0">Rp 50,000</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="amount-card rounded p-3 text-center" data-amount="100000">
                                        <h6 class="mb-0">Rp 100,000</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="amount-card rounded p-3 text-center" data-amount="250000">
                                        <h6 class="mb-0">Rp 250,000</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="amount-card rounded p-3 text-center" data-amount="500000">
                                        <h6 class="mb-0">Rp 500,000</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Amount -->
                            <div class="mb-3">
                                <label class="form-label">Custom Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" id="topup-amount" class="form-control"
                                        placeholder="Enter amount" min="1000">
                                </div>
                                <div id="amount-error" class="text-danger small mt-1 d-none"></div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea id="topup-description" class="form-control" rows="3" placeholder="Enter top-up description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Payment Method</h5>

                            <div class="d-flex flex-column gap-3" id="payment-methods">
                                <div class="payment-method-card rounded p-3" data-method="credit_card">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3"><i class="bi bi-credit-card fs-4 text-primary"></i></div>
                                        <div>
                                            <h6 class="mb-1">Credit Card</h6>
                                            <p class="mb-0 text-muted small">Top up using credit or debit card</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-method-card rounded p-3" data-method="bank_transfer">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3"><i class="bi bi-building fs-4 text-primary"></i></div>
                                        <div>
                                            <h6 class="mb-1">Bank Transfer</h6>
                                            <p class="mb-0 text-muted small">Direct transfer from your bank account</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-method-card rounded p-3" data-method="ewallet">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3"><i class="bi bi-wallet2 fs-4 text-primary"></i></div>
                                        <div>
                                            <h6 class="mb-1">E-Wallet</h6>
                                            <p class="mb-0 text-muted small">Use your preferred e-wallet</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-method-card rounded p-3" data-method="mobile_banking">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3"><i class="bi bi-phone fs-4 text-primary"></i></div>
                                        <div>
                                            <h6 class="mb-1">Mobile Banking</h6>
                                            <p class="mb-0 text-muted small">Top up via mobile banking</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="payment-method-error" class="text-danger small mt-1 d-none"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-12 text-end">
                    <button class="btn btn-primary btn-lg px-5" id="submitTopup">
                        Submit Top-up Request
                    </button>
                </div>
            </div>
        </div>

            <!-- Withdrawal Section -->
        <div class="content-section" id="withdraw-section">
            @csrf
            <div class="row justify-content-center">
                <!-- Amount Selection -->
                <div class="col-md-8"> <!-- Increased width for better balance -->
                    <div class="card shadow-sm p-4"> <!-- Added padding -->
                        <div class="card-body">
                            <h5 class="card-title mb-4">Select Amount</h5>

                            <!-- Quick Amount Selection -->
                            <div class="row g-3 mb-4">
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="50000">
                                        <h6 class="mb-0">Rp 50,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="100000">
                                        <h6 class="mb-0">Rp 100,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="250000">
                                        <h6 class="mb-0">Rp 250,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="500000">
                                        <h6 class="mb-0">Rp 500,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="1000000">
                                        <h6 class="mb-0">Rp 1,000,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="2000000">
                                        <h6 class="mb-0">Rp 2,000,000</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Amount -->
                            <div class="mb-4"> <!-- Increased margin-bottom -->
                                <label class="form-label">Custom Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" id="withdraw-amount" class="form-control"
                                        placeholder="Enter amount" min="1000">
                                </div>
                                <div id="amount-error" class="text-danger small mt-1 d-none"></div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4"> <!-- More spacing for better separation -->
                                <label class="form-label">Description</label>
                                <textarea id="withdraw-description" class="form-control" rows="3" placeholder="Enter withdrawal description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row mt-4"> <!-- Added spacing above button -->
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-lg px-5 py-3" id="submitWithdraw">
                        Submit Withdrawal Request
                    </button>
                </div>
            </div>
        </div>



        <div class="content-section" id="history-section">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Transaction History</h5>
                        <div class="d-flex gap-3 align-items-center">
                            <!-- Search Input -->
                            <input type="text" name="search" id="search" class="form-control form-control-sm"
                            placeholder="Search transactions..." value="{{ request('search') }}">
                    
                            <button class="btn btn-sm btn-primary" onclick="searchTransactions()">Cari</button>
                    
                            <!-- Date Range Filter -->
                            <select name="date_range" class="form-select form-select-sm" onchange="filterTransactions()">
                                <option value="">All Time</option>
                                <option value="7" {{ request('date_range') == '7' ? 'selected' : '' }}>Last 7 days</option>
                                <option value="30" {{ request('date_range') == '30' ? 'selected' : '' }}>Last 30 days</option>
                                <option value="90" {{ request('date_range') == '90' ? 'selected' : '' }}>Last 3 months</option>
                                <option value="180" {{ request('date_range') == '180' ? 'selected' : '' }}>Last 6 months</option>
                                <option value="365" {{ request('date_range') == '365' ? 'selected' : '' }}>Last year</option>
                            </select>
                    
                            <!-- Transaction Type Filter -->
                            <select name="type" class="form-select form-select-sm" onchange="filterTransactions()">
                                <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Transactions</option>
                                <option value="topup" {{ request('type') == 'topup' ? 'selected' : '' }}>Top Up</option>
                                <option value="withdraw" {{ request('type') == 'withdraw' ? 'selected' : '' }}>Withdrawal</option>
                                <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Transaction Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction ID</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <span class="text-primary">#{{ $transaction->id }}</span>
                                        </td>
                                        <td>
                                            @if ($transaction->type == 'topup')
                                                <span class="badge bg-success bg-opacity-10 text-success">Top Up</span>
                                            @elseif($transaction->type == 'withdraw')
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger">Withdrawal</span>
                                            @else
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary">Transfer</span>
                                            @endif
                                        </td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>
                                            @if ($transaction->type == 'topup')
                                                <span class="text-success">+Rp
                                                    {{ number_format($transaction->amount, 2, ',', '.') }}</span>
                                            @else
                                                <span class="text-danger">-Rp
                                                    {{ number_format($transaction->amount, 2, ',', '.') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->status == 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($transaction->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($transaction->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @elseif($transaction->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-link" data-bs-toggle="modal"
                                                data-bs-target="#transactionModal{{ $transaction->id }}">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container">
                        <button class="pagination-arrow" onclick="window.location.href='{{ $transactions->previousPageUrl() }}&tab=history'" {{ $transactions->onFirstPage() ? 'disabled' : '' }}>
                            <svg viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        
                        <div class="pagination-numbers">
                            @if($transactions->currentPage() > 2)
                                <a href="{{ $transactions->url(1) . '&tab=history' }}" class="page-number">1</a>
                                @if($transactions->currentPage() > 3)
                                    <span>...</span>
                                @endif
                            @endif
                    
                            @for($i = max(1, $transactions->currentPage() - 1); $i <= min($transactions->lastPage(), $transactions->currentPage() + 1); $i++)
                                <a href="{{ $transactions->url($i) . '&tab=history' }}" class="page-number {{ $transactions->currentPage() == $i ? 'active' : '' }}">
                                    {{ $i }}
                                </a>
                            @endfor
                    
                            @if($transactions->currentPage() < $transactions->lastPage() - 1)
                                @if($transactions->currentPage() < $transactions->lastPage() - 2)
                                    <span>...</span>
                                @endif
                                <a href="{{ $transactions->url($transactions->lastPage()) . '&tab=history' }}" class="page-number">{{ $transactions->lastPage() }}</a>
                            @endif
                        </div>
                    
                        <button class="pagination-arrow" onclick="window.location.href='{{ $transactions->nextPageUrl() }}&tab=history'" {{ $transactions->hasMorePages() ? '' : 'disabled' }}>
                            <svg viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Transaction Detail Modal -->
            @foreach ($transactions as $transaction)
                <div class="modal fade" id="transactionModal{{ $transaction->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Transaction Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="fw-bold">Transaction ID</label>
                                    <p>#{{ $transaction->id }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold">Date & Time</label>
                                    <p>{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold">Type</label>
                                    <p>{{ ucfirst($transaction->type) }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold">Amount</label>
                                    <p>Rp {{ number_format($transaction->amount, 2, ',', '.') }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold">Description</label>
                                    <p>{{ $transaction->description }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold">Status</label>
                                    <p>{{ ucfirst($transaction->status) }}</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        
        <div class="content-section" id="transfer-section">
            @csrf
            <div class="row justify-content-center">
                <!-- Transfer Form -->
                <div class="col-md-8">
                    <div class="card shadow-sm p-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Transfer Money</h5>
        
                    <!-- Recipient ID -->
                                <div class="mb-4">
                                    <label class="form-label">Recipient ID</label>
                                    <div class="position-relative">
                                        <input type="text" 
                                            id="recipient-id" 
                                            class="form-control" 
                                            placeholder="Enter recipient's ID"
                                            autocomplete="off">
                                        
                                        <!-- Recipient Preview Container -->
                                        <div id="recipient-preview" class="mt-2 d-none">
                                            <div class="p-3 bg-light rounded border">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 d-flex align-items-center justify-content-center bg-primary text-white rounded-circle" style="width: 40px; height: 40px;">
                                                        <!-- First letter of recipient's name will be inserted here -->
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium" id="recipient-name"></div>
                                                        <small class="text-muted" id="recipient-id-display"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="recipient-error" class="text-danger small mt-1 d-none"></div>
                                </div>
        
                            <!-- Quick Amount Selection -->
                            <div class="row g-3 mb-4">
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="50000">
                                        <h6 class="mb-0">Rp 50,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="100000">
                                        <h6 class="mb-0">Rp 100,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="250000">
                                        <h6 class="mb-0">Rp 250,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="500000">
                                        <h6 class="mb-0">Rp 500,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="1000000">
                                        <h6 class="mb-0">Rp 1,000,000</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="amount-card rounded p-3 text-center" data-amount="2000000">
                                        <h6 class="mb-0">Rp 2,000,000</h6>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Custom Amount -->
                            <div class="mb-4">
                                <label class="form-label">Custom Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                    id="transfer-amount" 
                                    class="form-control"
                                    placeholder="Enter amount" 
                                    min="1000">
                                </div>
                                <div id="amount-error" class="text-danger small mt-1 d-none"></div>
                            </div>
        
                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label">Description</label>
                                <textarea id="transfer-description" 
                                    class="form-control" 
                                    rows="3" 
                                    placeholder="Enter transfer description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Submit Button -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-lg px-5 py-3" id="submitTransfer">
                        Transfer
                    </button>
                </div>
            </div>
        </div>  
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Balance Chart
        const balanceCtx = document.getElementById('balanceChart').getContext('2d');
        const gradient1 = balanceCtx.createLinearGradient(0, 0, 0, 300);
        gradient1.addColorStop(0, 'rgba(0, 102, 255, 0.2)');
        gradient1.addColorStop(1, 'rgba(0, 102, 255, 0)');

        const gradient2 = balanceCtx.createLinearGradient(0, 0, 0, 300);
        gradient2.addColorStop(0, 'rgba(0, 212, 255, 0.2)');
        gradient2.addColorStop(1, 'rgba(0, 212, 255, 0)');

        new Chart(balanceCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Total Income',
                    data: [20000, 22000, 25000, 27000, 25000, 28000, 30000, 28000, 26000, 28000, 30000,
                        32000
                    ],
                    borderColor: '#0066ff',
                    backgroundColor: gradient1,
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Total Spending',
                    data: [18000, 20000, 22000, 25000, 23000, 25000, 27000, 25000, 23000, 25000, 27000,
                        29000
                    ],
                    borderColor: '#00d4ff',
                    backgroundColor: gradient2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString()
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Get all amount selection cards
            const amountCards = document.querySelectorAll(".amount-card");
            const amountInput = document.getElementById("topup-amount");

            amountCards.forEach(card => {
                card.addEventListener("click", function() {
                    // Get the amount from the clicked card
                    const amount = this.getAttribute("data-amount");

                    // Set the amount in the input field
                    amountInput.value = amount;
                });
            });
        });


        // Spending Chart
        const spendingCtx = document.getElementById('spendingChart').getContext('2d');
        new Chart(spendingCtx, {
            type: 'doughnut',
            data: {
                labels: ['Books', 'School Fees', 'Supplies'],
                datasets: [{
                    data: [46, 52, 24],
                    backgroundColor: [
                        '#0066ff', // Primary blue for Books
                        '#00d4ff', // Light blue for School Fees
                        '#e6f0ff' // Very light blue for Supplies
                    ],
                    borderWidth: 0,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}%`;
                            }
                        }
                    }
                },
                cutout: '75%'
            }
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Function to get URL parameters
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Function to set active tab
    function setActiveTab(tabId) {
        // Remove active class from all tabs and sections
        document.querySelectorAll('.nav-link').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });

        // Add active class to selected tab
        const selectedTab = document.querySelector(`.nav-link[data-section="${tabId}"]`);
        if (selectedTab) {
            selectedTab.classList.add('active');
            document.getElementById(tabId + '-section').classList.add('active');
        }
    }

    // Tab switching functionality
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            
            // Update URL with the selected tab
            const url = new URL(window.location);
            url.searchParams.set('tab', sectionId);
            window.history.pushState({}, '', url);

            setActiveTab(sectionId);
        });
    });

    // Set active tab on page load based on URL parameter
    const activeTab = getUrlParameter('tab') || 'overview'; // default to overview if no tab specified
    setActiveTab(activeTab);
});

        // Amount card selection
        document.querySelectorAll('.amount-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.amount-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Payment method selection
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove(
                    'selected'));
                this.classList.add('selected');
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let selectedAmount = 0;
            let selectedPaymentMethod = "";

            // Event listener untuk memilih amount
            document.querySelectorAll(".amount-card").forEach((card) => {
                card.addEventListener("click", function() {
                    selectedAmount = this.getAttribute("data-amount");
                    document.getElementById("topup-amount").value = selectedAmount;
                });
            });

            // Event listener untuk memilih metode pembayaran
            document.querySelectorAll(".payment-method-card").forEach((card) => {
                card.addEventListener("click", function() {
                    document.querySelectorAll(".payment-method-card").forEach((el) => {
                        el.classList.remove("selected");
                    });
                    this.classList.add("selected");
                    selectedPaymentMethod = this.getAttribute("data-method");
                });
            });

            // Submit form dengan AJAX
            document.getElementById("submitTopup").addEventListener("click", function() {
                let amount = document.getElementById("topup-amount").value;
                let description = document.getElementById("topup-description").value;

                // Validasi input
                if (!amount || amount < 1000) {
                    document.getElementById("amount-error").innerText = "Amount must be at least Rp 1,000";
                    document.getElementById("amount-error").classList.remove("d-none");
                    return;
                } else {
                    document.getElementById("amount-error").classList.add("d-none");
                }

                if (!selectedPaymentMethod) {
                    document.getElementById("payment-method-error").innerText =
                        "Please select a payment method.";
                    document.getElementById("payment-method-error").classList.remove("d-none");
                    return;
                } else {
                    document.getElementById("payment-method-error").classList.add("d-none");
                }

                // Kirim request ke server
                fetch("{{ route('siswa.topup.request') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        },
                        body: JSON.stringify({
                            amount,
                            payment_method: selectedPaymentMethod,
                            description
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => console.error("Error:", error));
                console.log("Amount:", amount);
                console.log("Selected Payment Method:", selectedPaymentMethod);
                console.log("Description:", description);

            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Get all amount selection cards in the withdrawal section
            const amountCards = document.querySelectorAll("#withdraw-section .amount-card");
            const amountInput = document.getElementById("withdraw-amount");

            amountCards.forEach(card => {
                card.addEventListener("click", function() {
                    // Get the amount from the clicked card
                    const amount = this.getAttribute("data-amount");

                    // Set the amount in the input field
                    amountInput.value = amount;
                });
            });

            // Submit button event listener
            document.getElementById("submitWithdraw").addEventListener("click", function() {
                let amount = document.getElementById("withdraw-amount").value;
                let description = document.getElementById("withdraw-description").value;

                // Validating the amount
                if (!amount || amount < 1000) {
                    document.getElementById("amount-error").innerText = "Amount must be at least Rp 1,000";
                    document.getElementById("amount-error").classList.remove("d-none");
                    return;
                } else {
                    document.getElementById("amount-error").classList.add("d-none");
                }

                // Send request to the server
                fetch("{{ route('siswa.withdraw.request') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({
                            amount: amount,
                            description: description
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the withdrawal request.');
                    });
            });
        });
    </script>

<script>
    function filterTransactions() {
        const dateRange = document.querySelector('select[name="date_range"]').value;
        const type = document.querySelector('select[name="type"]').value;
        
        let url = new URL(window.location.href);
        url.searchParams.set('tab', 'history');
        
        if (dateRange) {
            url.searchParams.set('date_range', dateRange);
        } else {
            url.searchParams.delete('date_range');
        }
        
        if (type && type !== 'all') {
            url.searchParams.set('type', type);
        } else {
            url.searchParams.delete('type');
        }
        
        window.location.href = url.toString();
    }

    document.addEventListener("DOMContentLoaded", function() {
    // Get all amount selection cards in the transfer section
    const transferAmountCards = document.querySelectorAll("#transfer-section .amount-card");
    const transferAmountInput = document.getElementById("transfer-amount");

    transferAmountCards.forEach(card => {
        card.addEventListener("click", function() {
            // Remove selected class from all cards
            transferAmountCards.forEach(c => c.classList.remove("selected"));
            // Add selected class to clicked card
            this.classList.add("selected");
            // Get the amount from the clicked card
            const amount = this.getAttribute("data-amount");
            // Set the amount in the input field
            transferAmountInput.value = amount;
        });
    });

    // Submit button event listener
    document.getElementById("submitTransfer").addEventListener("click", function() {
        let recipientId = document.getElementById("recipient-id").value;
        let amount = document.getElementById("transfer-amount").value;
        let description = document.getElementById("transfer-description").value;

        // Validate recipient
        if (!recipientId) {
            document.getElementById("recipient-error").innerText = "Please enter a recipient ID";
            document.getElementById("recipient-error").classList.remove("d-none");
            return;
        }

        // Validate amount
        if (!amount || amount < 1000) {
            document.getElementById("amount-error").innerText = "Amount must be at least Rp 1,000";
            document.getElementById("amount-error").classList.remove("d-none");
            return;
        }

        // Send request to the server
        fetch("{{ route('siswa.transfer.request') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                recipient_id: recipientId,
                amount: amount,
                description: description
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                // Reset form
                document.getElementById("recipient-id").value = "";
                document.getElementById("transfer-amount").value = "";
                document.getElementById("transfer-description").value = "";
                document.querySelectorAll(".amount-card").forEach(card => {
                    card.classList.remove("selected");
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the transfer request.');
        });
    });
});

// Add this to your existing JavaScript
function checkRecipient(recipientId) {
    const previewContainer = document.getElementById('recipient-preview');
    const recipientNameElement = document.getElementById('recipient-name');
    const recipientIdElement = document.getElementById('recipient-id-display');
    const errorElement = document.getElementById('recipient-error');
    const avatarElement = previewContainer.querySelector('.avatar');
    
    // Reset error message
    errorElement.classList.add('d-none');
    
    if (!recipientId) {
        previewContainer.classList.add('d-none');
        return;
    }

    // Make API call to check recipient
    fetch(`/check-recipient/${recipientId}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.user) {
            // Show preview container
            previewContainer.classList.remove('d-none');
            
            // Update preview content
            recipientNameElement.textContent = data.user.name;
            recipientIdElement.textContent = `ID: ${data.user.id}`;
            avatarElement.textContent = data.user.name.charAt(0).toUpperCase();
            
            // Add success styling
            previewContainer.querySelector('.bg-light').classList.remove('bg-danger-subtle');
            previewContainer.querySelector('.bg-light').classList.add('bg-success-subtle');
        } else {
            // Show error in preview
            previewContainer.classList.remove('d-none');
            recipientNameElement.textContent = 'User Not Found';
            recipientIdElement.textContent = `ID: ${recipientId}`;
            avatarElement.textContent = '?';
            
            // Add error styling
            previewContainer.querySelector('.bg-light').classList.remove('bg-success-subtle');
            previewContainer.querySelector('.bg-light').classList.add('bg-danger-subtle');
            
            // Show error message
            errorElement.textContent = 'Invalid recipient ID';
            errorElement.classList.remove('d-none');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        previewContainer.classList.add('d-none');
        errorElement.textContent = 'Error checking recipient';
        errorElement.classList.remove('d-none');
    });
}

// Add debounce function to prevent too many API calls
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Update the recipient input event listener
document.addEventListener('DOMContentLoaded', function() {
    const recipientInput = document.getElementById('recipient-id');
    const debouncedCheck = debounce(checkRecipient, 300);
    
    recipientInput.addEventListener('input', function(e) {
        debouncedCheck(e.target.value);
    });
});

    </script>

<script>
    function searchTransactions() {
        let search = document.getElementById('search').value;
        let url = new URL(window.location.href);
        url.searchParams.set('search', search);
        window.location.href = url.toString();
    }
</script>

</body>

</html>
