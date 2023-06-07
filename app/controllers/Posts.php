<?php

class Posts extends Controller {
    public function __construct()
    {
        // check to see if session user id is there, if not then redirect
        // if non-logged in users should access posts, then we do not need this
        if (!isLoggedIn()) {
            redirect('/users/login');
        }

        // load the user model
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index() {
        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts
        ];
        
        $this->view('posts/index', $data);
    }

    public function add() {
        // check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => trim($_SESSION['user_id']),
                'title_error' => '',
                'body_error' => ''
            ];

            // validate title
            if (empty($data['title'])) {
                $data['title_error'] = 'Please enter a title';
            }

            //validate body
            if (empty($data['body'])) {
                $data['body_error'] = 'Please enter something into the body';
            }

            // check if we have any errors
            if (empty($data['title_error']) && empty($data['body_error'])) {

                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post successfully added');
    
                    redirect('posts');
                } else {
                    die('Something went wrong when adding post.');
                }
            } else {
                // load view with errors
                $this->view('posts/add', $data);
            }
            
        } else {
            // init data
            $data = [
                'title' => '',
                'body' => '',
                'title_error' => '',
                'body_error' => ''
            ];
            
            // load view
            $this->view('posts/add', $data);
        }
    }

    // pass in id so we can look at the details for a specific post
    public function show($id) {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);
    }

    public function edit($id) {
        // check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => trim($_SESSION['user_id']),
                'title_error' => '',
                'body_error' => ''
            ];

            // validate title
            if (empty($data['title'])) {
                $data['title_error'] = 'Please enter a title';
            }

            //validate body
            if (empty($data['body'])) {
                $data['body_error'] = 'Please enter something into the body';
            }

            // check if we have any errors
            if (empty($data['title_error']) && empty($data['body_error'])) {

                if ($this->postModel->editPost($data)) {
                    flash('post_message', 'Post successfully edited');
    
                    redirect('posts');
                } else {
                    die('Something went wrong when adding post.');
                }
            } else {
                // load view with errors
                $this->view('posts/edit', $data);
            }
            
        } else {
            $post = $this->postModel->getPostById($id);
            
            // check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }

            // init data
            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];
            
            // load view
            $this->view('posts/edit', $data);
        }
    }

    // pass in id so we can locate and delete post
    public function delete($id) {
        // since this is a delete request, it should always be a post request
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = $this->postModel->getPostById($id);
            
            // check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }

            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Removed');
                redirect('posts');
            } else {
                die('Something went wrong when deleting post.');
            }
        } else {
            redirect('posts');
        }
    }
    
}