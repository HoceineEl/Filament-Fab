<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default FAB Position
    |--------------------------------------------------------------------------
    |
    | The default position for the Floating Action Button.
    | Options: 'bottom-right', 'bottom-left', 'top-right', 'top-left'
    |
    */
    'default_position' => 'bottom-right',

    /*
    |--------------------------------------------------------------------------
    | Remember Position
    |--------------------------------------------------------------------------
    |
    | Whether to remember the position of the FAB between sessions.
    | If false, the default position will be used on each page reload.
    |
    */
    'remember_position' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable in Production
    |--------------------------------------------------------------------------
    |
    | Whether to enable the FAB in production environment.
    | Set to false to disable it in production.
    |
    */
    'enable_in_production' => true,

    /*
    |--------------------------------------------------------------------------
    | Show Tooltip
    |--------------------------------------------------------------------------
    |
    | Whether to show the tooltip on the main FAB button.
    |
    */
    'show_tooltip' => true,

    /*
    |--------------------------------------------------------------------------
    | Theme Settings
    |--------------------------------------------------------------------------
    |
    | Customize the appearance of the Floating Action Button.
    | These settings can be overridden in the tailwind.config.js file
    | by setting the appropriate primary color values.
    |
    */
    'theme' => [
        'button_size' => '60px',         // Size of the main button
        'menu_item_size' => '40px',      // Size of each menu item button
        'menu_width' => '320px',         // Width of the expanded menu
        'menu_spacing' => '16px',        // Spacing between menu items
        'animation_speed' => '0.3s',     // Speed of animations
        'animation_easing' => 'cubic-bezier(0.4, 0, 0.2, 1)', // Animation easing

        // Color settings
        'colors' => [
            'button_bg' => '#3b82f6',           // Main button background color
            'button_bg_hover' => '#2563eb',     // Main button hover background color
            'button_bg_active' => '#1d4ed8',    // Main button active background color
            'button_text' => '#ffffff',         // Main button text/icon color
            'menu_bg' => '#ffffff',             // Menu background color
            'menu_bg_dark' => '#1f2937',        // Menu background color in dark mode
            'menu_text' => '#4b5563',           // Menu text color
            'menu_text_dark' => '#e5e7eb',      // Menu text color in dark mode
            'menu_hover' => '#f3f4f6',          // Menu item hover background
            'menu_hover_dark' => '#374151',     // Menu item hover background in dark mode
            'menu_item_accent' => '#3b82f6',    // Menu item accent color on hover
            'menu_item_accent_dark' => '#60a5fa', // Menu item accent color on hover in dark mode
            'tooltip_bg' => '#111827',          // Tooltip background color
            'tooltip_bg_dark' => '#374151',     // Tooltip background color in dark mode
            'tooltip_text' => '#ffffff',        // Tooltip text color
        ],
    ],
];
