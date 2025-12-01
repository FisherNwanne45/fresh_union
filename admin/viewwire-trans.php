<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Edit Wire Transactions";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


$id = $_GET['id'];
$sql = "SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE refrence_id =:id";
$data = $conn->prepare($sql);
$data->execute([
    'id' => $id
]);

$result = $data->fetch(PDO::FETCH_ASSOC);
$transStatus = TranStatus($result);
$id1 = $result['id'];

$amount = $result['amount'];


if (isset($_POST['accept'])) {

    $status_value = "completed";
    $sql = "UPDATE transactions SET trans_status=:wire_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'wire_status' => $status_value,
        'id' => $id
    ]);

    $full_name = $result['firstname'] . " " . $result['lastname'];
    $user_balance = $result['acct_balance'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $result['acct_email'];
    $acct_currency = $result['acct_currency'];
    $trans_status = "completed";
    $trans_type = "Wire Transfer";
    $message = $sendMail->AdminWireMsg($full_name, $amount, $user_balance, $trans_status, $trans_type, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS);

    // User Email
    $subject = "Wire Transfer" . "-" . $APP_NAME;
    $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./wire-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Transaction updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        //   toast_alert('error', 'Sorry Something Went Wrong');
    }
}

if (isset($_POST['decline'])) {
    $status_value = "failed";
    $trans_id = $result['trans_id'];
    $sql = "UPDATE transactions SET trans_status=:wire_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'wire_status' => $status_value,
        'id' => $id
    ]);
    $amount = $result['amount'];
    $amount_balance = $result['acct_balance'] + $result['amount'];

    $sql = "UPDATE users SET acct_balance=:acct_balance WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_balance' => $amount_balance,
        'id' => $id1
    ]);

    $full_name = $result['firstname'] . " " . $result['lastname'];
    $user_balance = $result['acct_balance'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $result['acct_email'];
    $acct_currency = $result['acct_currency'];
    $trans_status = "failed";
    $trans_type = "Wire Transfer";
    $message = $sendMail->AdminWireMsg($full_name, $amount, $user_balance, $trans_status, $trans_type, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "Wire Transfer" . "-" . $APP_NAME;
    $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./wire-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Transaction updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        //   toast_alert('error', 'Sorry Something Went Wrong');
    }
}

if (isset($_POST['hold'])) {
    $status_value = "processing";
    $trans_id = $result['trans_id'];
    $sql = "UPDATE transactions SET trans_status=:wire_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'wire_status' => $status_value,
        'id' => $id
    ]);

    $full_name = $result['firstname'] . " " . $result['lastname'];
    $user_balance = $result['acct_balance'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $result['acct_email'];
    $acct_currency = $result['acct_currency'];
    $trans_status = "processing";
    $trans_type = "Wire Transfer";
    $message = $sendMail->AdminWireMsg($full_name, $amount, $user_balance, $trans_status, $trans_type, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "Wire Transfer" . "-" . $APP_NAME;
    $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./wire-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Transaction hold successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        //   toast_alert('error', 'Sorry Something Went Wrong');
    }
}

if (isset($_POST['update_trans'])) {
    $amount = $_POST['amount'];
    $bank_name = $_POST['bank_name'];
    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];
    $account_type = $_POST['account_type'];
    $bank_country = $_POST['bank_country'];
    $account_number = $_POST['account_number'];
    $routine_number = $_POST['routine_number'];
    $swift_code = $_POST['swift_code'];
    $created_at = $_POST['created_at'];


    $sql = "UPDATE transactions SET amount=:amount,bank_name=:bank_name,account_name=:account_name,account_number=:account_number,account_type=:account_type,bank_country=:bank_country,routine_number=:routine_number,swift_code=:swift_code,created_at=:created_at WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'amount' => $amount,
        'bank_name' => $bank_name,
        'account_name' => $account_name,
        'account_number' => $account_number,
        'account_type' => $account_type,
        'bank_country' => $bank_country,
        'routine_number' => $routine_number,
        'swift_code' => $swift_code,
        'created_at' => $created_at,
        'id' => $id
    ]);

    if (true) {

        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./wire-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Transaction updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    }


    // header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);


}



