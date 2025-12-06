<?php

return [

    /*
    |--------------------------------------------------------------------------
    | UI Theme
    |--------------------------------------------------------------------------
    |
    | This value determines the daisyUI theme that will be used throughout
    | the application. You can choose from any of the 35 built-in themes.
    |
    | Available themes: light, dark, cupcake, bumblebee, emerald, corporate,
    | synthwave, retro, cyberpunk, valentine, halloween, garden, forest, aqua,
    | lofi, pastel, fantasy, wireframe, black, luxury, dracula, cmyk, autumn,
    | business, acid, lemonade, night, coffee, winter, dim, nord, sunset,
    | caramellatte, abyss, silk
    |
    */

    'theme' => env('UI_THEME', 'light'),

    /*
    |--------------------------------------------------------------------------
    | Available Themes
    |--------------------------------------------------------------------------
    |
    | This array contains all available daisyUI themes. You can use this
    | for validation or to display a list of available themes.
    |
    */

    'available_themes' => [
        'light',
        'dark',
        'cupcake',
        'bumblebee',
        'emerald',
        'corporate',
        'synthwave',
        'retro',
        'cyberpunk',
        'valentine',
        'halloween',
        'garden',
        'forest',
        'aqua',
        'lofi',
        'pastel',
        'fantasy',
        'wireframe',
        'black',
        'luxury',
        'dracula',
        'cmyk',
        'autumn',
        'business',
        'acid',
        'lemonade',
        'night',
        'coffee',
        'winter',
        'dim',
        'nord',
        'sunset',
        'caramellatte',
        'abyss',
        'silk',
    ],

];
