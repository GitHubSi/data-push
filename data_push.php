<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2015/12/7
 * Time: 23:41
 */

header("Content-Type: text/event-stream");
while(true){
    echo "data:" .date("T-m-d H:i:s"). "\n\n";
    @ob_flush();
    @flush();
    sleep(1);
}