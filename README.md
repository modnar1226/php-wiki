# php-wiki

[![Author](http://img.shields.io/badge/author-@modnar1226-blue.svg?style=flat-square)](https://example.com)

A configurebale php wiki tool.


# Usage Example:
This repo contains a working example of the Wiki page using a bootstrap theme.
Navagate to localhost/php-wiki/index.php tt view in a browser.

``` php
<?php
require 'Wiki/autoloader.php';
use Wiki\Main;
use Wiki\Load;
    
$wiki = new Main();
$load = new Load();

if (empty($_POST)) {
    $headerParams = [
        'title' => 'PHP Wiki',
        'cssFiles' => [
            [
                'href' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css', //boot strap css
                'integrity' => 'sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1',
                'crossorigin' => 'anonymous'
            ],
            [
                'href' => './public/theme/css/style.css' // theme css
            ],
            [
                'href' => './public/theme/css/vendor.css' // theme css
            ]
        ],
        'jsFiles' => [
            'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js', // bootstrap js
            './public/theme/js/vendor.min.js', // theme
            './public/theme/js/guidebook.js', //theme
            './public/js/loadPage.js' // required at minimum to load 
        ],
    ];

    // loads html boilerplate with Css and Js from config
    $load->view(
        'Wiki/templates/header.php',
        $headerParams,
        false
    );

    // loads the main wiki page uses css and js loaded previously
    $load->view(
        'Wiki/templates/body.php',
        [
            'menuData' => $wiki->menuData,
            'containerClass' => 'container',
            'innerContainerClass' => 'row justify-content-between',
            'navClass' => 'nav flex-column nav-vertical',
            'searchFormClass' => 'd-flex',
            'searchInputClass' => 'form-control me-2',
            'searchButtonClass' => 'btn btn-outline-success',
            'navListClass' => 'pt-4 nav flex-column nav-colapse',
            'navListItemClass' => 'nav-item',
            'navLinkClass' => 'nav-link',
            'contentClass' => 'col-sm-8 col-lg-10',
            // load inner content
            'content' => $load->view(
                'Wiki/templates/default.php',
                [],
                true
            ),
        ],
        false
    );

    // loads the footer boilerplate to close the html and body tags
    $load->view(
        'Wiki/templates/footer.php',
        [],
        false
    );
} else {
    echo $load->view(
        'Wiki/templates/content.php',
        [
            'sections' => [$wiki->getDoc($_POST['document'])],
            'secTitleClass' => 'text-center',
            'secParagraphClass' => 'ps-5',
            'secHeaderClass' => ''
        ],
        true
    );
}
```

# Config Example:
```php
<?php
/**
 * Boolean to toggle database or file system document storage.
 * and
 * Database Credentials 
 */
return [
    'use_database' => true,
    'db_host' => 'mysql:host=localhost;dbname=documents',
    'db_username' => 'your-database-username',
    'db_password' => 'your-secret-password',  
];
```

## Features

* **Css and Javascript Not Required**: Examples loaded with a bootstrap theme to generate an html page with styling.
* **Database or File System Storage**: Uses either global constants or configuration file to connect to mysql database

## Planned features:

1. Html text editor, allowing direct editing capabilities to either file based or database hosted documents.
2. Pdf export of documents.
