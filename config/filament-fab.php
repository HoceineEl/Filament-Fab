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
    ],
];
