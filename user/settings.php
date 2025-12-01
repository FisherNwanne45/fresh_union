<?php
// settings.php - complete settings page with DB update and reset-to-default
require_once __DIR__ . '/../config.php';
session_start();

if (!isset($_SESSION['acct_no'])) {
    header("Location: ../login.php");
    exit;
}

$current_page = 'settings';
$page_title = 'Settings';

// fetch current settings
try {
    $stmt = $conn->prepare("SELECT * FROM settings WHERE id = 1 LIMIT 1");
    $stmt->execute();
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $settings = false;
}

// defaults
$defaults = [
    'theme_version' => 'light',
    'primary_color' => 'color_1',
    'navigation_header' => 'color_1',
    'header_bg' => 'color_1',
    'sidebar_bg' => 'color_1',
    'sidebar_text' => 'color_1',
    'sidebar_img_bg' => null,
    'theme_layout' => 'vertical',
    'header_position' => 'static',
    'sidebar_style' => 'full',
    'sidebar_position' => 'static',
    'container_layout' => 'wide',
    'typography' => 'roboto'
];

if (!$settings) {
    $settings = $defaults;
}

// whitelists
$allowed_colors = array_map(fn($n) => "color_$n", range(1, 15));
$allowed_versions = ['light', 'dark'];
$allowed_layouts = ['vertical', 'horizontal'];
$allowed_header_positions = ['static', 'fixed'];
$allowed_sidebar_styles = ['full', 'mini', 'compact', 'overlay', 'icon-hover'];
$allowed_sidebar_positions = ['static', 'fixed'];
$allowed_containers = ['wide', 'boxed', 'wide-boxed', 'full'];
$allowed_typography = ['roboto', 'poppins', 'opensans', 'HelveticaNeue'];

