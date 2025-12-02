<?php
require_once __DIR__ . '/../config.php';
$current_page = 'domestic-transfer';
$page_title = 'Domestic Transfer';
include 'layout/header.php';
include '../include/aza.php';

require_once(ROOT_PATH . "/include/Transfer/DomesticFunction.php");

if ($row['acct_status'] === 'suspend') {
    header('Location: dashboard.php?dormant#dormant');
    exit();
}

// Fetch user's beneficiaries
$beneficiaries = [];
try {
    $stmt = $conn->prepare("SELECT * FROM beneficiaries WHERE user_id = :user_id AND is_active = 1 ORDER BY account_name ASC");
    $stmt->execute(['user_id' => $user_id]);
    $beneficiaries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Handle error silently
}

// Check if beneficiary ID is passed via URL and fetch details
$prefilled_beneficiary = null;
if (isset($_GET['beneficiary']) && !empty($_GET['beneficiary'])) {
    $beneficiary_id = intval($_GET['beneficiary']);
    try {
        $stmt = $conn->prepare("SELECT * FROM beneficiaries WHERE id = :id AND user_id = :user_id AND is_active = 1");
        $stmt->execute(['id' => $beneficiary_id, 'user_id' => $user_id]);
        $prefilled_beneficiary = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Handle error silently
    }
}
?>

<div class="form-head mb-4 d-flex justify-content-between align-items-center">
    <h2 class="text-black font-w600 mb-2">Domestic Transfer</h2>
    <a href="beneficiaries.php" class="btn btn-primary btn-sm w-20">
        <i class="fas fa-address-book me-2"></i>Manage Beneficiaries
    </a>
</div>

<?php if ($page['transfer'] == '1' && $row['transfer'] == '1'): ?>

