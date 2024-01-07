<?php

function db_connect()
{
    static $connection;

    if (!$connection) {
        $config = parse_ini_file("./config.ini");
        $connection = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database'], $config['port']);
    }

    return $connection;
}
//dd die and dump
function dd($data)
{
    die(var_dump($data));
}
function db_query($query)
{
    $connection = db_connect();
    $result = mysqli_query($connection, $query);
    return $result;
}
function db_select($select_query)
{
    $result = db_query($select_query);
    if (!$result) {
        return false;
    }
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function sanitize($value)
{
    $connection = db_connect();
    return trim(mysqli_real_escape_string($connection, $value));
}

function prepare_insert_query($table_name, $data)
{
    $values = array_values($data);
    $keys = array_keys($data);
    for ($i = 0; $i < count($values); $i++) {
        $values[$i] = "'" . $values[$i] . "'";
    }
    $valuesString = implode(", ", $values);
    $keysString = implode(", ", $keys);
    //dd($keysString);

    return "INSERT INTO $table_name ($keysString) VALUES ($valuesString);";
}

function old($collection, $key, $default_value = "")
{
    //the partial values which are correct toh woh udar hi rehne ka
    return trim(isset($collection[$key]) ? $collection[$key] : $default_value);
}

function get_last_insert_id()
{
    $connection = db_connect();
    return mysqli_insert_id($connection);
}

function redirect($url)
{
    //Location:space 
    header("Location: $url");
}

function get_image_file_name($image_name, $id)
{
    $len = count(explode(".", $image_name));
    return $len === 1 ? "$id.$image_name" : $image_name;
}
