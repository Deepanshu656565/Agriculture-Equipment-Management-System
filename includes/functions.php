<?php
// includes/functions.php
function e($str){ return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }

function is_logged_in(){ return isset($_SESSION['user']); }
function is_admin(){ return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'; }

function redirect($path){
    header("Location: " . $path);
    exit;
}

function flash($key, $msg=null){
    if($msg !== null){
        $_SESSION['flash'][$key] = $msg;
        return;
    }
    if(isset($_SESSION['flash'][$key])){
        $m = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $m;
    }
    return null;
}

/**
 * Check if a booking overlaps an existing booking for the same equipment.
 * Two ranges [a_start, a_end] and [b_start, b_end] overlap if not (a_end < b_start OR a_start > b_end)
 */
function overlap_exists($conn, $equipment_id, $start_date, $end_date, $exclude_id = null){
    $sql = "SELECT id FROM bookings
            WHERE equipment_id = ?
              AND status IN ('pending','approved')
              AND NOT (end_date < ? OR start_date > ?)";
    if($exclude_id){
        $sql .= " AND id <> ?";
    }
    $stmt = $conn->prepare($sql);
    if($exclude_id){
        $stmt->bind_param('issi', $equipment_id, $start_date, $end_date, $exclude_id);
    }else{
        $stmt->bind_param('iss', $equipment_id, $start_date, $end_date);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->num_rows > 0;
}

function days_between($start, $end){
    $s = new DateTime($start);
    $e = new DateTime($end);
    $diff = $s->diff($e)->days + 1; // inclusive
    return max($diff, 0);
}
?>