<?php
require_once __DIR__ . '/../config.php';
$current_page = 'dashboard';
$page_title = 'Dashboard';
// Assuming $user_id, $acct_balance, $fullName, and $currency are loaded here or in config.php
include 'layout/header.php';

if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}
//if (@!$_COOKIE['firstVisit']) {
//  setcookie("firstVisit", "no", time() + 3600);
//toast_alert('success', 'Welcome Back ' . $fullName . " !", 'Close');
//}

unset($_SESSION['wire_transfer'], $_SESSION['dom_transfer']);

// --- 1. METRIC CALCULATION LOGIC (Current & Previous Month) ---

// Assuming $user_id is the key for the user.
// Define time boundaries for CURRENT month
$startOfCurrentMonth = date('Y-m-01 00:00:00');
$endOfCurrentMonth = date('Y-m-d 23:59:59');

// Define time boundaries for PREVIOUS month
$startOfPreviousMonth = date('Y-m-01 00:00:00', strtotime('last month'));
$endOfPreviousMonth = date('Y-m-t 23:59:59', strtotime('last month'));

// Helper function to fetch monthly total
function getMonthlyTotal($conn, $user_id, $type, $start, $end)
{
    $sql = "SELECT SUM(amount) as total 
            FROM transactions 
            WHERE user_id = :user_id 
              AND transaction_type = :type 
              AND trans_status = 'completed'
              AND created_at >= :start 
              AND created_at <= :end";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'type' => $type,
        'start' => $start,
        'end' => $end
    ]);

    return (float)$stmt->fetchColumn();
}


// --- Current Month Totals ---
$current_income = getMonthlyTotal($conn, $user_id, 'credit', $startOfCurrentMonth, $endOfCurrentMonth);
$current_expense = getMonthlyTotal($conn, $user_id, 'debit', $startOfCurrentMonth, $endOfCurrentMonth);

// --- Previous Month Totals ---
$previous_income = getMonthlyTotal($conn, $user_id, 'credit', $startOfPreviousMonth, $endOfPreviousMonth);
$previous_expense = getMonthlyTotal($conn, $user_id, 'debit', $startOfPreviousMonth, $endOfPreviousMonth);

// --- Percentage Change Calculation ---
function calculatePercentageChange($current, $previous)
{
    if ($previous == 0) {
        return [
            'value' => $current > 0 ? 100 : 0,
            'direction' => $current > 0 ? 'up' : 'same',
            'is_negative' => false
        ];
    }

    $change = (($current - $previous) / abs($previous)) * 100;

    return [
        'value' => abs($change),
        'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'same'),
        'is_negative' => $change < 0
    ];
}

$income_change = calculatePercentageChange($current_income, $previous_income);
$expense_change = calculatePercentageChange($current_expense, $previous_expense);

// Logic for expense presentation (Expense UP = BAD/NEGATIVE)
$expense_arrow = ($expense_change['direction'] == 'up') ? 'fa-arrow-up' : 'fa-arrow-down';
$expense_negative_class = ($expense_change['direction'] == 'up') ? 'negative' : ''; // Use 'negative' class only if expenses went up

// --- 2. FETCH TRANSACTIONS FOR CHART/LIST (Using fixed query) ---
$sql_transactions = "SELECT amount, transaction_type, trans_type, trans_status, created_at 
                     FROM transactions 
                     WHERE user_id = :user_id 
                     ORDER BY created_at DESC LIMIT 100";

$stmt_transactions = $conn->prepare($sql_transactions);
$stmt_transactions->execute(['user_id' => $user_id]);
$db_transactions = $stmt_transactions->fetchAll(PDO::FETCH_ASSOC);

$transactions = array_map(function ($t) {
    return [
        'type' => ($t['transaction_type'] === 'credit' ? 'income' : 'expense'),
        'amount' => (float)$t['amount'],
        'category_sim' => $t['trans_type'],
        'date' => $t['created_at'],
        'trans_status' => $t['trans_status'] // <--- ADD THIS
    ];
}, $db_transactions);