<div class="row">
    <div class="col-xl-8 col-lg-10 mx-auto">
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm bg-light mb-4">
            <div class="card-body py-3">
                <div class="row g-2">
                    <div class="col-md-6">

                        <h5 class="card-title mb-1 text-primary">Transfer Details</h5>
                        <p class="text-muted mb-0">Select a beneficiary or enter new details</p>

                    </div>

                </div>
            </div>
        </div>

        <div class="card border-0 bg-light shadow-sm">

            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <!-- Beneficiary Selection -->
                    <?php if (!empty($beneficiaries)): ?>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Select Saved Beneficiary</label>
                            <select class="form-select beneficiary-select" id="beneficiarySelect">
                                <option value="">-- Select a saved beneficiary --</option>
                                <?php foreach ($beneficiaries as $beneficiary): ?>
                                <option value="<?= $beneficiary['id'] ?>"
                                    data-account-number="<?= htmlspecialchars($beneficiary['account_number']) ?>"
                                    data-account-name="<?= htmlspecialchars($beneficiary['account_name']) ?>"
                                    data-bank-name="<?= htmlspecialchars($beneficiary['bank_name']) ?>"
                                    data-country="<?= htmlspecialchars($beneficiary['country']) ?>"
                                    data-account-type="<?= htmlspecialchars($beneficiary['account_type']) ?>"
                                    <?= ($prefilled_beneficiary && $prefilled_beneficiary['id'] == $beneficiary['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($beneficiary['account_name']) ?> -
                                    <?= htmlspecialchars($beneficiary['account_number']) ?>
                                    (<?= htmlspecialchars($beneficiary['bank_name']) ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="account_number" class="form-label">Account Number <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-end-0">
                                    <i class="fas fa-hashtag"></i>
                                </span>
                                <input type="text" autocomplete="off" class="form-control ps-2" name="account_number"
                                    id="account_number" placeholder="0123456789" required pattern="[0-9]{10,12}"
                                    value="<?= $prefilled_beneficiary ? htmlspecialchars($prefilled_beneficiary['account_number']) : '' ?>">
                                <div class="invalid-feedback">
                                    Please enter a valid account number (10-12 digits)
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="account_name" class="form-label">Account Name <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-end-0">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control ps-2" name="account_name" id="account_name"
                                    placeholder="John Doe" required
                                    value="<?= $prefilled_beneficiary ? htmlspecialchars($prefilled_beneficiary['account_name']) : '' ?>">
                                <div class="invalid-feedback">
                                    Please enter the account holder's name
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bank_name" class="form-label">Bank Name <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-end-0">
                                    <i class="fas fa-landmark"></i>
                                </span>
                                <input type="text" class="form-control ps-2" name="bank_name" id="bank_name"
                                    placeholder="Enter bank name..." list="bank_suggestions" required
                                    value="<?= $prefilled_beneficiary ? htmlspecialchars($prefilled_beneficiary['bank_name']) : '' ?>">
                                <datalist id="bank_suggestions">
                                    <?php foreach ($banks_list as $bank): ?>
                                    <option value="<?= htmlspecialchars($bank) ?>">
                                        <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-end-0">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                                <input type="number" step="0.01" class="form-control ps-2" name="amount"
                                    placeholder="0.00" min="1" required>
                                <div class="invalid-feedback">
                                    Please enter a valid amount
                                </div>
                            </div>
                            <input type="hidden" value="<?= $page['domesticfee'] ?>" name="fee">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="account_type" class="form-label">Account Type <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-end-0">
                                    <i class="fas fa-piggy-bank"></i>
                                </span>
                                <select name="account_type" required class="form-control ps-2" id="account_type">
                                    <option value="">Select Account Type</option>
                                    <option value="Savings"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['account_type'] == 'Savings') ? 'selected' : '' ?>>
                                        Savings Account</option>
                                    <option value="Current"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['account_type'] == 'Current') ? 'selected' : '' ?>>
                                        Current Account</option>
                                    <option value="Checking"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['account_type'] == 'Checking') ? 'selected' : '' ?>>
                                        Checking Account</option>
                                    <option value="Fixed Deposit"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['account_type'] == 'Fixed Deposit') ? 'selected' : '' ?>>
                                        Fixed Deposit</option>
                                    <option value="Non Resident"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['account_type'] == 'Non Resident') ? 'selected' : '' ?>>
                                        Non Resident Account</option>
                                    <option value="Online Banking"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['account_type'] == 'Online Banking') ? 'selected' : '' ?>>
                                        Online Banking</option>
                                    <option value="Domicilary Account"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['account_type'] == 'Domicilary Account') ? 'selected' : '' ?>>
                                        Domicilary Account</option>
                                    <option value="Joint Account"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['account_type'] == 'Joint Account') ? 'selected' : '' ?>>
                                        Joint Account</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select an account type
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="bank_country" class="form-label">Country <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white border-end-0">
                                    <i class="fas fa-globe"></i>
                                </span>
                                <select name="bank_country" required class="form-control ps-2" id="bank_country">
                                    <option value="">Select Country</option>
                                    <option value="Afganistan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Afganistan') ? 'selected' : '' ?>>
                                        Afghanistan</option>
                                    <option value="Albania"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Albania') ? 'selected' : '' ?>>
                                        Albania</option>
                                    <option value="Algeria"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Algeria') ? 'selected' : '' ?>>
                                        Algeria</option>
                                    <option value="American Samoa"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'American Samoa') ? 'selected' : '' ?>>
                                        American Samoa</option>
                                    <option value="Andorra"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Andorra') ? 'selected' : '' ?>>
                                        Andorra</option>
                                    <option value="Angola"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Angola') ? 'selected' : '' ?>>
                                        Angola</option>
                                    <option value="Anguilla"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Anguilla') ? 'selected' : '' ?>>
                                        Anguilla</option>
                                    <option value="Antigua & Barbuda"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Antigua & Barbuda') ? 'selected' : '' ?>>
                                        Antigua & Barbuda</option>
                                    <option value="Argentina"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Argentina') ? 'selected' : '' ?>>
                                        Argentina</option>
                                    <option value="Armenia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Armenia') ? 'selected' : '' ?>>
                                        Armenia</option>
                                    <option value="Aruba"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Aruba') ? 'selected' : '' ?>>
                                        Aruba</option>
                                    <option value="Australia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Australia') ? 'selected' : '' ?>>
                                        Australia</option>
                                    <option value="Austria"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Austria') ? 'selected' : '' ?>>
                                        Austria</option>
                                    <option value="Azerbaijan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Azerbaijan') ? 'selected' : '' ?>>
                                        Azerbaijan</option>
                                    <option value="Bahamas"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bahamas') ? 'selected' : '' ?>>
                                        Bahamas</option>
                                    <option value="Bahrain"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bahrain') ? 'selected' : '' ?>>
                                        Bahrain</option>
                                    <option value="Bangladesh"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bangladesh') ? 'selected' : '' ?>>
                                        Bangladesh</option>
                                    <option value="Barbados"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Barbados') ? 'selected' : '' ?>>
                                        Barbados</option>
                                    <option value="Belarus"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Belarus') ? 'selected' : '' ?>>
                                        Belarus</option>
                                    <option value="Belgium"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Belgium') ? 'selected' : '' ?>>
                                        Belgium</option>
                                    <option value="Belize"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Belize') ? 'selected' : '' ?>>
                                        Belize</option>
                                    <option value="Benin"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Benin') ? 'selected' : '' ?>>
                                        Benin</option>
                                    <option value="Bermuda"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bermuda') ? 'selected' : '' ?>>
                                        Bermuda</option>
                                    <option value="Bhutan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bhutan') ? 'selected' : '' ?>>
                                        Bhutan</option>
                                    <option value="Bolivia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bolivia') ? 'selected' : '' ?>>
                                        Bolivia</option>
                                    <option value="Bonaire"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bonaire') ? 'selected' : '' ?>>
                                        Bonaire</option>
                                    <option value="Bosnia & Herzegovina"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bosnia & Herzegovina') ? 'selected' : '' ?>>
                                        Bosnia & Herzegovina</option>
                                    <option value="Botswana"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Botswana') ? 'selected' : '' ?>>
                                        Botswana</option>
                                    <option value="Brazil"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Brazil') ? 'selected' : '' ?>>
                                        Brazil</option>
                                    <option value="British Indian Ocean Ter"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'British Indian Ocean Ter') ? 'selected' : '' ?>>
                                        British Indian Ocean Ter</option>
                                    <option value="Brunei"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Brunei') ? 'selected' : '' ?>>
                                        Brunei</option>
                                    <option value="Bulgaria"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Bulgaria') ? 'selected' : '' ?>>
                                        Bulgaria</option>
                                    <option value="Burkina Faso"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Burkina Faso') ? 'selected' : '' ?>>
                                        Burkina Faso</option>
                                    <option value="Burundi"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Burundi') ? 'selected' : '' ?>>
                                        Burundi</option>
                                    <option value="Cambodia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cambodia') ? 'selected' : '' ?>>
                                        Cambodia</option>
                                    <option value="Cameroon"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cameroon') ? 'selected' : '' ?>>
                                        Cameroon</option>
                                    <option value="Canada"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Canada') ? 'selected' : '' ?>>
                                        Canada</option>
                                    <option value="Canary Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Canary Islands') ? 'selected' : '' ?>>
                                        Canary Islands</option>
                                    <option value="Cape Verde"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cape Verde') ? 'selected' : '' ?>>
                                        Cape Verde</option>
                                    <option value="Cayman Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cayman Islands') ? 'selected' : '' ?>>
                                        Cayman Islands</option>
                                    <option value="Central African Republic"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Central African Republic') ? 'selected' : '' ?>>
                                        Central African Republic</option>
                                    <option value="Chad"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Chad') ? 'selected' : '' ?>>
                                        Chad</option>
                                    <option value="Channel Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Channel Islands') ? 'selected' : '' ?>>
                                        Channel Islands</option>
                                    <option value="Chile"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Chile') ? 'selected' : '' ?>>
                                        Chile</option>
                                    <option value="China"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'China') ? 'selected' : '' ?>>
                                        China</option>
                                    <option value="Christmas Island"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Christmas Island') ? 'selected' : '' ?>>
                                        Christmas Island</option>
                                    <option value="Cocos Island"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cocos Island') ? 'selected' : '' ?>>
                                        Cocos Island</option>
                                    <option value="Colombia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Colombia') ? 'selected' : '' ?>>
                                        Colombia</option>
                                    <option value="Comoros"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Comoros') ? 'selected' : '' ?>>
                                        Comoros</option>
                                    <option value="Congo"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Congo') ? 'selected' : '' ?>>
                                        Congo</option>
                                    <option value="Cook Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cook Islands') ? 'selected' : '' ?>>
                                        Cook Islands</option>
                                    <option value="Costa Rica"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Costa Rica') ? 'selected' : '' ?>>
                                        Costa Rica</option>
                                    <option value="Cote DIvoire"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cote DIvoire') ? 'selected' : '' ?>>
                                        Cote DIvoire</option>
                                    <option value="Croatia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Croatia') ? 'selected' : '' ?>>
                                        Croatia</option>
                                    <option value="Cuba"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cuba') ? 'selected' : '' ?>>
                                        Cuba</option>
                                    <option value="Curaco"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Curaco') ? 'selected' : '' ?>>
                                        Curacao</option>
                                    <option value="Cyprus"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Cyprus') ? 'selected' : '' ?>>
                                        Cyprus</option>
                                    <option value="Czech Republic"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Czech Republic') ? 'selected' : '' ?>>
                                        Czech Republic</option>
                                    <option value="Denmark"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Denmark') ? 'selected' : '' ?>>
                                        Denmark</option>
                                    <option value="Djibouti"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Djibouti') ? 'selected' : '' ?>>
                                        Djibouti</option>
                                    <option value="Dominica"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Dominica') ? 'selected' : '' ?>>
                                        Dominica</option>
                                    <option value="Dominican Republic"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Dominican Republic') ? 'selected' : '' ?>>
                                        Dominican Republic</option>
                                    <option value="East Timor"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'East Timor') ? 'selected' : '' ?>>
                                        East Timor</option>
                                    <option value="Ecuador"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Ecuador') ? 'selected' : '' ?>>
                                        Ecuador</option>
                                    <option value="Egypt"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Egypt') ? 'selected' : '' ?>>
                                        Egypt</option>
                                    <option value="El Salvador"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'El Salvador') ? 'selected' : '' ?>>
                                        El Salvador</option>
                                    <option value="Equatorial Guinea"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Equatorial Guinea') ? 'selected' : '' ?>>
                                        Equatorial Guinea</option>
                                    <option value="Eritrea"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Eritrea') ? 'selected' : '' ?>>
                                        Eritrea</option>
                                    <option value="Estonia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Estonia') ? 'selected' : '' ?>>
                                        Estonia</option>
                                    <option value="Ethiopia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Ethiopia') ? 'selected' : '' ?>>
                                        Ethiopia</option>
                                    <option value="Falkland Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Falkland Islands') ? 'selected' : '' ?>>
                                        Falkland Islands</option>
                                    <option value="Faroe Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Faroe Islands') ? 'selected' : '' ?>>
                                        Faroe Islands</option>
                                    <option value="Fiji"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Fiji') ? 'selected' : '' ?>>
                                        Fiji</option>
                                    <option value="Finland"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Finland') ? 'selected' : '' ?>>
                                        Finland</option>
                                    <option value="France"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'France') ? 'selected' : '' ?>>
                                        France</option>
                                    <option value="French Guiana"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'French Guiana') ? 'selected' : '' ?>>
                                        French Guiana</option>
                                    <option value="French Polynesia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'French Polynesia') ? 'selected' : '' ?>>
                                        French Polynesia</option>
                                    <option value="French Southern Ter"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'French Southern Ter') ? 'selected' : '' ?>>
                                        French Southern Ter</option>
                                    <option value="Gabon"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Gabon') ? 'selected' : '' ?>>
                                        Gabon</option>
                                    <option value="Gambia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Gambia') ? 'selected' : '' ?>>
                                        Gambia</option>
                                    <option value="Georgia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Georgia') ? 'selected' : '' ?>>
                                        Georgia</option>
                                    <option value="Germany"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Germany') ? 'selected' : '' ?>>
                                        Germany</option>
                                    <option value="Ghana"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Ghana') ? 'selected' : '' ?>>
                                        Ghana</option>
                                    <option value="Gibraltar"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Gibraltar') ? 'selected' : '' ?>>
                                        Gibraltar</option>
                                    <option value="Great Britain"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Great Britain') ? 'selected' : '' ?>>
                                        Great Britain</option>
                                    <option value="Greece"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Greece') ? 'selected' : '' ?>>
                                        Greece</option>
                                    <option value="Greenland"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Greenland') ? 'selected' : '' ?>>
                                        Greenland</option>
                                    <option value="Grenada"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Grenada') ? 'selected' : '' ?>>
                                        Grenada</option>
                                    <option value="Guadeloupe"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Guadeloupe') ? 'selected' : '' ?>>
                                        Guadeloupe</option>
                                    <option value="Guam"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Guam') ? 'selected' : '' ?>>
                                        Guam</option>
                                    <option value="Guatemala"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Guatemala') ? 'selected' : '' ?>>
                                        Guatemala</option>
                                    <option value="Guinea"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Guinea') ? 'selected' : '' ?>>
                                        Guinea</option>
                                    <option value="Guyana"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Guyana') ? 'selected' : '' ?>>
                                        Guyana</option>
                                    <option value="Haiti"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Haiti') ? 'selected' : '' ?>>
                                        Haiti</option>
                                    <option value="Hawaii"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Hawaii') ? 'selected' : '' ?>>
                                        Hawaii</option>
                                    <option value="Honduras"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Honduras') ? 'selected' : '' ?>>
                                        Honduras</option>
                                    <option value="Hong Kong"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Hong Kong') ? 'selected' : '' ?>>
                                        Hong Kong</option>
                                    <option value="Hungary"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Hungary') ? 'selected' : '' ?>>
                                        Hungary</option>
                                    <option value="Iceland"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Iceland') ? 'selected' : '' ?>>
                                        Iceland</option>
                                    <option value="Indonesia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Indonesia') ? 'selected' : '' ?>>
                                        Indonesia</option>
                                    <option value="India"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'India') ? 'selected' : '' ?>>
                                        India</option>
                                    <option value="Iran"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Iran') ? 'selected' : '' ?>>
                                        Iran</option>
                                    <option value="Iraq"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Iraq') ? 'selected' : '' ?>>
                                        Iraq</option>
                                    <option value="Ireland"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Ireland') ? 'selected' : '' ?>>
                                        Ireland</option>
                                    <option value="Isle of Man"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Isle of Man') ? 'selected' : '' ?>>
                                        Isle of Man</option>
                                    <option value="Israel"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Israel') ? 'selected' : '' ?>>
                                        Israel</option>
                                    <option value="Italy"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Italy') ? 'selected' : '' ?>>
                                        Italy</option>
                                    <option value="Jamaica"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Jamaica') ? 'selected' : '' ?>>
                                        Jamaica</option>
                                    <option value="Japan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Japan') ? 'selected' : '' ?>>
                                        Japan</option>
                                    <option value="Jordan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Jordan') ? 'selected' : '' ?>>
                                        Jordan</option>
                                    <option value="Kazakhstan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Kazakhstan') ? 'selected' : '' ?>>
                                        Kazakhstan</option>
                                    <option value="Kenya"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Kenya') ? 'selected' : '' ?>>
                                        Kenya</option>
                                    <option value="Kiribati"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Kiribati') ? 'selected' : '' ?>>
                                        Kiribati</option>
                                    <option value="Korea North"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Korea North') ? 'selected' : '' ?>>
                                        Korea North</option>
                                    <option value="Korea Sout"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Korea Sout') ? 'selected' : '' ?>>
                                        Korea South</option>
                                    <option value="Kuwait"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Kuwait') ? 'selected' : '' ?>>
                                        Kuwait</option>
                                    <option value="Kyrgyzstan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Kyrgyzstan') ? 'selected' : '' ?>>
                                        Kyrgyzstan</option>
                                    <option value="Laos"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Laos') ? 'selected' : '' ?>>
                                        Laos</option>
                                    <option value="Latvia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Latvia') ? 'selected' : '' ?>>
                                        Latvia</option>
                                    <option value="Lebanon"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Lebanon') ? 'selected' : '' ?>>
                                        Lebanon</option>
                                    <option value="Lesotho"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Lesotho') ? 'selected' : '' ?>>
                                        Lesotho</option>
                                    <option value="Liberia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Liberia') ? 'selected' : '' ?>>
                                        Liberia</option>
                                    <option value="Libya"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Libya') ? 'selected' : '' ?>>
                                        Libya</option>
                                    <option value="Liechtenstein"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Liechtenstein') ? 'selected' : '' ?>>
                                        Liechtenstein</option>
                                    <option value="Lithuania"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Lithuania') ? 'selected' : '' ?>>
                                        Lithuania</option>
                                    <option value="Luxembourg"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Luxembourg') ? 'selected' : '' ?>>
                                        Luxembourg</option>
                                    <option value="Macau"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Macau') ? 'selected' : '' ?>>
                                        Macau</option>
                                    <option value="Macedonia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Macedonia') ? 'selected' : '' ?>>
                                        Macedonia</option>
                                    <option value="Madagascar"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Madagascar') ? 'selected' : '' ?>>
                                        Madagascar</option>
                                    <option value="Malaysia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Malaysia') ? 'selected' : '' ?>>
                                        Malaysia</option>
                                    <option value="Malawi"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Malawi') ? 'selected' : '' ?>>
                                        Malawi</option>
                                    <option value="Maldives"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Maldives') ? 'selected' : '' ?>>
                                        Maldives</option>
                                    <option value="Mali"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Mali') ? 'selected' : '' ?>>
                                        Mali</option>
                                    <option value="Malta"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Malta') ? 'selected' : '' ?>>
                                        Malta</option>
                                    <option value="Marshall Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Marshall Islands') ? 'selected' : '' ?>>
                                        Marshall Islands</option>
                                    <option value="Martinique"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Martinique') ? 'selected' : '' ?>>
                                        Martinique</option>
                                    <option value="Mauritania"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Mauritania') ? 'selected' : '' ?>>
                                        Mauritania</option>
                                    <option value="Mauritius"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Mauritius') ? 'selected' : '' ?>>
                                        Mauritius</option>
                                    <option value="Mayotte"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Mayotte') ? 'selected' : '' ?>>
                                        Mayotte</option>
                                    <option value="Mexico"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Mexico') ? 'selected' : '' ?>>
                                        Mexico</option>
                                    <option value="Midway Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Midway Islands') ? 'selected' : '' ?>>
                                        Midway Islands</option>
                                    <option value="Moldova"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Moldova') ? 'selected' : '' ?>>
                                        Moldova</option>
                                    <option value="Monaco"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Monaco') ? 'selected' : '' ?>>
                                        Monaco</option>
                                    <option value="Mongolia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Mongolia') ? 'selected' : '' ?>>
                                        Mongolia</option>
                                    <option value="Montserrat"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Montserrat') ? 'selected' : '' ?>>
                                        Montserrat</option>
                                    <option value="Morocco"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Morocco') ? 'selected' : '' ?>>
                                        Morocco</option>
                                    <option value="Mozambique"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Mozambique') ? 'selected' : '' ?>>
                                        Mozambique</option>
                                    <option value="Myanmar"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Myanmar') ? 'selected' : '' ?>>
                                        Myanmar</option>
                                    <option value="Nambia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Nambia') ? 'selected' : '' ?>>
                                        Nambia</option>
                                    <option value="Nauru"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Nauru') ? 'selected' : '' ?>>
                                        Nauru</option>
                                    <option value="Nepal"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Nepal') ? 'selected' : '' ?>>
                                        Nepal</option>
                                    <option value="Netherland Antilles"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Netherland Antilles') ? 'selected' : '' ?>>
                                        Netherland Antilles</option>
                                    <option value="Netherlands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Netherlands') ? 'selected' : '' ?>>
                                        Netherlands (Holland, Europe)</option>
                                    <option value="Nevis"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Nevis') ? 'selected' : '' ?>>
                                        Nevis</option>
                                    <option value="New Caledonia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'New Caledonia') ? 'selected' : '' ?>>
                                        New Caledonia</option>
                                    <option value="New Zealand"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'New Zealand') ? 'selected' : '' ?>>
                                        New Zealand</option>
                                    <option value="Nicaragua"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Nicaragua') ? 'selected' : '' ?>>
                                        Nicaragua</option>
                                    <option value="Niger"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Niger') ? 'selected' : '' ?>>
                                        Niger</option>
                                    <option value="Nigeria"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Nigeria') ? 'selected' : '' ?>>
                                        Nigeria</option>
                                    <option value="Niue"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Niue') ? 'selected' : '' ?>>
                                        Niue</option>
                                    <option value="Norfolk Island"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Norfolk Island') ? 'selected' : '' ?>>
                                        Norfolk Island</option>
                                    <option value="Norway"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Norway') ? 'selected' : '' ?>>
                                        Norway</option>
                                    <option value="Oman"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Oman') ? 'selected' : '' ?>>
                                        Oman</option>
                                    <option value="Pakistan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Pakistan') ? 'selected' : '' ?>>
                                        Pakistan</option>
                                    <option value="Palau Island"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Palau Island') ? 'selected' : '' ?>>
                                        Palau Island</option>
                                    <option value="Palestine"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Palestine') ? 'selected' : '' ?>>
                                        Palestine</option>
                                    <option value="Panama"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Panama') ? 'selected' : '' ?>>
                                        Panama</option>
                                    <option value="Papua New Guinea"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Papua New Guinea') ? 'selected' : '' ?>>
                                        Papua New Guinea</option>
                                    <option value="Paraguay"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Paraguay') ? 'selected' : '' ?>>
                                        Paraguay</option>
                                    <option value="Peru"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Peru') ? 'selected' : '' ?>>
                                        Peru</option>
                                    <option value="Phillipines"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Phillipines') ? 'selected' : '' ?>>
                                        Philippines</option>
                                    <option value="Pitcairn Island"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Pitcairn Island') ? 'selected' : '' ?>>
                                        Pitcairn Island</option>
                                    <option value="Poland"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Poland') ? 'selected' : '' ?>>
                                        Poland</option>
                                    <option value="Portugal"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Portugal') ? 'selected' : '' ?>>
                                        Portugal</option>
                                    <option value="Puerto Rico"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Puerto Rico') ? 'selected' : '' ?>>
                                        Puerto Rico</option>
                                    <option value="Qatar"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Qatar') ? 'selected' : '' ?>>
                                        Qatar</option>
                                    <option value="Republic of Montenegro"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Republic of Montenegro') ? 'selected' : '' ?>>
                                        Republic of Montenegro</option>
                                    <option value="Republic of Serbia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Republic of Serbia') ? 'selected' : '' ?>>
                                        Republic of Serbia</option>
                                    <option value="Reunion"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Reunion') ? 'selected' : '' ?>>
                                        Reunion</option>
                                    <option value="Romania"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Romania') ? 'selected' : '' ?>>
                                        Romania</option>
                                    <option value="Russia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Russia') ? 'selected' : '' ?>>
                                        Russia</option>
                                    <option value="Rwanda"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Rwanda') ? 'selected' : '' ?>>
                                        Rwanda</option>
                                    <option value="St Barthelemy"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'St Barthelemy') ? 'selected' : '' ?>>
                                        St Barthelemy</option>
                                    <option value="St Eustatius"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'St Eustatius') ? 'selected' : '' ?>>
                                        St Eustatius</option>
                                    <option value="St Helena"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'St Helena') ? 'selected' : '' ?>>
                                        St Helena</option>
                                    <option value="St Kitts-Nevis"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'St Kitts-Nevis') ? 'selected' : '' ?>>
                                        St Kitts-Nevis</option>
                                    <option value="St Lucia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'St Lucia') ? 'selected' : '' ?>>
                                        St Lucia</option>
                                    <option value="St Maarten"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'St Maarten') ? 'selected' : '' ?>>
                                        St Maarten</option>
                                    <option value="St Pierre & Miquelon"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'St Pierre & Miquelon') ? 'selected' : '' ?>>
                                        St Pierre & Miquelon</option>
                                    <option value="St Vincent & Grenadines"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'St Vincent & Grenadines') ? 'selected' : '' ?>>
                                        St Vincent & Grenadines</option>
                                    <option value="Saipan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Saipan') ? 'selected' : '' ?>>
                                        Saipan</option>
                                    <option value="Samoa"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Samoa') ? 'selected' : '' ?>>
                                        Samoa</option>
                                    <option value="Samoa American"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Samoa American') ? 'selected' : '' ?>>
                                        Samoa American</option>
                                    <option value="San Marino"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'San Marino') ? 'selected' : '' ?>>
                                        San Marino</option>
                                    <option value="Sao Tome & Principe"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Sao Tome & Principe') ? 'selected' : '' ?>>
                                        Sao Tome & Principe</option>
                                    <option value="Saudi Arabia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Saudi Arabia') ? 'selected' : '' ?>>
                                        Saudi Arabia</option>
                                    <option value="Senegal"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Senegal') ? 'selected' : '' ?>>
                                        Senegal</option>
                                    <option value="Seychelles"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Seychelles') ? 'selected' : '' ?>>
                                        Seychelles</option>
                                    <option value="Sierra Leone"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Sierra Leone') ? 'selected' : '' ?>>
                                        Sierra Leone</option>
                                    <option value="Singapore"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Singapore') ? 'selected' : '' ?>>
                                        Singapore</option>
                                    <option value="Slovakia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Slovakia') ? 'selected' : '' ?>>
                                        Slovakia</option>
                                    <option value="Slovenia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Slovenia') ? 'selected' : '' ?>>
                                        Slovenia</option>
                                    <option value="Solomon Islands"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Solomon Islands') ? 'selected' : '' ?>>
                                        Solomon Islands</option>
                                    <option value="Somalia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Somalia') ? 'selected' : '' ?>>
                                        Somalia</option>
                                    <option value="South Africa"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'South Africa') ? 'selected' : '' ?>>
                                        South Africa</option>
                                    <option value="Spain"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Spain') ? 'selected' : '' ?>>
                                        Spain</option>
                                    <option value="Sri Lanka"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Sri Lanka') ? 'selected' : '' ?>>
                                        Sri Lanka</option>
                                    <option value="Sudan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Sudan') ? 'selected' : '' ?>>
                                        Sudan</option>
                                    <option value="Suriname"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Suriname') ? 'selected' : '' ?>>
                                        Suriname</option>
                                    <option value="Swaziland"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Swaziland') ? 'selected' : '' ?>>
                                        Swaziland</option>
                                    <option value="Sweden"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Sweden') ? 'selected' : '' ?>>
                                        Sweden</option>
                                    <option value="Switzerland"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Switzerland') ? 'selected' : '' ?>>
                                        Switzerland</option>
                                    <option value="Syria"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Syria') ? 'selected' : '' ?>>
                                        Syria</option>
                                    <option value="Tahiti"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Tahiti') ? 'selected' : '' ?>>
                                        Tahiti</option>
                                    <option value="Taiwan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Taiwan') ? 'selected' : '' ?>>
                                        Taiwan</option>
                                    <option value="Tajikistan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Tajikistan') ? 'selected' : '' ?>>
                                        Tajikistan</option>
                                    <option value="Tanzania"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Tanzania') ? 'selected' : '' ?>>
                                        Tanzania</option>
                                    <option value="Thailand"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Thailand') ? 'selected' : '' ?>>
                                        Thailand</option>
                                    <option value="Togo"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Togo') ? 'selected' : '' ?>>
                                        Togo</option>
                                    <option value="Tokelau"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Tokelau') ? 'selected' : '' ?>>
                                        Tokelau</option>
                                    <option value="Tonga"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Tonga') ? 'selected' : '' ?>>
                                        Tonga</option>
                                    <option value="Trinidad & Tobago"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Trinidad & Tobago') ? 'selected' : '' ?>>
                                        Trinidad & Tobago</option>
                                    <option value="Tunisia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Tunisia') ? 'selected' : '' ?>>
                                        Tunisia</option>
                                    <option value="Turkey"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Turkey') ? 'selected' : '' ?>>
                                        Turkey</option>
                                    <option value="Turkmenistan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Turkmenistan') ? 'selected' : '' ?>>
                                        Turkmenistan</option>
                                    <option value="Turks & Caicos Is"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Turks & Caicos Is') ? 'selected' : '' ?>>
                                        Turks & Caicos Is</option>
                                    <option value="Tuvalu"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Tuvalu') ? 'selected' : '' ?>>
                                        Tuvalu</option>
                                    <option value="Uganda"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Uganda') ? 'selected' : '' ?>>
                                        Uganda</option>
                                    <option value="United Kingdom"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'United Kingdom') ? 'selected' : '' ?>>
                                        United Kingdom</option>
                                    <option value="Ukraine"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Ukraine') ? 'selected' : '' ?>>
                                        Ukraine</option>
                                    <option value="United Arab Erimates"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'United Arab Erimates') ? 'selected' : '' ?>>
                                        United Arab Emirates</option>
                                    <option value="United States of America"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'United States of America') ? 'selected' : '' ?>>
                                        United States of America</option>
                                    <option value="Uraguay"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Uraguay') ? 'selected' : '' ?>>
                                        Uruguay</option>
                                    <option value="Uzbekistan"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Uzbekistan') ? 'selected' : '' ?>>
                                        Uzbekistan</option>
                                    <option value="Vanuatu"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Vanuatu') ? 'selected' : '' ?>>
                                        Vanuatu</option>
                                    <option value="Vatican City State"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Vatican City State') ? 'selected' : '' ?>>
                                        Vatican City State</option>
                                    <option value="Venezuela"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Venezuela') ? 'selected' : '' ?>>
                                        Venezuela</option>
                                    <option value="Vietnam"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Vietnam') ? 'selected' : '' ?>>
                                        Vietnam</option>
                                    <option value="Virgin Islands (Brit)"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Virgin Islands (Brit)') ? 'selected' : '' ?>>
                                        Virgin Islands (Brit)</option>
                                    <option value="Virgin Islands (USA)"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Virgin Islands (USA)') ? 'selected' : '' ?>>
                                        Virgin Islands (USA)</option>
                                    <option value="Wake Island"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Wake Island') ? 'selected' : '' ?>>
                                        Wake Island</option>
                                    <option value="Wallis & Futana Is"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Wallis & Futana Is') ? 'selected' : '' ?>>
                                        Wallis & Futana Is</option>
                                    <option value="Yemen"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Yemen') ? 'selected' : '' ?>>
                                        Yemen</option>
                                    <option value="Zaire"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Zaire') ? 'selected' : '' ?>>
                                        Zaire</option>
                                    <option value="Zambia"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Zambia') ? 'selected' : '' ?>>
                                        Zambia</option>
                                    <option value="Zimbabwe"
                                        <?= ($prefilled_beneficiary && $prefilled_beneficiary['country'] == 'Zimbabwe') ? 'selected' : '' ?>>
                                        Zimbabwe</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a country
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-file-alt"></i>
                                </span>
                                <input type="text" class="form-control" name="description" id="description"
                                    placeholder="Select or type description" list="description_options" required>
                                <datalist id="description_options">
                                    <option value="Salary Payment">
                                    <option value="Invoice Payment">
                                    <option value="Fund Transfer">
                                    <option value="Loan Repayment">
                                    <option value="Investment">
                                    <option value="Bill Payment">
                                    <option value="Shopping">
                                    <option value="Emergency Funds">
                                    <option value="Travel Expenses">
                                    <option value="Business Expense">
                                    <option value="Personal Use">
                                    <option value="Family Support">
                                    <option value="Education Fees">
                                    <option value="Medical Expenses">
                                    <option value="Rent Payment">
                                </datalist>
                            </div>

                            <div class="invalid-feedback">
                                Please provide a description for this transaction.
                            </div>
                        </div>
                    </div>

                    <!-- Save Beneficiary Option - Only show if not using existing beneficiary -->
                    <?php if (!$prefilled_beneficiary): ?>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="save_beneficiary"
                                    id="save_beneficiary">
                                <label class="form-check-label" for="save_beneficiary">
                                    Save this beneficiary for future transfers
                                </label>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info bg-light border-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <div>
                                <strong>Using saved beneficiary:</strong>
                                <?= htmlspecialchars($prefilled_beneficiary['account_name']) ?>
                                (<?= htmlspecialchars($prefilled_beneficiary['account_number']) ?>)
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Fee Information -->
                    <div class="alert alert-info bg-light border-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <div>
                                <strong>Transfer Fee:</strong> You will be charged a fee of
                                <span
                                    class="text-primary fw-bold"><?= $row['acct_currency'] ?><?= $page['domesticfee'] ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Account Balance -->
                    <div class="alert alert-light border">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <strong>Available Balance:</strong>
                                <span
                                    class="text-success fw-bold"><?= $currency ?><?= number_format($row['acct_balance'], 2) ?></span>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <strong>Daily Limit:</strong>
                                <span
                                    class="text-primary fw-bold"><?= $currency ?><?= number_format($row['limit_remain'], 2) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions mt-4 pt-3 border-top">
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="button" onclick="location.reload();"
                                    class="btn btn-outline-secondary btn-lg w-100">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-lg w-100" name="domestic-transfer">
                                    <i class="fas fa-paper-plane me-2"></i>Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shield-alt text-success fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">Secure Transfer</h6>
                        <p class="text-muted mb-0">Your transaction is protected by bank-level security encryption.
                            Always verify beneficiary details before transferring.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else: ?>

