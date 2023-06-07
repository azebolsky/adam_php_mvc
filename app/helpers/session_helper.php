<?php

session_start();

// flash message helper
// example - call flash after logging in
// flash('register_succeess', 'success regisering');
// display in view <?php echo flash('register_success');
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            // this will get called first if we have a redirect w/ a message
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$class])) {
                unset($_SESSION[$class]);
            }
            
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } else if (empty($message) && !empty($_SESSION[$name])) {
            // this will get called secoond in a view and will display the message we set up on our first pass in the if stmt
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class = "' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$class]);
        }
    }
}

// check if a user is logged in by seeing if a user has been set in sessions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}