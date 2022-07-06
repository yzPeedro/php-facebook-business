<?php

require_once "vendor/autoload.php";

use Meta\FacebookSDK\FacebookPage;
use Meta\FacebookSDK\FacebookUser;
use Meta\FacebookSDK\Exception\FacebookException;

try {
    $user = new FacebookUser('EAAFUq4kBjhcBAC4U7CGYfBoWjdZCZBZAZC5vhhR4u68HIQ5qE7EDiGmUmdYbZB0BHdwfyNm4rXLaiZCpaD3YNPrs7RBOYiA9wPZCdgIe9uaKuZANzhfOzJaZC7yfkgYGhZBBIpA9VrV4XRNGjCEjgu2MwSGc75SVfGTRsROZBlGmtZCXBEoevX8gQAXiVZAejMcXm209YOa4eAgFpVBcRxlC85ZC3v');
    $accounts = $user->accounts();
    $targetPage = $accounts->data[0];

    $page = new FacebookPage($targetPage);

    dd($page->getInstagramBusinessAccount());
} catch (FacebookException $facebookException) {
    dd($facebookException->getMessage());
}