<div class="row">
    <div class="col-xl-6 col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="error-icon mb-4">
                    <div class="avatar avatar-lg bg-danger bg-opacity-10 rounded-circle mx-auto">
                        <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                    </div>
                </div>
                <h3 class="text-danger mb-3">Transfer Service Unavailable</h3>
                <p class="text-muted mb-4">You cannot transfer at this time. Kindly contact our support team for
                    assistance.</p>

                <div class="error-actions">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="javascript:history.go(-1)" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="fas fa-arrow-left me-2"></i>Go Back
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="./support.php" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-headset me-2"></i>Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<style>
.card {
    border-radius: 12px;
    border: 1px solid #eef2f7;
}

.card-header {
    padding: 1.5rem 1.5rem 0.5rem;
    background: transparent;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.input-group-text {
    border: 1px solid #e2e8f0;
    border-right: none;
    min-width: 45px;
    justify-content: center;
}

.form-control,
.form-select {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    height: auto;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.1);
}

.form-control.ps-2 {
    padding-left: 0.75rem;
}

.alert {
    border-radius: 8px;
}

.alert-info {
    background-color: rgba(var(--primary-rgb), 0.05);
    border: 1px solid rgba(var(--primary-rgb), 0.1);
}

.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
}

.btn {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-lg {
    padding: 0.875rem 1.5rem;
    font-size: 1rem;
}

.btn-primary {
    background: var(--primary);
    border-color: var(--primary);
}

.text-primary {
    color: var(--primary) !important;
}

.bg-primary {
    background-color: var(--primary) !important;
}

.btn-primary:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.3);
}

