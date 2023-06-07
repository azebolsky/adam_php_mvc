<?php

    class Pages extends Controller {
        public function __construct()
        {
            
        }

        public function index() {
            if (isLoggedIn()) {
                redirect('posts');
            }

            // pass in view and data (optional)
            $data = [
                'title' => 'SharePosts',
                'description' => 'Simple social network build on the AdamMVC PHP Framework'
            ];
            $this->view('pages/index', $data);
        }
        
        public function about() {
            $data = [
                'title' => 'About Us',
                'description' => 'App to share posts for users.'
            ];
            $this->view('pages/about', $data);
        }
    }