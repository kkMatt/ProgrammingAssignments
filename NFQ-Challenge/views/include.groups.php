<?php
foreach($groups as $group):
    // HTML
    echo '<div class="singlegroup group-'.$group['group_id'].'">'.$group['group_name'].'</div>';
endforeach;
?>