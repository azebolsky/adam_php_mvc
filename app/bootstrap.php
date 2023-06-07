<?php
    // Load Config
    require_once 'config/config.php';

    // load helpers
    require_once 'helpers/url_helper.php';
    require_once 'helpers/session_helper.php';

    // autoload core libraries
    // allows to not have a bunch of requires
    spl_autoload_register(function($className) {
        // filename must match class name
        require_once 'libraries/' . $className . '.php';
    });