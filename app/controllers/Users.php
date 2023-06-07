<?php

class Users extends Controller {
    public function __construct()
    {
        // load the user model
        $this->userModel = $this->model('User');
    }

    public function register() {
        // check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];
            
            // validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            } else {
                // check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_error'] = 'Email is already taken';
                }
            }

            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter name';
            }

            // validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } else if (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password must be at least 6 characters';
            }

            // validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_error'] = 'Passwords do not match';
                }
            }

            // make sure errors are empty
            if (empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                // validated
                
                // hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and can now log in.');
                    redirect('users/login');
                } else {
                    die('Sometthing went wrong');
                }
            } else {
                // load view w/ errors
                $this->view('users/register', $data);
            }

        } else {
            // init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => '',
            ];
            
            // load view
            $this->view('users/register', $data);
        }
    }

    public function login() {
        // check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //proocess form
            // sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // process form
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
            ];

            // validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            }

            // validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            }

            // check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // user found
            } else {
                // user not found
                $data['email_error'] = 'No user found';
            }

            // make sure errors arre empty
            if (empty($data['email_error']) && empty($data['password_error'])) {
                // validated
                // check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                // if logged in user is correct, we need to set the session vars to display stuff on the screen
                // e.g. success message
                if ($loggedInUser) {
                    // create session variables
                    $this->createUserSession($loggedInUser);
                } else {
                    // re-render form w/ error
                    $data['password_error'] = 'Password incorrect';

                    $this->view('users/login', $data);
                }
            } else {
                // load view w/ errors
                $this->view('users/login', $data);
            }

        } else {
            // init data
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            
            // load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user) {
        // create session vars for recently logged in user
        // always have to call this to begin sessions
        // session_start();

        // ID is included in user array
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;

        // redirect to posts
        redirect('posts/index');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        // gets rid of all data in sessions
        session_destroy();
        redirect('users/login');
    }
}