?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Wire Transactions
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <form method="POST">
                <div class="box-header with-border">
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <?php if (isset($msg1)) echo $msg1; ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" name="amount"
                                    placeholder="<?= $result['amount'] ?>" value="<?= $result['amount'] ?>" required>
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control" name="bank_name"
                                    placeholder="<?= $result['bank_name'] ?>" value="<?= $result['bank_name'] ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="12"
                                    autocomplete="off" class="form-control" name="account_number"
                                    placeholder="<?= $result['account_number'] ?>"
                                    value="<?= $result['account_number'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Routine Number</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="12"
                                    autocomplete="off" class="form-control" value="<?= $result['routine_number'] ?>"
                                    name="routine_number" placeholder="9876567656">
                            </div>

                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Name</label>
                                <input type="text" class="form-control" name="account_name"
                                    placeholder="<?= $result['account_name'] ?>" value="<?= $result['account_name'] ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Swift code</label>
                                <input type="text" inputmode="numeric" required maxlength="12" autocomplete="off"
                                    class="form-control" name="swift_code" placeholder="<?= $result['swift_code'] ?>"
                                    value="<?= $result['swift_code'] ?>" required>
                            </div>




                            <div class="form-group">
                                <label>Account Type</label>
                                <select name="account_type" required class="form-control" data-width='100%'>
                                    <option value="<?= $result['account_type'] ?>">Select Account Type</option>
                                    <option value="Savings">Savings Account</option>
                                    <option value="Current">Current Account</option>
                                    <option value="Checking">Checking Account</option>
                                    <option value="Fixed Deposit">Fixed Deposit</option>
                                    <option value="Non Resident">Non Resident Account</option>
                                    <option value="Online Banking">Online Banking</option>
                                    <option value="Domicilary Account">Domicilary Account</option>
                                    <option value="Joint Account">Joint Account</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Bank Country</label>
                                <select name="bank_country" required class="form-control" data-width='100%'>
                                    <option value="<?= $result['bank_country'] ?>">Select Country</option>
                                    <option value="Afganistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bonaire">Bonaire</option>
                                    <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Ter">British Indian Ocean Ter
                                    </option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Canary Islands">Canary Islands</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic
                                    </option>
                                    <option value="Chad">Chad</option>
                                    <option value="Channel Islands">Channel Islands</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos Island">Cocos Island</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote DIvoire">Cote DIvoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Curaco">Curacao</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="East Timor">East Timor</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands">Falkland Islands</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Ter">French Southern Ter</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Great Britain">Great Britain</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Hawaii">Hawaii</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="India">India</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea North">Korea North</option>
                                    <option value="Korea Sout">Korea South</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Laos">Laos</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macau">Macau</option>
                                    <option value="Macedonia">Macedonia</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Midway Islands">Midway Islands</option>
                                    <option value="Moldova">Moldova</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Nambia">Nambia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherland Antilles">Netherland Antilles</option>
                                    <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                    <option value="Nevis">Nevis</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau Island">Palau Island</option>
                                    <option value="Palestine">Palestine</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Phillipines">Philippines</option>
                                    <option value="Pitcairn Island">Pitcairn Island</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Republic of Montenegro">Republic of Montenegro</option>
                                    <option value="Republic of Serbia">Republic of Serbia</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="St Barthelemy">St Barthelemy</option>
                                    <option value="St Eustatius">St Eustatius</option>
                                    <option value="St Helena">St Helena</option>
                                    <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                    <option value="St Lucia">St Lucia</option>
                                    <option value="St Maarten">St Maarten</option>
                                    <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                    <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                    <option value="Saipan">Saipan</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="Samoa American">Samoa American</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria">Syria</option>
                                    <option value="Tahiti">Tahiti</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Erimates">United Arab Emirates</option>
                                    <option value="United States of America">United States of America
                                    </option>
                                    <option value="Uraguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Vatican City State">Vatican City State</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                    <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                    <option value="Wake Island">Wake Island</option>
                                    <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zaire">Zaire</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>

                                </select>
                            </div>


                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" name="created_at"
                                    placeholder="<?= $result['created_at'] ?>" value="<?= $result['created_at'] ?>"
                                    required>
                            </div>


                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="update_trans" class="btn btn-primary">Update</button>
                    <button type="submit" name="accept" class="btn btn-success">Accept</button>
                    <button type="submit" name="hold" class="btn btn-warning">Hold</button>
                    <button type="submit" name="decline" class="btn btn-danger">Decline</button>


                </div>
            </form>
        </div>
        <!-- /.box -->




    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>