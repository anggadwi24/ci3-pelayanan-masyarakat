<?php

function curent_date_for_mysql() {
    $date = @date('y-m-d h:i:s', time());
    return $date;
}

function show_nice_date($date) {
    if($date) {
        $date = @date('d F H:m', $date);
        return $date;
    } else {
        return "no date entered";
    }
}


function custom_hash($algo, $data, $salt) {
    $context = hash_init($algo, HASH_HMAC, $salt);
    hash_update($context, $data);

    return hash_final($context);
}


function if_remember($remember = 0) {
    if ($remember == 1) {
        $_SESSION['login_time'] = time() + 60 * 60 * 24;
    } else {
        $_SESSION['login_time'] = time() + 60 * 60 * 6;
    }
}

function active_status($uri_status,$status_name, $return) {
    if($uri_status == $status_name) {
        return $return;
    }
}

function check_user_status($user_id) {
    if ($user_id) {
        $ci = & get_instance();
        $ci->load->database();

        $ci->db->where('id', $user_id);
        $query = $ci->db->get('user');
        $user = $query->row();

        $time_plus = $user->last_seen + 30;
        $curent_time = time();
        if ($time_plus > $curent_time) {
            echo '<span class="label label-success">online</span>';
        } else {
            echo '<span class="label label-warning">ofline</span>';
        }
    }
}