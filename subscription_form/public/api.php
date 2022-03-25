<?php
define('PRIVATE_DIR', __DIR__ . '/../private/');
include PRIVATE_DIR . 'bootstrap.php';

use Helpers\ApiHelper;
use Database\Subscribers;
use Database\BlogPosts;

header('Content-type: application/json');

$output = ['status' => false];
$api_helper = new ApiHelper();

if (isset($_GET['batch']) && is_string($_GET['batch'])) {
    switch ($_GET['batch']) {
        case 'batch1':
            $blog_posts = $api_helper->getBlogPosts();
            if (array_key_exists('status', $blog_posts)) {
                $list_of_subscribers = $api_helper->getSubscribers();
                if (array_key_exists('status', $list_of_subscribers)) {
                    // Both queries are without errors
                    $output = array_merge($output, $blog_posts, $list_of_subscribers);
                }
                else {
                    // Error in Subscription query
                    $output = array_merge($output, $list_of_subscribers);
                }
            }
            else {
                // Error in BlogPosts query
                $output = array_merge($output, $blog_posts);
            }
        break;
    }
}
elseif (isset($_GET['name']) && is_string($_GET['name'])) {
    switch ($_GET['name']) {
        case 'getBlogPosts':
            $output = array_merge($output, $api_helper->getBlogPosts());
            break;
        case 'getSubscribers':
            $output = array_merge($output, $api_helper->getSubscribers());
            break;
        case 'getSingleSubscriber':
            $output = array_merge($output, $api_helper->getSingleSubscriber());
            break;
        case 'getSinglePost':
            $output = array_merge($output, $api_helper->getSinglePost());
            break;
        case 'subscribe':
            $output = array_merge($output, $api_helper->subscribe());
            break;
        case 'update_subscribe':
            $output = array_merge($output, $api_helper->updateSubscriber());
            break;
        case 'delete':
            $output = array_merge($output, $api_helper->delete());
            break;
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);