<?php 
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function generate_rank($avgScore){
    $status = "";
    if($avgScore == NULL){
        $status = "Silver";
    }
    if($avgScore >= 1){
        $status = "Wood";
    }
    if($avgScore >= 1.7){
        $status = "Iron";
    }
    if($avgScore >= 2.5){
        $status = "Bronze";
    }
    if($avgScore >= 3){
        $status = "Silver";
    }
    if($avgScore >= 3.5){
        $status = "Gold";
    }
    if($avgScore >= 4){
        $status = "Platinum";
    }
    if($avgScore >= 4.5){
        $status = "Diamond";
    }
    if($avgScore >= 4.7){
        $status = "Challenger";
    }
    return $status;
}
?>