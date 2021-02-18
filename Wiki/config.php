<?php
/**
 * Add 3rd party dependancies here. Usefull for when you have either compiled css and javascript or using individual files specific to the documentation
 * Css and Js are loaded in order of the array indices 
 */
return [
    'site_name' => 'PHP Wiki',
    'css' => [
        [
            'href' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css',
            'integrity' => 'sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1',
            'crossorigin'=> 'anonymous'
        ],
        [
            'href' => './public/theme/css/style.css'
        ],
        [
            'href' => './public/theme/css/vendor.css'
        ]
    ],
    'js' => [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js',
        './public/theme/js/vendor.min.js',
        './public/theme/js/guidebook.js',
        './public/js/search.js',
        './public/js/loadPage.js'
    ]
];