// Get last 4 months data for the small charts - FIXED to show actual months
function getMonthlyTrend($conn, $user_id, $type, $months = 4)
{
    $data = [];
    $monthNames = [];
    for ($i = $months - 1; $i >= 0; $i--) {
        $currentMonth = date('M', strtotime("-$i months"));
        $monthNames[] = $currentMonth;
        $start = date('Y-m-01', strtotime("-$i months"));
        $end = date('Y-m-t', strtotime("-$i months"));

        $sql = "SELECT COALESCE(SUM(amount), 0) as total FROM transactions 
                WHERE user_id = :user_id AND transaction_type = :type 
                AND created_at >= :start AND created_at <= :end";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'type' => $type,
            'start' => $start,
            'end' => $end
        ]);
        $data[] = (float)$stmt->fetchColumn();
    }
    return ['data' => $data, 'months' => $monthNames];
}

$income_trend_data = getMonthlyTrend($conn, $user_id, 'credit', 4);
$expense_trend_data = getMonthlyTrend($conn, $user_id, 'debit', 4);

?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-0">Hi, <?= $fullName ?></h2>
    <a href="deposit.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Money</a>
</div>

<?php if (isset($_GET['dormant'])): ?>
    <div class="alert alert-warning solid alert-dismissible fade show">
        <strong>Sorry, your account is due to the need for an account upgrade, please contact customer care at,
            <a href="mailto:<?= $page['url_email'] ?>"><?= $page['url_email'] ?></a> for further information.</strong>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-header flex-wrap border-0 pb-0">
                <div class="me-3 mb-2">
                    <p class="fs-14 mb-1">Total Balance</p>
                    <span
                        class="fs-24 text-black font-w600"><?= $currency ?><?php echo number_format($acct_balance, 2, '.', ','); ?></span>
                </div>
                <span class="fs-12 mb-2">
                    Account Status:
                    <?php if ($row['acct_status'] === 'active'): ?>
                        ACTIVE <i class="fas fa-circle text-success ms-1"></i>
                    <?php elseif ($row['acct_status'] === 'suspend'): ?>
                        ON HOLD <i class="fas fa-circle text-danger ms-1"></i>
                    <?php endif; ?>
                </span>
            </div>
            <div class="card-body p-0 my-3">
                <div class="px-3 pb-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-wallet fa-2x text-primary me-3"></i>
                        <div>
                            <span class="fs-12 text-muted"><?= $row['acct_type'] ?> Account</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-header flex-wrap border-0 pb-0">
                <div class="me-3 mb-2">
                    <p class="fs-14 mb-1">Income <small class="text-muted">(This Month)</small></p>
                    <span
                        class="fs-24 text-black font-w600"><?= $currency ?><?php echo number_format($current_income, 2, '.', ','); ?></span>
                </div>
                <span
                    class="fs-12 mb-2 <?= $income_change['direction'] == 'up' ? 'text-success' : 'text-danger'; ?>"><small>
                        <i
                            class="fas <?= $income_change['direction'] == 'up' ? 'fa-arrow-up' : 'fa-arrow-down'; ?> me-1"></i>
                        <?= number_format($income_change['value'], 1); ?>% from last month</small>
                </span>
            </div>
            <div class="card-body p-0">
                <canvas id="incomeChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-header flex-wrap border-0 pb-0">
                <div class="me-3 mb-2">
                    <p class="fs-14 mb-1">Expenses <small class="text-muted">(This Month)</small></p>
                    <span
                        class="fs-24 text-black font-w600"><?= $currency ?><?php echo number_format($current_expense, 2, '.', ','); ?></span>
                </div>
                <span
                    class="fs-12 mb-2 <?= $expense_change['direction'] == 'up' ? 'text-danger' : 'text-success'; ?>"><small>
                        <i class="fas <?= $expense_arrow; ?> me-1"></i>
                        <?= number_format($expense_change['value'], 1); ?>% from last month</small>
                </span>
            </div>
            <div class="card-body p-0">
                <canvas id="expenseChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Quick Actions</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6 col-md-4 col-xl-3">
                        <a href="transfer.php" class="quick-action-item">
                            <div class="action-icon bg-primary">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <h6>Send Money</h6>
                            <span><small>Transfer funds</small></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-xl-3">
                        <a href="loan.php" class="quick-action-item">
                            <div class="action-icon bg-success">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <h6>Apply Loan</h6>
                            <span><small>Get financing</small></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-xl-3">
                        <a href="card.php" class="quick-action-item">
                            <div class="action-icon bg-info">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h6>My Cards</h6>
                            <span><small>Manage cards</small></span>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-xl-3">
                        <a href="support.php" class="quick-action-item">
                            <div class="action-icon bg-warning">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h6>Support</h6>
                            <span><small>Get help</small></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Spending Overview</h4>
            </div>
            <div class="card-body">
                <?php if (empty($transactions)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                        <h4>No Transactions Yet</h4>
                        <p class="text-muted">Start adding transactions to see your spending overview</p>
                    </div>
                <?php else: ?>
                    <div id="spendingChart" style="height: 300px;"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card insurance-card" style="background:
    linear-gradient(135deg, rgba(102,126,234,0.7) 0%, rgba(118,75,162,0.7) 100%),
    url('layout/insurance.jpg') no-repeat center center / cover;">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-3x text-white"></i>
                </div>
                <h4 class="text-white mb-3">Complete Financial Protection</h4>
                <p class="text-white mb-4">Secure your future with our comprehensive insurance coverage. Peace of mind
                    for you and your family.</p>
                <a href="support.php" class="btn btn-primary">
                    <i class="fas fa-shield-alt me-2"></i>Get Protected
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Recent Transactions</h4>
                <a href="transactions.php" class="btn btn-primary btn-sm">
                    View All <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="card-body">
                <?php
                $recent_transactions = array_slice($transactions, 0, 4);

                if (empty($recent_transactions)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                        <h4>No Transactions</h4>
                        <p class="text-muted">Your recent transactions will appear here</p>
                    </div>
                <?php else: ?>
                    <div class="transaction-list">
                        <?php foreach ($recent_transactions as $transaction):
                            $category_key = strtolower($transaction['category_sim']);
                            $color = 'primary';
                            $icon = 'fa-receipt';

                            // Category-based coloring & icon
                            if (strpos($category_key, 'salary') !== false || strpos($category_key, 'deposit') !== false) {
                                $color = 'success';
                                $icon = 'fa-money-check';
                            } elseif (strpos($category_key, 'transfer') !== false || strpos($category_key, 'send') !== false) {
                                $color = 'danger';
                                $icon = 'fa-paper-plane';
                            } elseif (strpos($category_key, 'loan') !== false) {
                                $color = 'warning';
                                $icon = 'fa-hand-holding-usd';
                            } elseif (strpos($category_key, 'bill') !== false) {
                                $color = 'info';
                                $icon = 'fa-mobile-alt';
                            }

                            // Status-based coloring
                            $status = strtolower($transaction['trans_status'] ?? 'completed');
                            $amountColor = ($transaction['type'] === 'income') ? 'success' : 'danger';
                            $statusLabel = 'Completed';

                            if ($status === 'processing') {
                                $amountColor = 'warning';
                                $statusLabel = 'Pending';
                            } elseif ($status === 'failed') {
                                $amountColor = 'danger';
                                $statusLabel = 'Failed';
                            }
                        ?>
                            <div class="transaction-item">
                                <div class="transaction-info">
                                    <div class="transaction-icon bg-<?= $color ?>-light">
                                        <i class="fas <?= $icon ?> text-<?= $color ?>"></i>
                                    </div>
                                    <div class="transaction-details">
                                        <h6 class="mb-1"><?= htmlspecialchars($transaction['category_sim']) ?></h6>
                                        <span
                                            class="text-muted"><small><?= date('M j, Y', strtotime($transaction['date'])) ?></small></span>
                                        <br>
                                        <span class="text-<?= $amountColor ?>"><small><?= $statusLabel ?></small></span>
                                    </div>
                                </div>
                                <div class="transaction-amount">
                                    <span class="amount text-<?= $amountColor ?>">
                                        <?= $transaction['type'] === 'income' ? '+' : '-' ?><?= $currency ?><?= number_format($transaction['amount'], 2) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>


        </div>
    </div>
</div>

<style>
    .quick-action-item {
        display: block;
        text-align: center;
        padding: 20px 10px;
        /* Reduced padding slightly */
        border-radius: 12px;
        border: 1px solid #e8e8e8;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        background: #fdfdfd;
        /* Light background for contrast */
    }

    .quick-action-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: inherit;
        border-color: var(--bs-primary, #007bff);
        /* Use primary color */
    }

    .action-icon {
        width: 60px;
        /* Slightly smaller icon area */
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: white;
        font-size: 24px;
        /* Slightly smaller icon */
    }

    .transaction-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        /* Reduced gap */
    }

    /* **ENHANCED LOOK FOR TRANSACTION ITEMS (Table Header Replacement)** */
    .transaction-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        /* Subtler border */
        transition: all 0.3s ease;
        background: #ffffff;
        /* Explicit white background */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        /* Subtle shadow for depth */
    }

    .transaction-item:hover {
        border-color: var(--bs-primary, #007bff);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        /* More visible hover shadow */
        transform: none;
        /* Removed vertical shift for a cleaner look */
    }

    .transaction-info {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .transaction-icon {
        width: 44px;
        /* Slightly smaller icon */
        height: 44px;
        border-radius: 8px;
        /* Slightly smaller border radius */
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 16px;
    }

    .transaction-details h6 {
        margin-bottom: 3px;
        /* Reduced margin */
        font-weight: 600;
        color: #2c3e50;
        font-size: 15px;
        /* Slightly smaller font */
    }


    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.3);
    }

    .amount {
        font-weight: 700;
        font-size: 15px;
        /* Slightly smaller font */
    }

    .insurance-card {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .insurance-card:hover {
        transform: translateY(-5px);
    }

    .bg-primary-light {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1);
    }

    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the trend data from PHP - using actual month names (last 4 months)
        const incomeData = <?php echo json_encode($income_trend_data['data']); ?>;
        const expenseData = <?php echo json_encode($expense_trend_data['data']); ?>;
        const months = <?php echo json_encode($income_trend_data['months']); ?>;

        // console.log('Income Data (4 months):', incomeData);
        // console.log('Expense Data (4 months):', expenseData);
        // console.log('Months (4 months):', months);

        // Initialize income chart
        const incomeCtx = document.getElementById('incomeChart');
        if (incomeCtx && incomeData.length > 0) {
            new Chart(incomeCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Income',
                        data: incomeData,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#28a745',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5
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
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            titleFont: {
                                size: 12
                            },
                            bodyFont: {
                                size: 12
                            },
                            callbacks: {
                                label: function(context) {
                                    return '<?= $currency ?>' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            beginAtZero: true
                        },
                        x: {
                            display: false,
                            type: 'category',
                            position: 'bottom',
                            ticks: {
                                autoSkip: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'nearest'
                    },
                    elements: {
                        line: {
                            tension: 0.4
                        }
                    }
                }
            });
        }

        // Initialize expense chart
        const expenseCtx = document.getElementById('expenseChart');
        if (expenseCtx && expenseData.length > 0) {
            new Chart(expenseCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Expenses',
                        data: expenseData,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#dc3545',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5
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
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            titleFont: {
                                size: 12
                            },
                            bodyFont: {
                                size: 12
                            },
                            callbacks: {
                                label: function(context) {
                                    return '<?= $currency ?>' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            beginAtZero: true
                        },
                        x: {
                            display: false,
                            type: 'category',
                            position: 'bottom',
                            ticks: {
                                autoSkip: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'nearest'
                    },
                    elements: {
                        line: {
                            tension: 0.4
                        }
                    }
                }
            });
        }

        // Initialize spending overview chart with ApexCharts
        <?php if (!empty($transactions)):
            // Get last 4 months for spending overview too
            $spending_months = [];
            $spending_income = [];
            $spending_expense = [];

            for ($i = 3; $i >= 0; $i--) {
                $month = date('M', strtotime("-$i months"));
                $spending_months[] = $month;
                $spending_income[] = $income_trend_data['data'][3 - $i] ?? 0; // Fixed index retrieval
                $spending_expense[] = $expense_trend_data['data'][3 - $i] ?? 0;
            }
        ?>
            var spendingChart = new ApexCharts(document.querySelector("#spendingChart"), {
                series: [{
                    name: 'Income',
                    data: <?php echo json_encode($spending_income); ?>
                }, {
                    name: 'Expenses',
                    data: <?php echo json_encode($spending_expense); ?>
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '60%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: <?php echo json_encode($spending_months); ?>,
                    // Added type category for consistency and explicit definition
                    type: 'category',
                },
                yaxis: {
                    title: {
                        text: 'Amount (<?= $currency ?>)'
                    }
                },
                fill: {
                    opacity: 1
                },
                colors: ['#28a745', '#dc3545'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "<?= $currency ?>" + val.toFixed(2)
                        }
                    }
                }
            });
            spendingChart.render();
        <?php endif; ?>
    });
</script>
<?php include 'layout/footer.php'; ?>