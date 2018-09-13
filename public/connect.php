<?php
    //连接数据库的函数封装
    function connect() {
        $conn = mysqli_connect('localhost', 'root', 'root', 'xiuer');
        return $conn;
    }

    function query($conn,$sql) {
        $res = mysqli_query($conn,$sql);
        $arr = [];
        while($row = mysqli_fetch_assoc($res)) {
            $arr[] = $row;
        }
        return $arr;
    }

?>