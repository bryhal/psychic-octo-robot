<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="reset.css">
    </head>
    <body>
        <?php
        $mtime = microtime();
        $mtime = explode(" ", $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $starttime = $mtime;
        ;
        ?> 
        
        <?php
        include_once './lib/ezdb/ezdb.class.php';

        $tweets = DB::get_results("SELECT * FROM raw_stream LIMIT 100");

        foreach ($tweets as $tweet) {
            echo '<pre><code>';
            print_r(json_decode(unserialize(base64_decode($tweet->raw_tweet)), TRUE));
            echo '</code></pre>';
        }
        ?>

        <!-- put this code at the bottom of the page -->
        <?php
        $mtime = microtime();
        $mtime = explode(" ", $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        $totaltime = ($endtime - $starttime);
        echo "This page was created in " . $totaltime . " seconds";
        ;
        ?>

    </body>
</html>
