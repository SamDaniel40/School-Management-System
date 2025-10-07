<?php
// 
function get_setting($key = '', $signle = false, $type = 'object')
{
    global $db_conn;
    $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_Settings");

    if (!empty($key)) {
        $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_Settings WHERE SettingKey = ?", array($key));
    }

    if ($signle) {
        return sqlsrv_fetch_object($query)->SettingValue;
    } else {
        return data_output($query, $type);
    }
}

function get_the_teachers($args)
{
    return $args;
}

function get_the_classes()
{
    global $db_conn;
    $output = array();
    $query = sqlsrv_query($db_conn, 'SELECT * FROM tbl_Classes');

    while ($row = sqlsrv_fetch_object($query)) {
        $output[] = $row;
    }

    return $output;
}


function get_post(array $args = [])
{
    global $db_conn;
    if (!empty($args)) {
        $condition = "WHERE 0 ";
        foreach ($args as $k => $v) {
            $v = (string) $v;
            $condition_ar[] = "$k = '$v'";
        }
        if ($condition_ar > 0) {
            $condition = "WHERE " . implode(" AND ", $condition_ar);
        }
    }
    ;


    $sql = "SELECT * FROM tbl_Posts $condition";
    $query = sqlsrv_query($db_conn, $sql);
    return sqlsrv_fetch_object($query);
}

function get_posts(array $args = [], string $type = 'object')
{
    global $db_conn;
    $condition = "WHERE 0 ";
    if (!empty($args)) {
        foreach ($args as $k => $v) {
            $v = (string) $v;
            $condition_ar[] = "$k = '$v'";
        }
        if ($condition_ar > 0) {
            $condition = "WHERE " . implode(" AND ", $condition_ar);
        }
    }
    ;


    $sql = "SELECT * FROM tbl_Posts $condition";

    $query = sqlsrv_query($db_conn, $sql);
    return data_output($query, $type);
}

function get_metadata($item_id, $meta_key = '', $type = 'object')
{
    global $db_conn;
    $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_MetaData WHERE ItemId = ?", array($item_id));
    if (!empty($meta_key)) {
        $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_MetaData WHERE ItemId = ? AND MetaKey = ?", array($item_id, $meta_key));
    }
    return data_output($query, $type);
}


function data_output($query, $type = 'object')
{
    $output = array();
    if ($type == 'object') {
        while ($result = sqlsrv_fetch_object($query)) {
            $output[] = $result;
        }
    } else {
        while ($result = sqlsrv_fetch_object($query)) {
            $output[] = $result;
        }
    }
    return $output;
}


function get_user_data($user_id, $type = 'object')
{
    global $db_conn;
    $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_Accounts WHERE Id = ?", array($user_id));

    // $result = sqlsrv_query($db_conn,$query);

    $user = sqlsrv_fetch_object($query);

    $user += get_user_metadata($user_id);

    return $user;
    // return data_output($query , $type)[0];
}


function get_post_title($post_id = '')
{
}


function get_users($args = array(), $type = 'object')
{
    global $db_conn;
    $condition = "";
    if (!empty($args)) {
        foreach ($args as $k => $v) {
            $v = (string) $v;
            $condition_ar[] = "$k = '$v'";
        }
        if ($condition_ar > 0) {
            $condition = "WHERE " . implode(" AND ", $condition_ar);
        }
    }
    $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_Accounts $condition");
    return data_output($query, $type);
}


function get_user_metadata($user_id)
{
    global $db_conn;
    $output = [];
    $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_UserMeta WHERE UserId = ?", array($user_id));
    while ($result = sqlsrv_fetch_object($query)) {
        $output[$result->MetaKey] = $result->MetaValue;
    }

    return $output;
}

function get_usermeta($user_id, $meta_key, $signle = true)
{
    global $db_conn;
    if (!empty($user_id) && !empty($meta_key)) {
        $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_UserMeta WHERE UserId = ? AND MetaKey = ?", array($user_id, $meta_key));
    } else {
        return false;
    }
    if ($signle) {
        return sqlsrv_fetch_object($query)->MetaValue;
    } else {
        return sqlsrv_fetch_object($query);
    }
}
