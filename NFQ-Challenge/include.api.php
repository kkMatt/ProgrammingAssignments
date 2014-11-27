<?php
/**
 * Created by PhpStorm.
 * User: KestutisIT
 * Date: 2014/11/27
 * Time: 2:29 AM
 */

// Read calls
$apiCommand = Flight::request()->query->command;
$apiData = Flight::request()->query->command;

// Set default output
$returnedData = "";

// DB: get new instance
$db = Flight::db();



// Depending on the call (command) received to api, load proper view
switch($apiCommand)
{
    // List users
    case "get_users":
        $users = array();
        $tmpUsers = array();

        // DB: get all users in database
        $users = $db->query("
          SELECT user_id, user_name
          FROM nfq_users
        ");

        // Iterate over all users and add user group names & id's to user row
        foreach($users as $user)
        {
            $userGroups = $db->query("
              SELECT ug.group_id AS group_id, g.group_name AS group_name
              FROM nfq_user_groups ug
              LEFT JOIN nfq_groups g ON g.group_id=ug.group_id
              WHERE ug.user_id='{$user['user_id']}'
            ");
            $user['user_groups'] = $userGroups;
            $tmpUsers[] = $user;
        }
        $users = $tmpUsers;
        //print_r($users);

        // Save view to variable
        ob_start();
        include("views/include.users.php");
        $returnedData = ob_get_clean();
        break;

    // List groups
    case "get_groups":
        $groups = $db->query("
          SELECT group_id, group_name
          FROM nfq_groups
        ");

        // Save view to variable
        ob_start();
        include("views/include.groups.php");
        $returnedData = ob_get_clean();
        break;
}


// Output - JSON
Flight::json(array(
    "returnedData" => $returnedData
));
