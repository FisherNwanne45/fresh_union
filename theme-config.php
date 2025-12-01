<?php
// theme-config.php - Include this in your config.php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize theme session if not set
if (!isset($_SESSION['theme_settings'])) {
    $_SESSION['theme_settings'] = [
        'theme_version' => 'light',
        'primary_color' => 'color_1',
        'navigation_header' => 'color_1',
        'header_bg' => 'color_1',
        'sidebar_bg' => 'color_1',
        'sidebar_text' => 'color_1',
        'sidebar_img_bg' => null,
        'theme_layout' => 'vertical',
        'header_position' => 'fixed',
        'sidebar_style' => 'full',
        'sidebar_position' => 'fixed',
        'container_layout' => 'wide',
        'typography' => 'roboto'
    ];
}

// Make theme settings available globally
$theme_settings = $_SESSION['theme_settings'];

// Color definitions (same as above)
$theme_colors = [
    'primary' => [
        'color_1' => ['--primary-color' => '#4361ee', '--secondary-color' => '#3f37c9'],
        'color_2' => ['--primary-color' => '#6c757d', '--secondary-color' => '#5a6268'],
        'color_3' => ['--primary-color' => '#28a745', '--secondary-color' => '#218838'],
        'color_4' => ['--primary-color' => '#dc3545', '--secondary-color' => '#c82333'],
        'color_5' => ['--primary-color' => '#ffc107', '--secondary-color' => '#e0a800'],
        'color_6' => ['--primary-color' => '#17a2b8', '--secondary-color' => '#138496'],
        'color_7' => ['--primary-color' => '#6f42c1', '--secondary-color' => '#5a2d9c'],
        'color_8' => ['--primary-color' => '#e83e8c', '--secondary-color' => '#d91a72'],
        'color_9' => ['--primary-color' => '#fd7e14', '--secondary-color' => '#e55b00'],
        'color_10' => ['--primary-color' => '#20c997', '--secondary-color' => '#199d76'],
        'color_11' => ['--primary-color' => '#6610f2', '--secondary-color' => '#520dc2'],
        'color_12' => ['--primary-color' => '#0dcaf0', '--secondary-color' => '#0bb5d4'],
        'color_13' => ['--primary-color' => '#198754', '--secondary-color' => '#146c43'],
        'color_14' => ['--primary-color' => '#052c65', '--secondary-color' => '#031633'],
        'color_15' => ['--primary-color' => '#000000', '--secondary-color' => '#333333']
    ],
    'header' => [
        'color_1' => '#ffffff',
        'color_2' => '#f8f9fa',
        'color_3' => '#e9ecef',
        'color_4' => '#dee2e6',
        'color_5' => '#ced4da',
        'color_6' => '#adb5bd',
        'color_7' => '#6c757d',
        'color_8' => '#495057',
        'color_9' => '#343a40',
        'color_10' => '#212529',
        'color_11' => '#4361ee',
        'color_12' => '#3a0ca3',
        'color_13' => '#7209b7',
        'color_14' => '#f72585',
        'color_15' => '#480ca8'
    ],
    'sidebar' => [
        'color_1' => '#ffffff',
        'color_2' => '#f8f9fa',
        'color_3' => '#e9ecef',
        'color_4' => '#dee2e6',
        'color_5' => '#ced4da',
        'color_6' => '#adb5bd',
        'color_7' => '#6c757d',
        'color_8' => '#495057',
        'color_9' => '#343a40',
        'color_10' => '#212529',
        'color_11' => '#2d3748',
        'color_12' => '#4a5568',
        'color_13' => '#718096',
        'color_14' => '#1a202c',
        'color_15' => '#0d1117'
    ]
];
?>

<!-- Dynamic CSS Variables -->
<style>
:root {
    /* Primary Colors */
    --primary-color: <?=$theme_colors['primary'][$theme_settings['primary_color']]['--primary-color'] ?>;
    --secondary-color: <?=$theme_colors['primary'][$theme_settings['primary_color']]['--secondary-color'] ?>;

    /* Header Colors */
    --header-bg: <?=$theme_colors['header'][$theme_settings['header_bg']] ?>;
    --navigation-header: <?=$theme_colors['header'][$theme_settings['navigation_header']] ?>;

    /* Sidebar Colors */
    --sidebar-bg: <?=$theme_colors['sidebar'][$theme_settings['sidebar_bg']] ?>;

    /* Theme Variables */
    --theme-version: <?=$theme_settings['theme_version'] ?>;
    --theme-layout: <?=$theme_settings['theme_layout'] ?>;
}

/* Theme-specific styles */
.theme-primary {
    background-color: var(--primary-color) !important;
}

.theme-secondary {
    background-color: var(--secondary-color) !important;
}

.text-theme-primary {
    color: var(--primary-color) !important;
}

.border-theme-primary {
    border-color: var(--primary-color) !important;
}

/* Card headers with theme colors */
.card-header.bg-theme {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
    color: white;
}

/* Buttons with theme colors */
.btn-theme {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border: none;
    color: white;
}

.btn-theme:hover {
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
}
</style>