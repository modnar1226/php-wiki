# php-wiki

[![Author](http://img.shields.io/badge/author-@modnar1226-blue.svg?style=flat-square)](https://example.com)

A configurebale php wiki tool.


# Usage Example:
``` php
<?php
require 'Wiki/autoloader.php';
use Main;

$wiki = new Main();
if (empty($_POST)) {
    $wiki->index();
} else {
    echo $wiki->getDoc($_POST['document']);
}
```

# Config Example:
```php
<?php
/**
 * Add 3rd party dependancies here. Usefull for when you have either compiled css and javascript or using individual files specific to the documentation
 * Css and Js are loaded in order of the array indices 
 */
return [
    'use_database' => true,
    'db_host' => 'mysql:host=localhost;dbname=documents',
    'db_username' => 'your-database-username',
    'db_password' => 'your-secret-password',
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
    ],
    
];
```

## Features

* **Css and Javascript Optional**: Examples loaded with a bootstrap theme to generate an html page with styling.
* ****: Entirely customizable, start with raw data or from some suggestion of normalized data.
Loaded with bootstrap and uses built in templates to generate an html page with styling.

You can choose to use a file based document system, or a database sotrage system.

Planned features:

1. Html text editor, allowing direct editing capabilities to either file based or database hosted documents.
2. Pdf export of documents.