.btn-outline-secondary:hover {
    transform: translateY(-1px);
}

.invalid-feedback {
    font-size: 0.875rem;
}

.form-actions {
    border-top: 1px solid #eef2f7;
}

.beneficiary-select {
    background-color: #f8f9fa;
    border: 2px dashed #dee2e6;
}

.beneficiary-select:focus {
    border-color: var(--primary);
    background-color: #fff;
}

input[list] {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    padding-right: 40px;
}

/* Professional color adjustments */
:root {
    --primary-rgb: 30, 170, 231;
}

/* Responsive design */
@media (max-width: 768px) {
    .card-body {
        padding: 1.25rem;
    }

    .btn-lg {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .alert .row {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }

    .form-head {
        text-align: center;
    }

    .error-actions .row {
        flex-direction: column;
    }

    .error-actions .col-6 {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Beneficiary selection
    const beneficiarySelect = document.getElementById('beneficiarySelect');
    if (beneficiarySelect) {
        beneficiarySelect.addEventListener('change', function() {
            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById('account_number').value = selectedOption.dataset.accountNumber;
                document.getElementById('account_name').value = selectedOption.dataset.accountName;
                document.getElementById('bank_name').value = selectedOption.dataset.bankName;
                document.getElementById('account_type').value = selectedOption.dataset.accountType;
                document.getElementById('bank_country').value = selectedOption.dataset.country;

                // Uncheck save beneficiary when selecting existing
                const saveCheckbox = document.getElementById('save_beneficiary');
                if (saveCheckbox) {
                    saveCheckbox.checked = false;
                }

                // Remove URL parameter to avoid confusion
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.delete('beneficiary');
                    window.history.replaceState({}, '', url);
                }
            }
        });
    }

    // Auto-select beneficiary from URL parameter on page load
    const urlParams = new URLSearchParams(window.location.search);
    const beneficiaryId = urlParams.get('beneficiary');
    if (beneficiaryId && beneficiarySelect) {
        // Find and select the option
        for (let option of beneficiarySelect.options) {
            if (option.value === beneficiaryId) {
                beneficiarySelect.value = beneficiaryId;
                // Trigger change event to populate form
                const event = new Event('change');
                beneficiarySelect.dispatchEvent(event);
                break;
            }
        }
    }

    // Real-time account number validation
    const accountNumberInput = document.getElementById('account_number');
    if (accountNumberInput) {
        accountNumberInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    // Real-time amount validation
    const amountInput = document.querySelector('input[name="amount"]');
    if (amountInput) {
        amountInput.addEventListener('input', function(e) {
            const currentBalance = <?= $row['acct_balance'] ?>;
            const enteredAmount = parseFloat(this.value) || 0;

            if (enteredAmount > currentBalance) {
                this.setCustomValidity('Insufficient funds');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Add smooth animations
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.style.animation = 'fadeInUp 0.6s ease-out';
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
`;
document.head.appendChild(style);
</script>
<script>
// Enhanced bank autocomplete
document.addEventListener('DOMContentLoaded', function() {
    const bankInputs = document.querySelectorAll('input[name="bank_name"]');
    const banks = <?= $banks_json ?>;

    bankInputs.forEach(input => {
        // Create datalist if it doesn't exist
        let datalist = input.list;
        if (!datalist) {
            datalist = document.createElement('datalist');
            datalist.id = 'bank_suggestions_' + Math.random().toString(36).substr(2, 9);
            input.setAttribute('list', datalist.id);
            document.body.appendChild(datalist);

            // Populate datalist
            banks.forEach(bank => {
                const option = document.createElement('option');
                option.value = bank;
                datalist.appendChild(option);
            });
        }

        // Enhanced input handling
        input.addEventListener('input', function() {
            const value = this.value.toLowerCase();

            // You can add custom filtering logic here if needed
            if (value.length > 2) {
                // Optional: Show custom dropdown or suggestions
                console.log('Searching for:', value);
            }
        });

        // Add clear button functionality
        const clearButton = document.createElement('button');
        clearButton.type = 'button';
        clearButton.className = 'btn btn-sm btn-outline-secondary';
        clearButton.innerHTML = '<i class="fas fa-times"></i>';
        clearButton.style.display = 'none';

        clearButton.addEventListener('click', function() {
            input.value = '';
            input.focus();
            this.style.display = 'none';
        });

        input.addEventListener('input', function() {
            clearButton.style.display = this.value ? 'block' : 'none';
        });

        // Add clear button to input group if not already present
        if (!input.parentNode.querySelector('.input-clear')) {
            clearButton.classList.add('input-clear');
            input.parentNode.appendChild(clearButton);
        }
    });
});
</script>
<?php include 'layout/footer.php'; ?>