// Handle reset-to-default request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_default'])) {
    try {
        $sql = "UPDATE settings SET
            theme_version = :theme_version,
            primary_color = :primary_color,
            navigation_header = :navigation_header,
            header_bg = :header_bg,
            sidebar_bg = :sidebar_bg,
            sidebar_text = :sidebar_text,
            sidebar_img_bg = :sidebar_img_bg,
            theme_layout = :theme_layout,
            header_position = :header_position,
            sidebar_style = :sidebar_style,
            sidebar_position = :sidebar_position,
            container_layout = :container_layout,
            typography = :typography
            WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':theme_version' => $defaults['theme_version'],
            ':primary_color' => $defaults['primary_color'],
            ':navigation_header' => $defaults['navigation_header'],
            ':header_bg' => $defaults['header_bg'],
            ':sidebar_bg' => $defaults['sidebar_bg'],
            ':sidebar_text' => $defaults['sidebar_text'],
            ':sidebar_img_bg' => $defaults['sidebar_img_bg'],
            ':theme_layout' => $defaults['theme_layout'],
            ':header_position' => $defaults['header_position'],
            ':sidebar_style' => $defaults['sidebar_style'],
            ':sidebar_position' => $defaults['sidebar_position'],
            ':container_layout' => $defaults['container_layout'],
            ':typography' => $defaults['typography']
        ]);
        $_SESSION['theme_updated'] = true;
        header("Location: settings.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['theme_error'] = true;
        header("Location: settings.php");
        exit;
    }
}

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_theme_settings'])) {
    // validate and sanitize inputs
    $input = [];
    $input['theme_version'] = in_array($_POST['theme_version'] ?? '', $allowed_versions) ? $_POST['theme_version'] : $defaults['theme_version'];
    $input['primary_color'] = in_array($_POST['primary_bg'] ?? '', $allowed_colors) ? $_POST['primary_bg'] : $defaults['primary_color'];
    $input['navigation_header'] = in_array($_POST['navigation_header'] ?? '', $allowed_colors) ? $_POST['navigation_header'] : $defaults['navigation_header'];
    $input['header_bg'] = in_array($_POST['header_bg'] ?? '', $allowed_colors) ? $_POST['header_bg'] : $defaults['header_bg'];
    $input['sidebar_bg'] = in_array($_POST['sidebar_bg'] ?? '', $allowed_colors) ? $_POST['sidebar_bg'] : $defaults['sidebar_bg'];
    $input['sidebar_text'] = in_array($_POST['sidebar_text'] ?? '', $allowed_colors) ? $_POST['sidebar_text'] : $defaults['sidebar_text'];

    // sidebar image: accept only from our known folder, or empty
    $sidebar_img = $_POST['sidebar_img_bg'] ?? null;
    if ($sidebar_img && str_starts_with($sidebar_img, '/static/mophy/images/sidebar-img/')) {
        $input['sidebar_img_bg'] = $sidebar_img;
    } else {
        $input['sidebar_img_bg'] = null;
    }

    $input['theme_layout'] = in_array($_POST['theme_layout'] ?? '', $allowed_layouts) ? $_POST['theme_layout'] : $defaults['theme_layout'];
    $input['header_position'] = in_array($_POST['header_position'] ?? '', $allowed_header_positions) ? $_POST['header_position'] : $defaults['header_position'];
    $input['sidebar_style'] = in_array($_POST['sidebar_style'] ?? '', $allowed_sidebar_styles) ? $_POST['sidebar_style'] : $defaults['sidebar_style'];
    $input['sidebar_position'] = in_array($_POST['sidebar_position'] ?? '', $allowed_sidebar_positions) ? $_POST['sidebar_position'] : $defaults['sidebar_position'];
    $input['container_layout'] = in_array($_POST['container_layout'] ?? '', $allowed_containers) ? $_POST['container_layout'] : $defaults['container_layout'];
    $input['typography'] = in_array($_POST['typography'] ?? '', $allowed_typography) ? $_POST['typography'] : $defaults['typography'];

    // Update DB
    try {
        $sql = "UPDATE settings SET
            theme_version = :theme_version,
            primary_color = :primary_color,
            navigation_header = :navigation_header,
            header_bg = :header_bg,
            sidebar_bg = :sidebar_bg,
            sidebar_text = :sidebar_text,
            sidebar_img_bg = :sidebar_img_bg,
            theme_layout = :theme_layout,
            header_position = :header_position,
            sidebar_style = :sidebar_style,
            sidebar_position = :sidebar_position,
            container_layout = :container_layout,
            typography = :typography
            WHERE id = 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':theme_version' => $input['theme_version'],
            ':primary_color' => $input['primary_color'],
            ':navigation_header' => $input['navigation_header'],
            ':header_bg' => $input['header_bg'],
            ':sidebar_bg' => $input['sidebar_bg'],
            ':sidebar_text' => $input['sidebar_text'],
            ':sidebar_img_bg' => $input['sidebar_img_bg'],
            ':theme_layout' => $input['theme_layout'],
            ':header_position' => $input['header_position'],
            ':sidebar_style' => $input['sidebar_style'],
            ':sidebar_position' => $input['sidebar_position'],
            ':container_layout' => $input['container_layout'],
            ':typography' => $input['typography']
        ]);
        $_SESSION['theme_updated'] = true;
        header("Location: settings.php");
        exit;
    } catch (Exception $e) {
        error_log("Theme update error: " . $e->getMessage());
        $_SESSION['theme_error'] = true;
        header("Location: settings.php");
        exit;
    }
}

// include header (this prints header HTML and opens <body> and main-wrapper)
include 'layout/header.php';

// color map for swatches
$colorMap = [
    'color_1' => '#ebe1e1ff',
    'color_2' => '#143b64',
    'color_3' => '#1EAAE7',
    'color_4' => '#4527a0',
    'color_5' => '#c62828',
    'color_6' => '#283593',
    'color_7' => '#7356f1',
    'color_8' => '#3695eb',
    'color_9' => '#00838f',
    'color_10' => '#ff8f16',
    'color_11' => '#6673fd',
    'color_12' => '#558b2f',
    'color_13' => '#2a2a2a',
    'color_14' => '#1367c8',
    'color_15' => '#ed0b4c'
];


