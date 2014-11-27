<?php
foreach($users as $user):
    $userGroups = array();
    foreach($user['user_groups'] as $userGroup):
        // HTML
        $userGroups[] = '<span class="usergroup-'.$userGroup['group_id'].'">'.$userGroup['group_name'].'</span>';
    endforeach;
    $userGroups = implode(', ', $userGroups);

    // HTML
    echo '<div class="singleuser user-'.$user['user_id'].'">'.$user['user_name'].'<br />';
    echo '<div class="usergroups"><strong>Groups:</strong> '.$userGroups.'</div>';
    echo '</div>';
endforeach;
?>
