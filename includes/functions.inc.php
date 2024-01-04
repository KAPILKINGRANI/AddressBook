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