?>

<div class="form-head mb-4">
    <h2 class="text-black font-w600 mb-0">Settings</h2>
</div>

<?php if (!empty($_SESSION['theme_updated'])): ?>
    <div class="alert alert-success solid alert-dismissible fade show">
        <strong>Success!</strong> Theme settings updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php unset($_SESSION['theme_updated']);
endif; ?>

<?php if (!empty($_SESSION['theme_error'])): ?>
    <div class="alert alert-danger solid alert-dismissible fade show">
        <strong>Error!</strong> Failed to update theme settings.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php unset($_SESSION['theme_error']);
endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Theme Settings</h4>
            </div>
            <div class="card-body">
                <form method="POST" id="themeSettingsForm">
                    <input type="hidden" name="update_theme_settings" value="1">

                    <div class="sidebar-right-inner">
                        <!--<h4>Pick your style
                            <button type="button" onclick="submitReset()" class="btn btn-primary btn-sm float-end">Reset
                                to Default</button>
                        </h4>-->

                        <div class="card-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" href="#tab1"
                                        data-bs-toggle="tab">Theme</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab2" data-bs-toggle="tab">Header</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#tab3" data-bs-toggle="tab">Content</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#tab4"
                                        data-bs-toggle="tab">Navigation</a></li>
                            </ul>
                        </div>

                        <div class="tab-content tab-content-default tabcontent-border">
                            <!-- Theme Tab -->
                            <div class="fade tab-pane active show" id="tab1">
                                <div class="admin-settings">
                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">Background</label>
                                            <select class="form-control" id="theme_version" name="theme_version">
                                                <option value="light"
                                                    <?= ($settings['theme_version'] ?? 'light') === 'light' ? 'selected' : '' ?>>
                                                    Light</option>
                                                <option value="dark"
                                                    <?= ($settings['theme_version'] ?? 'light') === 'dark' ? 'selected' : '' ?>>
                                                    Dark</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Primary Color</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php for ($i = 1; $i <= 15; $i++): ?>
                                                    <?php $key = "color_$i"; ?>
                                                    <label style="display:inline-block; text-align:center;">
                                                        <input type="radio" id="primary_color_<?= $i ?>" name="primary_bg"
                                                            value="<?= $key ?>"
                                                            <?= ($settings['primary_color'] ?? 'color_1') === $key ? 'checked' : '' ?>
                                                            style="display:none;">
                                                        <span class="d-inline-block"
                                                            style="width:30px;height:30px;border-radius:4px;background:<?= $colorMap[$key] ?? '#eee' ?>;cursor:pointer;border:2px solid transparent;display:inline-block;"></span>
                                                    </label>
                                                <?php endfor; ?>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Navigation Header</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php for ($i = 1; $i <= 15; $i++): $key = "color_$i"; ?>
                                                    <label style="display:inline-block;">
                                                        <input type="radio" id="nav_header_color_<?= $i ?>"
                                                            name="navigation_header" value="<?= $key ?>"
                                                            <?= ($settings['navigation_header'] ?? 'color_1') === $key ? 'checked' : '' ?>
                                                            style="display:none;">
                                                        <span class="d-inline-block"
                                                            style="width:30px;height:30px;border-radius:4px;background:<?= $colorMap[$key] ?? '#eee' ?>;cursor:pointer;border:2px solid transparent;"></span>
                                                    </label>
                                                <?php endfor; ?>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Header Background</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php for ($i = 1; $i <= 15; $i++): $key = "color_$i"; ?>
                                                    <label style="display:inline-block;">
                                                        <input type="radio" id="header_color_<?= $i ?>" name="header_bg"
                                                            value="<?= $key ?>"
                                                            <?= ($settings['header_bg'] ?? 'color_1') === $key ? 'checked' : '' ?>
                                                            style="display:none;">
                                                        <span class="d-inline-block"
                                                            style="width:30px;height:30px;border-radius:4px;background:<?= $colorMap[$key] ?? '#eee' ?>;cursor:pointer;border:2px solid transparent;"></span>
                                                    </label>
                                                <?php endfor; ?>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Sidebar Background</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php for ($i = 1; $i <= 15; $i++): $key = "color_$i"; ?>
                                                    <label style="display:inline-block;">
                                                        <input type="radio" id="sidebar_color_<?= $i ?>" name="sidebar_bg"
                                                            value="<?= $key ?>"
                                                            <?= ($settings['sidebar_bg'] ?? 'color_1') === $key ? 'checked' : '' ?>
                                                            style="display:none;">
                                                        <span class="d-inline-block"
                                                            style="width:30px;height:30px;border-radius:4px;background:<?= $colorMap[$key] ?? '#eee' ?>;cursor:pointer;border:2px solid transparent;"></span>
                                                    </label>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Header Tab -->
                            <div class="fade tab-pane" id="tab2">
                                <div class="admin-settings">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Layout</label>
                                            <select class="form-control" id="theme_layout" name="theme_layout">
                                                <option value="vertical"
                                                    <?= ($settings['theme_layout'] ?? 'vertical') === 'vertical' ? 'selected' : '' ?>>
                                                    Vertical</option>
                                                <option value="horizontal"
                                                    <?= ($settings['theme_layout'] ?? 'vertical') === 'horizontal' ? 'selected' : '' ?>>
                                                    Horizontal</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Header Position</label>
                                            <select class="form-control" id="header_position" name="header_position">
                                                <option value="static"
                                                    <?= ($settings['header_position'] ?? 'static') === 'static' ? 'selected' : '' ?>>
                                                    Static</option>
                                                <option value="fixed"
                                                    <?= ($settings['header_position'] ?? 'static') === 'fixed' ? 'selected' : '' ?>>
                                                    Fixed</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Sidebar Style</label>
                                            <select class="form-control" id="sidebar_style" name="sidebar_style">
                                                <option value="full"
                                                    <?= ($settings['sidebar_style'] ?? 'full') === 'full' ? 'selected' : '' ?>>
                                                    Full</option>
                                                <option value="mini"
                                                    <?= ($settings['sidebar_style'] ?? 'full') === 'mini' ? 'selected' : '' ?>>
                                                    Mini</option>
                                                <option value="compact"
                                                    <?= ($settings['sidebar_style'] ?? 'full') === 'compact' ? 'selected' : '' ?>>
                                                    Compact</option>
                                                <option value="overlay"
                                                    <?= ($settings['sidebar_style'] ?? 'full') === 'overlay' ? 'selected' : '' ?>>
                                                    Overlay</option>
                                                <option value="icon-hover"
                                                    <?= ($settings['sidebar_style'] ?? 'full') === 'icon-hover' ? 'selected' : '' ?>>
                                                    Icon-hover</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Sidebar Position</label>
                                            <select class="form-control" id="sidebar_position" name="sidebar_position">
                                                <option value="static"
                                                    <?= ($settings['sidebar_position'] ?? 'static') === 'static' ? 'selected' : '' ?>>
                                                    Static</option>
                                                <option value="fixed"
                                                    <?= ($settings['sidebar_position'] ?? 'static') === 'fixed' ? 'selected' : '' ?>>
                                                    Fixed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Tab -->
                            <div class="fade tab-pane" id="tab3">
                                <div class="admin-settings">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Container Layout</label>
                                            <select class="form-control" id="container_layout" name="container_layout">
                                                <option value="wide"
                                                    <?= ($settings['container_layout'] ?? 'wide') === 'wide' ? 'selected' : '' ?>>
                                                    Wide</option>
                                                <option value="boxed"
                                                    <?= ($settings['container_layout'] ?? 'wide') === 'boxed' ? 'selected' : '' ?>>
                                                    Boxed</option>
                                                <option value="wide-boxed"
                                                    <?= ($settings['container_layout'] ?? 'wide') === 'wide-boxed' ? 'selected' : '' ?>>
                                                    Wide Boxed</option>
                                                <option value="full"
                                                    <?= ($settings['container_layout'] ?? 'wide') === 'full' ? 'selected' : '' ?>>
                                                    Full</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label">Typography</label>
                                            <select class="form-control" id="typography" name="typography">
                                                <option value="roboto"
                                                    <?= ($settings['typography'] ?? 'roboto') === 'roboto' ? 'selected' : '' ?>>
                                                    Roboto</option>
                                                <option value="poppins"
                                                    <?= ($settings['typography'] ?? 'roboto') === 'poppins' ? 'selected' : '' ?>>
                                                    Poppins</option>
                                                <option value="opensans"
                                                    <?= ($settings['typography'] ?? 'roboto') === 'opensans' ? 'selected' : '' ?>>
                                                    Open Sans</option>
                                                <option value="HelveticaNeue"
                                                    <?= ($settings['typography'] ?? 'roboto') === 'HelveticaNeue' ? 'selected' : '' ?>>
                                                    HelveticaNeue</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Tab -->
                            <div class="fade tab-pane" id="tab4">
                                <div class="admin-settings">
                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">Sidebar Text Color</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php for ($i = 1; $i <= 14; $i++): $key = "color_$i"; ?>
                                                    <label style="display:inline-block;">
                                                        <input type="radio" id="sidebar_text_color_<?= $i ?>"
                                                            name="sidebar_text" value="<?= $key ?>"
                                                            <?= ($settings['sidebar_text'] ?? 'color_1') === $key ? 'checked' : '' ?>
                                                            style="display:none;">
                                                        <span class="d-inline-block"
                                                            style="width:30px;height:30px;border-radius:4px;background:<?= $colorMap[$key] ?? '#eee' ?>;cursor:pointer;border:2px solid transparent;"></span>
                                                    </label>
                                                <?php endfor; ?>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">Sidebar Background Image</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php for ($i = 1; $i <= 10; $i++): $img = "/static/mophy/images/sidebar-img/{$i}.jpg"; ?>
                                                    <label style="display:inline-block;">
                                                        <input type="radio" id="sidebar_img_<?= $i ?>" name="sidebar_img_bg"
                                                            value="<?= $img ?>"
                                                            <?= ($settings['sidebar_img_bg'] ?? '') === $img ? 'checked' : '' ?>
                                                            style="display:none;">
                                                        <span class="d-inline-block"
                                                            style="width:60px;height:60px;border-radius:4px;background-image:url('<?= $img ?>');background-size:cover;background-position:center;cursor:pointer;border:2px solid transparent;"></span>
                                                    </label>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save me-2"></i>Save
                                Theme Settings</button>
                        </div>
                    </div>
                </form>

                <!-- Reset form (hidden) --
                <form method="POST" id="resetForm" style="display:none;">
                    <input type="hidden" name="reset_default" value="1">
                </form>-->

            </div>
        </div>
    </div>
</div>

<style>
    /* small inline styles for the swatches */
    .d-inline-block[style*="background"] {
        transition: transform .08s ease, border-color .08s ease;
    }

    .d-inline-block[style*="background"]:hover {
        transform: scale(1.05);
        border-color: #333;
    }
</style>

<script>
    function submitReset() {
        if (confirm('Reset all theme settings to default?')) {
            document.getElementById('resetForm').submit();
        }
    }
</script>

<?php include 'layout/footer.php'; ?>