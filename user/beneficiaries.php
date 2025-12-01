<?php
require_once __DIR__ . '/../config.php';
$current_page = 'beneficiaries';
$page_title = 'Manage Beneficiaries';
include 'layout/header.php';
include '../include/aza.php';

$user_id = userDetails('id');

// Handle form actions
if ($_POST) {
    if (isset($_POST['add_beneficiary'])) {
        $account_number = $_POST['account_number'];
        $bank_name = $_POST['bank_name'];
        $account_name = $_POST['account_name'];
        $country = $_POST['country'];
        $account_type = $_POST['account_type'];
        $nickname = $_POST['nickname'] ?? null;

        try {
            $stmt = $conn->prepare("INSERT INTO beneficiaries (user_id, account_number, bank_name, account_name, country, account_type, nickname) 
                                   VALUES (:user_id, :account_number, :bank_name, :account_name, :country, :account_type, :nickname)");
            $stmt->execute([
                'user_id' => $user_id,
                'account_number' => $account_number,
                'bank_name' => $bank_name,
                'account_name' => $account_name,
                'country' => $country,
                'account_type' => $account_type,
                'nickname' => $nickname
            ]);
            $success = "Beneficiary added successfully!";
        } catch (Exception $e) {
            $error = "Error adding beneficiary: " . $e->getMessage();
        }
    }

    if (isset($_POST['update_beneficiary'])) {
        $id = $_POST['id'];
        $account_number = $_POST['account_number'];
        $bank_name = $_POST['bank_name'];
        $account_name = $_POST['account_name'];
        $country = $_POST['country'];
        $account_type = $_POST['account_type'];
        $nickname = $_POST['nickname'] ?? null;

        try {
            $stmt = $conn->prepare("UPDATE beneficiaries SET account_number = :account_number, bank_name = :bank_name, 
                                   account_name = :account_name, country = :country, account_type = :account_type, 
                                   nickname = :nickname WHERE id = :id AND user_id = :user_id");
            $stmt->execute([
                'id' => $id,
                'account_number' => $account_number,
                'bank_name' => $bank_name,
                'account_name' => $account_name,
                'country' => $country,
                'account_type' => $account_type,
                'nickname' => $nickname,
                'user_id' => $user_id
            ]);
            $success = "Beneficiary updated successfully!";
        } catch (Exception $e) {
            $error = "Error updating beneficiary: " . $e->getMessage();
        }
    }

    if (isset($_POST['delete_beneficiary'])) {
        $id = $_POST['id'];

        try {
            $stmt = $conn->prepare("UPDATE beneficiaries SET is_active = 0 WHERE id = :id AND user_id = :user_id");
            $stmt->execute(['id' => $id, 'user_id' => $user_id]);
            $success = "Beneficiary deleted successfully!";
        } catch (Exception $e) {
            $error = "Error deleting beneficiary: " . $e->getMessage();
        }
    }
}

// Fetch user's beneficiaries
try {
    $stmt = $conn->prepare("SELECT * FROM beneficiaries WHERE user_id = :user_id AND is_active = 1 ORDER BY account_name ASC");
    $stmt->execute(['user_id' => $user_id]);
    $beneficiaries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $beneficiaries = [];
    $error = "Error loading beneficiaries: " . $e->getMessage();
}
?>

<div class="form-head mb-4">
    <h2 class="text-primary font-w600 mb-2">Manage Beneficiaries</h2>
    <p class="mb-0 text-muted">Add, edit, or remove your saved beneficiaries</p>
</div>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= $success ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Add Beneficiary Form -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title mb-1 text-primary">
                    <?= isset($_GET['edit']) ? 'Edit Beneficiary' : 'Add New Beneficiary' ?>
                </h5>

            </div>
            <div class="card-body bg-light">
                <form method="POST" class="needs-validation" novalidate>
                    <?php if (isset($_GET['edit'])):
                        $edit_stmt = $conn->prepare("SELECT * FROM beneficiaries WHERE id = :id AND user_id = :user_id");
                        $edit_stmt->execute(['id' => $_GET['edit'], 'user_id' => $user_id]);
                        $edit_beneficiary = $edit_stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <input type="hidden" name="id" value="<?= $edit_beneficiary['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Account Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <input type="text" class="form-control" name="account_number"
                                value="<?= $edit_beneficiary['account_number'] ?? '' ?>" placeholder="0123456789"
                                required pattern="[0-9]{10,12}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" name="account_name"
                                value="<?= $edit_beneficiary['account_name'] ?? '' ?>" placeholder="John Doe" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-landmark"></i>
                            </span>
                            <input type="text" class="form-control" name="bank_name" id="bank_name"
                                value="<?= $edit_beneficiary['bank_name'] ?? '' ?>" placeholder="Enter bank name..."
                                list="bank_suggestions" required>
                            <datalist id="bank_suggestions">
                                <?php foreach ($banks_list as $bank): ?>
                                    <option value="<?= htmlspecialchars($bank) ?>">
                                    <?php endforeach; ?>
                            </datalist>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-globe"></i>
                            </span>
                            <select class="form-control" name="country" required>
                                <option value="">Select Country</option>
                                <option value="Afganistan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Afganistan' ? 'selected' : '' ?>>
                                    Afghanistan</option>
                                <option value="Albania"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Albania' ? 'selected' : '' ?>>Albania
                                </option>
                                <option value="Algeria"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Algeria' ? 'selected' : '' ?>>Algeria
                                </option>
                                <option value="American Samoa"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'American Samoa' ? 'selected' : '' ?>>
                                    American Samoa</option>
                                <option value="Andorra"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Andorra' ? 'selected' : '' ?>>Andorra
                                </option>
                                <option value="Angola"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Angola' ? 'selected' : '' ?>>Angola
                                </option>
                                <option value="Anguilla"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Anguilla' ? 'selected' : '' ?>>Anguilla
                                </option>
                                <option value="Antigua & Barbuda"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Antigua & Barbuda' ? 'selected' : '' ?>>
                                    Antigua & Barbuda</option>
                                <option value="Argentina"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Argentina' ? 'selected' : '' ?>>
                                    Argentina</option>
                                <option value="Armenia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Armenia' ? 'selected' : '' ?>>Armenia
                                </option>
                                <option value="Aruba"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Aruba' ? 'selected' : '' ?>>Aruba
                                </option>
                                <option value="Australia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Australia' ? 'selected' : '' ?>>
                                    Australia</option>
                                <option value="Austria"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Austria' ? 'selected' : '' ?>>Austria
                                </option>
                                <option value="Azerbaijan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Azerbaijan' ? 'selected' : '' ?>>
                                    Azerbaijan</option>
                                <option value="Bahamas"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bahamas' ? 'selected' : '' ?>>Bahamas
                                </option>
                                <option value="Bahrain"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bahrain' ? 'selected' : '' ?>>Bahrain
                                </option>
                                <option value="Bangladesh"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bangladesh' ? 'selected' : '' ?>>
                                    Bangladesh</option>
                                <option value="Barbados"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Barbados' ? 'selected' : '' ?>>Barbados
                                </option>
                                <option value="Belarus"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Belarus' ? 'selected' : '' ?>>Belarus
                                </option>
                                <option value="Belgium"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Belgium' ? 'selected' : '' ?>>Belgium
                                </option>
                                <option value="Belize"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Belize' ? 'selected' : '' ?>>Belize
                                </option>
                                <option value="Benin"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Benin' ? 'selected' : '' ?>>Benin
                                </option>
                                <option value="Bermuda"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bermuda' ? 'selected' : '' ?>>Bermuda
                                </option>
                                <option value="Bhutan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bhutan' ? 'selected' : '' ?>>Bhutan
                                </option>
                                <option value="Bolivia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bolivia' ? 'selected' : '' ?>>Bolivia
                                </option>
                                <option value="Bonaire"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bonaire' ? 'selected' : '' ?>>Bonaire
                                </option>
                                <option value="Bosnia & Herzegovina"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bosnia & Herzegovina' ? 'selected' : '' ?>>
                                    Bosnia & Herzegovina</option>
                                <option value="Botswana"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Botswana' ? 'selected' : '' ?>>Botswana
                                </option>
                                <option value="Brazil"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Brazil' ? 'selected' : '' ?>>Brazil
                                </option>
                                <option value="British Indian Ocean Ter"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'British Indian Ocean Ter' ? 'selected' : '' ?>>
                                    British Indian Ocean Ter</option>
                                <option value="Brunei"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Brunei' ? 'selected' : '' ?>>Brunei
                                </option>
                                <option value="Bulgaria"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Bulgaria' ? 'selected' : '' ?>>Bulgaria
                                </option>
                                <option value="Burkina Faso"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Burkina Faso' ? 'selected' : '' ?>>
                                    Burkina Faso</option>
                                <option value="Burundi"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Burundi' ? 'selected' : '' ?>>Burundi
                                </option>
                                <option value="Cambodia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cambodia' ? 'selected' : '' ?>>Cambodia
                                </option>
                                <option value="Cameroon"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cameroon' ? 'selected' : '' ?>>Cameroon
                                </option>
                                <option value="Canada"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Canada' ? 'selected' : '' ?>>Canada
                                </option>
                                <option value="Canary Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Canary Islands' ? 'selected' : '' ?>>
                                    Canary Islands</option>
                                <option value="Cape Verde"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cape Verde' ? 'selected' : '' ?>>Cape
                                    Verde</option>
                                <option value="Cayman Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cayman Islands' ? 'selected' : '' ?>>
                                    Cayman Islands</option>
                                <option value="Central African Republic"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Central African Republic' ? 'selected' : '' ?>>
                                    Central African Republic</option>
                                <option value="Chad"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Chad' ? 'selected' : '' ?>>Chad
                                </option>
                                <option value="Channel Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Channel Islands' ? 'selected' : '' ?>>
                                    Channel Islands</option>
                                <option value="Chile"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Chile' ? 'selected' : '' ?>>Chile
                                </option>
                                <option value="China"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'China' ? 'selected' : '' ?>>China
                                </option>
                                <option value="Christmas Island"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Christmas Island' ? 'selected' : '' ?>>
                                    Christmas Island</option>
                                <option value="Cocos Island"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cocos Island' ? 'selected' : '' ?>>
                                    Cocos Island</option>
                                <option value="Colombia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Colombia' ? 'selected' : '' ?>>Colombia
                                </option>
                                <option value="Comoros"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Comoros' ? 'selected' : '' ?>>Comoros
                                </option>
                                <option value="Congo"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Congo' ? 'selected' : '' ?>>Congo
                                </option>
                                <option value="Cook Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cook Islands' ? 'selected' : '' ?>>Cook
                                    Islands</option>
                                <option value="Costa Rica"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Costa Rica' ? 'selected' : '' ?>>Costa
                                    Rica</option>
                                <option value="Cote DIvoire"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cote DIvoire' ? 'selected' : '' ?>>Cote
                                    DIvoire</option>
                                <option value="Croatia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Croatia' ? 'selected' : '' ?>>Croatia
                                </option>
                                <option value="Cuba"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cuba' ? 'selected' : '' ?>>Cuba
                                </option>
                                <option value="Curaco"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Curaco' ? 'selected' : '' ?>>Curacao
                                </option>
                                <option value="Cyprus"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Cyprus' ? 'selected' : '' ?>>Cyprus
                                </option>
                                <option value="Czech Republic"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Czech Republic' ? 'selected' : '' ?>>
                                    Czech Republic</option>
                                <option value="Denmark"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Denmark' ? 'selected' : '' ?>>Denmark
                                </option>
                                <option value="Djibouti"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Djibouti' ? 'selected' : '' ?>>Djibouti
                                </option>
                                <option value="Dominica"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Dominica' ? 'selected' : '' ?>>Dominica
                                </option>
                                <option value="Dominican Republic"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Dominican Republic' ? 'selected' : '' ?>>
                                    Dominican Republic</option>
                                <option value="East Timor"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'East Timor' ? 'selected' : '' ?>>East
                                    Timor</option>
                                <option value="Ecuador"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Ecuador' ? 'selected' : '' ?>>Ecuador
                                </option>
                                <option value="Egypt"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Egypt' ? 'selected' : '' ?>>Egypt
                                </option>
                                <option value="El Salvador"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'El Salvador' ? 'selected' : '' ?>>El
                                    Salvador</option>
                                <option value="Equatorial Guinea"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Equatorial Guinea' ? 'selected' : '' ?>>
                                    Equatorial Guinea</option>
                                <option value="Eritrea"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Eritrea' ? 'selected' : '' ?>>Eritrea
                                </option>
                                <option value="Estonia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Estonia' ? 'selected' : '' ?>>Estonia
                                </option>
                                <option value="Ethiopia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Ethiopia' ? 'selected' : '' ?>>Ethiopia
                                </option>
                                <option value="Falkland Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Falkland Islands' ? 'selected' : '' ?>>
                                    Falkland Islands</option>
                                <option value="Faroe Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Faroe Islands' ? 'selected' : '' ?>>
                                    Faroe Islands</option>
                                <option value="Fiji"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Fiji' ? 'selected' : '' ?>>Fiji
                                </option>
                                <option value="Finland"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Finland' ? 'selected' : '' ?>>Finland
                                </option>
                                <option value="France"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'France' ? 'selected' : '' ?>>France
                                </option>
                                <option value="French Guiana"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'French Guiana' ? 'selected' : '' ?>>
                                    French Guiana</option>
                                <option value="French Polynesia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'French Polynesia' ? 'selected' : '' ?>>
                                    French Polynesia</option>
                                <option value="French Southern Ter"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'French Southern Ter' ? 'selected' : '' ?>>
                                    French Southern Ter</option>
                                <option value="Gabon"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Gabon' ? 'selected' : '' ?>>Gabon
                                </option>
                                <option value="Gambia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Gambia' ? 'selected' : '' ?>>Gambia
                                </option>
                                <option value="Georgia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Georgia' ? 'selected' : '' ?>>Georgia
                                </option>
                                <option value="Germany"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Germany' ? 'selected' : '' ?>>Germany
                                </option>
                                <option value="Ghana"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Ghana' ? 'selected' : '' ?>>Ghana
                                </option>
                                <option value="Gibraltar"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Gibraltar' ? 'selected' : '' ?>>
                                    Gibraltar</option>
                                <option value="Great Britain"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Great Britain' ? 'selected' : '' ?>>
                                    Great Britain</option>
                                <option value="Greece"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Greece' ? 'selected' : '' ?>>Greece
                                </option>
                                <option value="Greenland"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Greenland' ? 'selected' : '' ?>>
                                    Greenland</option>
                                <option value="Grenada"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Grenada' ? 'selected' : '' ?>>Grenada
                                </option>
                                <option value="Guadeloupe"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Guadeloupe' ? 'selected' : '' ?>>
                                    Guadeloupe</option>
                                <option value="Guam"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Guam' ? 'selected' : '' ?>>Guam
                                </option>
                                <option value="Guatemala"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Guatemala' ? 'selected' : '' ?>>
                                    Guatemala</option>
                                <option value="Guinea"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Guinea' ? 'selected' : '' ?>>Guinea
                                </option>
                                <option value="Guyana"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Guyana' ? 'selected' : '' ?>>Guyana
                                </option>
                                <option value="Haiti"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Haiti' ? 'selected' : '' ?>>Haiti
                                </option>
                                <option value="Hawaii"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Hawaii' ? 'selected' : '' ?>>Hawaii
                                </option>
                                <option value="Honduras"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Honduras' ? 'selected' : '' ?>>Honduras
                                </option>
                                <option value="Hong Kong"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Hong Kong' ? 'selected' : '' ?>>Hong
                                    Kong</option>
                                <option value="Hungary"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Hungary' ? 'selected' : '' ?>>Hungary
                                </option>
                                <option value="Iceland"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Iceland' ? 'selected' : '' ?>>Iceland
                                </option>
                                <option value="Indonesia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Indonesia' ? 'selected' : '' ?>>
                                    Indonesia</option>
                                <option value="India"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'India' ? 'selected' : '' ?>>India
                                </option>
                                <option value="Iran"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Iran' ? 'selected' : '' ?>>Iran
                                </option>
                                <option value="Iraq"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Iraq' ? 'selected' : '' ?>>Iraq
                                </option>
                                <option value="Ireland"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Ireland' ? 'selected' : '' ?>>Ireland
                                </option>
                                <option value="Isle of Man"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Isle of Man' ? 'selected' : '' ?>>Isle
                                    of Man</option>
                                <option value="Israel"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Israel' ? 'selected' : '' ?>>Israel
                                </option>
                                <option value="Italy"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Italy' ? 'selected' : '' ?>>Italy
                                </option>
                                <option value="Jamaica"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Jamaica' ? 'selected' : '' ?>>Jamaica
                                </option>
                                <option value="Japan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Japan' ? 'selected' : '' ?>>Japan
                                </option>
                                <option value="Jordan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Jordan' ? 'selected' : '' ?>>Jordan
                                </option>
                                <option value="Kazakhstan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Kazakhstan' ? 'selected' : '' ?>>
                                    Kazakhstan</option>
                                <option value="Kenya"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Kenya' ? 'selected' : '' ?>>Kenya
                                </option>
                                <option value="Kiribati"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Kiribati' ? 'selected' : '' ?>>Kiribati
                                </option>
                                <option value="Korea North"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Korea North' ? 'selected' : '' ?>>Korea
                                    North</option>
                                <option value="Korea Sout"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Korea Sout' ? 'selected' : '' ?>>Korea
                                    South</option>
                                <option value="Kuwait"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Kuwait' ? 'selected' : '' ?>>Kuwait
                                </option>
                                <option value="Kyrgyzstan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Kyrgyzstan' ? 'selected' : '' ?>>
                                    Kyrgyzstan</option>
                                <option value="Laos"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Laos' ? 'selected' : '' ?>>Laos
                                </option>
                                <option value="Latvia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Latvia' ? 'selected' : '' ?>>Latvia
                                </option>
                                <option value="Lebanon"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Lebanon' ? 'selected' : '' ?>>Lebanon
                                </option>
                                <option value="Lesotho"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Lesotho' ? 'selected' : '' ?>>Lesotho
                                </option>
                                <option value="Liberia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Liberia' ? 'selected' : '' ?>>Liberia
                                </option>
                                <option value="Libya"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Libya' ? 'selected' : '' ?>>Libya
                                </option>
                                <option value="Liechtenstein"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Liechtenstein' ? 'selected' : '' ?>>
                                    Liechtenstein</option>
                                <option value="Lithuania"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Lithuania' ? 'selected' : '' ?>>
                                    Lithuania</option>
                                <option value="Luxembourg"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Luxembourg' ? 'selected' : '' ?>>
                                    Luxembourg</option>
                                <option value="Macau"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Macau' ? 'selected' : '' ?>>Macau
                                </option>
                                <option value="Macedonia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Macedonia' ? 'selected' : '' ?>>
                                    Macedonia</option>
                                <option value="Madagascar"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Madagascar' ? 'selected' : '' ?>>
                                    Madagascar</option>
                                <option value="Malaysia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Malaysia' ? 'selected' : '' ?>>Malaysia
                                </option>
                                <option value="Malawi"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Malawi' ? 'selected' : '' ?>>Malawi
                                </option>
                                <option value="Maldives"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Maldives' ? 'selected' : '' ?>>Maldives
                                </option>
                                <option value="Mali"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Mali' ? 'selected' : '' ?>>Mali
                                </option>
                                <option value="Malta"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Malta' ? 'selected' : '' ?>>Malta
                                </option>
                                <option value="Marshall Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Marshall Islands' ? 'selected' : '' ?>>
                                    Marshall Islands</option>
                                <option value="Martinique"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Martinique' ? 'selected' : '' ?>>
                                    Martinique</option>
                                <option value="Mauritania"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Mauritania' ? 'selected' : '' ?>>
                                    Mauritania</option>
                                <option value="Mauritius"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Mauritius' ? 'selected' : '' ?>>
                                    Mauritius</option>
                                <option value="Mayotte"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Mayotte' ? 'selected' : '' ?>>Mayotte
                                </option>
                                <option value="Mexico"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Mexico' ? 'selected' : '' ?>>Mexico
                                </option>
                                <option value="Midway Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Midway Islands' ? 'selected' : '' ?>>
                                    Midway Islands</option>
                                <option value="Moldova"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Moldova' ? 'selected' : '' ?>>Moldova
                                </option>
                                <option value="Monaco"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Monaco' ? 'selected' : '' ?>>Monaco
                                </option>
                                <option value="Mongolia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Mongolia' ? 'selected' : '' ?>>Mongolia
                                </option>
                                <option value="Montserrat"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Montserrat' ? 'selected' : '' ?>>
                                    Montserrat</option>
                                <option value="Morocco"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Morocco' ? 'selected' : '' ?>>Morocco
                                </option>
                                <option value="Mozambique"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Mozambique' ? 'selected' : '' ?>>
                                    Mozambique</option>
                                <option value="Myanmar"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Myanmar' ? 'selected' : '' ?>>Myanmar
                                </option>
                                <option value="Nambia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Nambia' ? 'selected' : '' ?>>Nambia
                                </option>
                                <option value="Nauru"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Nauru' ? 'selected' : '' ?>>Nauru
                                </option>
                                <option value="Nepal"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Nepal' ? 'selected' : '' ?>>Nepal
                                </option>
                                <option value="Netherland Antilles"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Netherland Antilles' ? 'selected' : '' ?>>
                                    Netherland Antilles</option>
                                <option value="Netherlands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Netherlands' ? 'selected' : '' ?>>
                                    Netherlands (Holland, Europe)</option>
                                <option value="Nevis"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Nevis' ? 'selected' : '' ?>>Nevis
                                </option>
                                <option value="New Caledonia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'New Caledonia' ? 'selected' : '' ?>>New
                                    Caledonia</option>
                                <option value="New Zealand"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'New Zealand' ? 'selected' : '' ?>>New
                                    Zealand</option>
                                <option value="Nicaragua"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Nicaragua' ? 'selected' : '' ?>>
                                    Nicaragua</option>
                                <option value="Niger"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Niger' ? 'selected' : '' ?>>Niger
                                </option>
                                <option value="Nigeria"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Nigeria' ? 'selected' : '' ?>>Nigeria
                                </option>
                                <option value="Niue"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Niue' ? 'selected' : '' ?>>Niue
                                </option>
                                <option value="Norfolk Island"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Norfolk Island' ? 'selected' : '' ?>>
                                    Norfolk Island</option>
                                <option value="Norway"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Norway' ? 'selected' : '' ?>>Norway
                                </option>
                                <option value="Oman"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Oman' ? 'selected' : '' ?>>Oman
                                </option>
                                <option value="Pakistan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Pakistan' ? 'selected' : '' ?>>Pakistan
                                </option>
                                <option value="Palau Island"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Palau Island' ? 'selected' : '' ?>>
                                    Palau Island</option>
                                <option value="Palestine"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Palestine' ? 'selected' : '' ?>>
                                    Palestine</option>
                                <option value="Panama"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Panama' ? 'selected' : '' ?>>Panama
                                </option>
                                <option value="Papua New Guinea"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Papua New Guinea' ? 'selected' : '' ?>>
                                    Papua New Guinea</option>
                                <option value="Paraguay"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Paraguay' ? 'selected' : '' ?>>Paraguay
                                </option>
                                <option value="Peru"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Peru' ? 'selected' : '' ?>>Peru
                                </option>
                                <option value="Phillipines"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Phillipines' ? 'selected' : '' ?>>
                                    Philippines</option>
                                <option value="Pitcairn Island"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Pitcairn Island' ? 'selected' : '' ?>>
                                    Pitcairn Island</option>
                                <option value="Poland"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Poland' ? 'selected' : '' ?>>Poland
                                </option>
                                <option value="Portugal"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Portugal' ? 'selected' : '' ?>>Portugal
                                </option>
                                <option value="Puerto Rico"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Puerto Rico' ? 'selected' : '' ?>>
                                    Puerto Rico</option>
                                <option value="Qatar"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Qatar' ? 'selected' : '' ?>>Qatar
                                </option>
                                <option value="Republic of Montenegro"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Republic of Montenegro' ? 'selected' : '' ?>>
                                    Republic of Montenegro</option>
                                <option value="Republic of Serbia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Republic of Serbia' ? 'selected' : '' ?>>
                                    Republic of Serbia</option>
                                <option value="Reunion"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Reunion' ? 'selected' : '' ?>>Reunion
                                </option>
                                <option value="Romania"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Romania' ? 'selected' : '' ?>>Romania
                                </option>
                                <option value="Russia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Russia' ? 'selected' : '' ?>>Russia
                                </option>
                                <option value="Rwanda"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Rwanda' ? 'selected' : '' ?>>Rwanda
                                </option>
                                <option value="St Barthelemy"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'St Barthelemy' ? 'selected' : '' ?>>St
                                    Barthelemy</option>
                                <option value="St Eustatius"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'St Eustatius' ? 'selected' : '' ?>>St
                                    Eustatius</option>
                                <option value="St Helena"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'St Helena' ? 'selected' : '' ?>>St
                                    Helena</option>
                                <option value="St Kitts-Nevis"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'St Kitts-Nevis' ? 'selected' : '' ?>>St
                                    Kitts-Nevis</option>
                                <option value="St Lucia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'St Lucia' ? 'selected' : '' ?>>St Lucia
                                </option>
                                <option value="St Maarten"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'St Maarten' ? 'selected' : '' ?>>St
                                    Maarten</option>
                                <option value="St Pierre & Miquelon"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'St Pierre & Miquelon' ? 'selected' : '' ?>>
                                    St Pierre & Miquelon</option>
                                <option value="St Vincent & Grenadines"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'St Vincent & Grenadines' ? 'selected' : '' ?>>
                                    St Vincent & Grenadines</option>
                                <option value="Saipan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Saipan' ? 'selected' : '' ?>>Saipan
                                </option>
                                <option value="Samoa"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Samoa' ? 'selected' : '' ?>>Samoa
                                </option>
                                <option value="Samoa American"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Samoa American' ? 'selected' : '' ?>>
                                    Samoa American</option>
                                <option value="San Marino"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'San Marino' ? 'selected' : '' ?>>San
                                    Marino</option>
                                <option value="Sao Tome & Principe"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Sao Tome & Principe' ? 'selected' : '' ?>>
                                    Sao Tome & Principe</option>
                                <option value="Saudi Arabia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Saudi Arabia' ? 'selected' : '' ?>>
                                    Saudi Arabia</option>
                                <option value="Senegal"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Senegal' ? 'selected' : '' ?>>Senegal
                                </option>
                                <option value="Seychelles"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Seychelles' ? 'selected' : '' ?>>
                                    Seychelles</option>
                                <option value="Sierra Leone"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Sierra Leone' ? 'selected' : '' ?>>
                                    Sierra Leone</option>
                                <option value="Singapore"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Singapore' ? 'selected' : '' ?>>
                                    Singapore</option>
                                <option value="Slovakia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Slovakia' ? 'selected' : '' ?>>Slovakia
                                </option>
                                <option value="Slovenia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Slovenia' ? 'selected' : '' ?>>Slovenia
                                </option>
                                <option value="Solomon Islands"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Solomon Islands' ? 'selected' : '' ?>>
                                    Solomon Islands</option>
                                <option value="Somalia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Somalia' ? 'selected' : '' ?>>Somalia
                                </option>
                                <option value="South Africa"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'South Africa' ? 'selected' : '' ?>>
                                    South Africa</option>
                                <option value="Spain"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Spain' ? 'selected' : '' ?>>Spain
                                </option>
                                <option value="Sri Lanka"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Sri Lanka' ? 'selected' : '' ?>>Sri
                                    Lanka</option>
                                <option value="Sudan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Sudan' ? 'selected' : '' ?>>Sudan
                                </option>
                                <option value="Suriname"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Suriname' ? 'selected' : '' ?>>Suriname
                                </option>
                                <option value="Swaziland"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Swaziland' ? 'selected' : '' ?>>
                                    Swaziland</option>
                                <option value="Sweden"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Sweden' ? 'selected' : '' ?>>Sweden
                                </option>
                                <option value="Switzerland"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Switzerland' ? 'selected' : '' ?>>
                                    Switzerland</option>
                                <option value="Syria"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Syria' ? 'selected' : '' ?>>Syria
                                </option>
                                <option value="Tahiti"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Tahiti' ? 'selected' : '' ?>>Tahiti
                                </option>
                                <option value="Taiwan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Taiwan' ? 'selected' : '' ?>>Taiwan
                                </option>
                                <option value="Tajikistan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Tajikistan' ? 'selected' : '' ?>>
                                    Tajikistan</option>
                                <option value="Tanzania"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Tanzania' ? 'selected' : '' ?>>Tanzania
                                </option>
                                <option value="Thailand"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Thailand' ? 'selected' : '' ?>>Thailand
                                </option>
                                <option value="Togo"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Togo' ? 'selected' : '' ?>>Togo
                                </option>
                                <option value="Tokelau"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Tokelau' ? 'selected' : '' ?>>Tokelau
                                </option>
                                <option value="Tonga"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Tonga' ? 'selected' : '' ?>>Tonga
                                </option>
                                <option value="Trinidad & Tobago"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Trinidad & Tobago' ? 'selected' : '' ?>>
                                    Trinidad & Tobago</option>
                                <option value="Tunisia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Tunisia' ? 'selected' : '' ?>>Tunisia
                                </option>
                                <option value="Turkey"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Turkey' ? 'selected' : '' ?>>Turkey
                                </option>
                                <option value="Turkmenistan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Turkmenistan' ? 'selected' : '' ?>>
                                    Turkmenistan</option>
                                <option value="Turks & Caicos Is"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Turks & Caicos Is' ? 'selected' : '' ?>>
                                    Turks & Caicos Is</option>
                                <option value="Tuvalu"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Tuvalu' ? 'selected' : '' ?>>Tuvalu
                                </option>
                                <option value="Uganda"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Uganda' ? 'selected' : '' ?>>Uganda
                                </option>
                                <option value="United Kingdom"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'United Kingdom' ? 'selected' : '' ?>>
                                    United Kingdom</option>
                                <option value="Ukraine"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Ukraine' ? 'selected' : '' ?>>Ukraine
                                </option>
                                <option value="United Arab Erimates"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'United Arab Erimates' ? 'selected' : '' ?>>
                                    United Arab Emirates</option>
                                <option value="United States of America"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'United States of America' ? 'selected' : '' ?>>
                                    United States of America</option>
                                <option value="Uraguay"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Uraguay' ? 'selected' : '' ?>>Uruguay
                                </option>
                                <option value="Uzbekistan"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Uzbekistan' ? 'selected' : '' ?>>
                                    Uzbekistan</option>
                                <option value="Vanuatu"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Vanuatu' ? 'selected' : '' ?>>Vanuatu
                                </option>
                                <option value="Vatican City State"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Vatican City State' ? 'selected' : '' ?>>
                                    Vatican City State</option>
                                <option value="Venezuela"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Venezuela' ? 'selected' : '' ?>>
                                    Venezuela</option>
                                <option value="Vietnam"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Vietnam' ? 'selected' : '' ?>>Vietnam
                                </option>
                                <option value="Virgin Islands (Brit)"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Virgin Islands (Brit)' ? 'selected' : '' ?>>
                                    Virgin Islands (Brit)</option>
                                <option value="Virgin Islands (USA)"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Virgin Islands (USA)' ? 'selected' : '' ?>>
                                    Virgin Islands (USA)</option>
                                <option value="Wake Island"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Wake Island' ? 'selected' : '' ?>>Wake
                                    Island</option>
                                <option value="Wallis & Futana Is"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Wallis & Futana Is' ? 'selected' : '' ?>>
                                    Wallis & Futana Is</option>
                                <option value="Yemen"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Yemen' ? 'selected' : '' ?>>Yemen
                                </option>
                                <option value="Zaire"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Zaire' ? 'selected' : '' ?>>Zaire
                                </option>
                                <option value="Zambia"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Zambia' ? 'selected' : '' ?>>Zambia
                                </option>
                                <option value="Zimbabwe"
                                    <?= ($edit_beneficiary['country'] ?? '') == 'Zimbabwe' ? 'selected' : '' ?>>Zimbabwe
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Type <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-piggy-bank"></i>
                            </span>
                            <select class="form-control" name="account_type" required>
                                <option value="">Select Account Type</option>
                                <option value="Savings"
                                    <?= ($edit_beneficiary['account_type'] ?? '') == 'Savings' ? 'selected' : '' ?>>
                                    Savings Account</option>
                                <option value="Current"
                                    <?= ($edit_beneficiary['account_type'] ?? '') == 'Current' ? 'selected' : '' ?>>
                                    Current Account</option>
                                <option value="Checking"
                                    <?= ($edit_beneficiary['account_type'] ?? '') == 'Checking' ? 'selected' : '' ?>>
                                    Checking Account</option>
                                <option value="Fixed Deposit"
                                    <?= ($edit_beneficiary['account_type'] ?? '') == 'Fixed Deposit' ? 'selected' : '' ?>>
                                    Fixed Deposit</option>
                                <option value="Non Resident"
                                    <?= ($edit_beneficiary['account_type'] ?? '') == 'Non Resident' ? 'selected' : '' ?>>
                                    Non Resident Account</option>
                                <option value="Online Banking"
                                    <?= ($edit_beneficiary['account_type'] ?? '') == 'Online Banking' ? 'selected' : '' ?>>
                                    Online Banking Account</option>
                                <option value="Domicilary Account"
                                    <?= ($edit_beneficiary['account_type'] ?? '') == 'Domicilary Account' ? 'selected' : '' ?>>
                                    Domicilary Account</option>
                                <option value="Joint Account"
                                    <?= ($edit_beneficiary['account_type'] ?? '') == 'Joint Account' ? 'selected' : '' ?>>
                                    Joint Account</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nickname (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-tag"></i>
                            </span>
                            <input type="text" class="form-control" name="nickname"
                                value="<?= $edit_beneficiary['nickname'] ?? '' ?>"
                                placeholder="e.g., John's Main Account">
                        </div>
                    </div>

                    <div class="form-actions mt-4">
                        <?php if (isset($_GET['edit'])): ?>
                            <button type="submit" name="update_beneficiary" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Update Beneficiary
                            </button>
                            <a href="beneficiaries.php" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        <?php else: ?>
                            <button type="submit" name="add_beneficiary" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Add Beneficiary
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Beneficiaries List -->
    <div class="col-xl-8 col-lg-7" id="all">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">Saved Beneficiaries</h5>
                <span class="badge bg-primary"><?= count($beneficiaries) ?> saved</span>
            </div>
            <div class="card-body">
                <?php if (empty($beneficiaries)): ?>
                    <div class="text-center py-5">
                        <div class="empty-state-icon mb-3">
                            <i class="fas fa-address-book fa-3x text-muted"></i>
                        </div>
                        <h5 class="text-muted">No beneficiaries saved</h5>
                        <p class="text-muted">Add your first beneficiary to get started</p>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($beneficiaries as $beneficiary): ?>
                            <div class="col-md-6">
                                <div class="beneficiary-card card border h-100">
                                    <div class="card-body shadow-sm bg-light bg-opacity-50">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h6 class="mb-1"><?= htmlspecialchars($beneficiary['account_name']) ?></h6>
                                                <?php if ($beneficiary['nickname']): ?>
                                                    <small
                                                        class="text-muted"><?= htmlspecialchars($beneficiary['nickname']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="dropdown dropstart ben-dropdown">
                                                <button class="btn btn-sm btn-outline-secondary bg-primary  benDropdownTrigger"
                                                    aria-expanded="false" type="button">
                                                    <i class="fas fa-ellipsis-v text-white"></i>

                                                </button>

                                                <ul class="dropdown-menu benDropdownMenu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="domestic-transfer.php?beneficiary=<?= $beneficiary['id'] ?>">
                                                            <i class="fas fa-paper-plane me-2"></i>Local Transfer
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="wire-transfer.php?beneficiary=<?= $beneficiary['id'] ?>">
                                                            <i class="fas fa-coins me-2"></i>Wire Transfer
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item" href="?edit=<?= $beneficiary['id'] ?>">
                                                            <i class="fas fa-edit me-2"></i>Edit
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>

                                                    <li>
                                                        <form method="POST">
                                                            <input type="hidden" name="id" value="<?= $beneficiary['id'] ?>">
                                                            <button type="submit" name="delete_beneficiary"
                                                                class="dropdown-item text-danger"
                                                                onclick="return confirm('Are you sure you want to delete this beneficiary?')">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>


                                        </div>

                                        <div class="beneficiary-details">
                                            <div class="detail-item">
                                                <small class="text-muted">Account Number:</small>
                                                <strong><?= htmlspecialchars($beneficiary['account_number']) ?></strong>
                                            </div>
                                            <div class="detail-item">
                                                <small class="text-muted">Bank:</small>
                                                <span><?= htmlspecialchars($beneficiary['bank_name']) ?></span>
                                            </div>
                                            <div class="detail-item">
                                                <small class="text-muted">Country:</small>
                                                <span><?= htmlspecialchars($beneficiary['country']) ?></span>
                                            </div>
                                            <div class="detail-item">
                                                <small class="text-muted">Type:</small>
                                                <span
                                                    class="badge bg-light text-dark"><?= htmlspecialchars($beneficiary['account_type']) ?></span>
                                            </div>
                                        </div>
                                    </div>
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
    .text-primary {
        color: var(--primary) !important;
    }

    .btn-outline-secondary.dropdown-toggle.show {
        color: #fff;
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
    }

    .btn-primary,
    .bg-primary {
        background-color: var(--primary) !important;
        border-color: var(--primary) !important;
    }

    .beneficiary-card {
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .beneficiary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.25rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .empty-state-icon {
        opacity: 0.5;
    }

    .dropdown-toggle::after {
        display: none;
    }

    .beneficiary-details {
        font-size: 0.875rem;
    }

    input[list] {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 40px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .beneficiary-card {
            margin-bottom: 1rem;
        }

        .detail-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
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

        // Auto-fill form if beneficiary ID is passed in URL
        const urlParams = new URLSearchParams(window.location.search);
        const beneficiaryId = urlParams.get('beneficiary');

        if (beneficiaryId) {
            // Redirect to domestic transfer with beneficiary pre-selected
            window.location.href = 'domestic-transfer.php?beneficiary=' + beneficiaryId;
        }

    });
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