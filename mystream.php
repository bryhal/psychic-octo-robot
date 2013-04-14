<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mystream
 *
 * @author bryhal
 */

require_once '/Applications/MAMP/htdocs/phirehose2/lib/Phirehose.php';

/**
* get_tweets.php
* Collect tweets from the Twitter streaming API
* This must be run as a continuous background process
* Latest copy of this code: http://140dev.com/free-twitter-api-source-code-library/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
* @version BETA 0.10
*/

require_once '/Applications/MAMP/htdocs/phirehose2/lib/ezdb/ezdb.class.php';

$fh = fopen('mystream.pid.txt', "w");
$pid = getmypid();
fwrite($fh, $pid);
fclose($fh);

class Consumer extends Phirehose
{

	
  // This function is called automatically by the Phirehose class
  // when a new tweet is received with the JSON data in $status
  public function enqueueStatus($status) {
          
          DB::quick_insert('raw_stream', array('raw_tweet' => base64_encode(serialize($status))));

  }
}

// Open a persistent connection to the Twitter streaming API
// Basic authentication (screen_name, password) is still used by this API
$stream = new Consumer('twitrakdotnet', 'fg23io98', Phirehose::METHOD_FILTER);


// The keywords for tweet collection are entered here as an array
// More keywords can be added as array elements
// For example: array('recipe','food','cook','restaurant','great meal')
$stream->setFollow(array(1194008162,53338746,313525912));

// Start collecting tweets
// Automatically call enqueueStatus($status) with each tweet's JSON data
$stream->consume();

?>