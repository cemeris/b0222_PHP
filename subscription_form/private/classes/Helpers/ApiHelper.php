<?php
namespace Helpers;

use Database\BlogPosts;
use Database\Subscribers;

class ApiHelper {
    public function getBlogPosts() {
        $blog_manager = new BlogPosts();
        $all_posts = $blog_manager->getAll();
        $output = [];
        if (is_array($all_posts)) {
            $output['blog_posts'] = $all_posts;
            $output['status'] = true;
        }
        else {
            $output['message'] = $blog_manager->getError();
        }

        return $output;
    }

    public function getSubscribers() {
        $subscribers = new Subscribers();
        $all_subscribers = $subscribers->getAll();
        $output = [];
        if (is_array($all_subscribers)) {
            $output['subscribers'] = $all_subscribers;
            $output['status'] = true;
        }
        else {
            $output['message'] = $subscribers->getError();
        }

        return $output;
    }

    public function getSingleSubscriber() {
        $output = [];
        if (isset($_GET['id']) && is_string($_GET['id'])) {
            $id = (int) $_GET['id'];
            $output['status'] = true;
            $subscribers = new Subscribers();
            $output['entity'] = $subscribers->get($id);
        }
        return $output;
    }

    public function getSinglePost() {
        $output = [];
        if (isset($_GET['id']) && is_string($_GET['id'])) {
            $id = (int) $_GET['id'];
            $output['status'] = true;
            $blog_posts = new BlogPosts();
            $output['entity'] = $blog_posts->get($id);
        }
        return $output;
    }

    public function subscribe() {
        $output = [];
        if (
            isset($_POST['name']) && is_string($_POST['name']) &&
            isset($_POST['email']) && is_string($_POST['email'])
        ) {
            $subscribers = new Subscribers();

            $entity = [
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];

            $entity = $subscribers->addEntity($entity);
            if (is_array($entity)) {
                $output['status'] = true;
                $output['entity'] = $entity;
                $output['message'] = 'New Entry added!';
            }
            else {
                $output['message'] = 'There is an error!';
                if (DEBUG_MODE) {
                    $output['message'] .= ' ' . $subscribers->getError();
                }
            }
        }
        return $output;
    }

    public function updateSubscriber() {
        $output = [];
        if (
            isset($_POST['id']) && is_string($_POST['id']) &&
            isset($_POST['name']) && is_string($_POST['name']) &&
            isset($_POST['email']) && is_string($_POST['email'])
        ) {
            
            $subscribers = new Subscribers();
            $entity = [
                'id' => (int) $_POST['id'],
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ];
            $output['status'] = $subscribers->updateEntity($entity);
        }
        return $output;
    }

    public function delete() {
        $output = [];
        if (
            isset($_POST['id']) && is_string($_POST['id'])
        ) {
            $id = (int) $_POST['id'];
            $subscribers = new Subscribers();
            if ($subscribers->delete($id)) {
                $output['status'] = true;
                $output['message'] = "element $id deleted";
            }
            else {
                $output['message'] = "Deletion failed";
            }
        }
        return $output;
    }
}