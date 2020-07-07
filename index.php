<html>

  <head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300&display=swap" rel="stylesheet"> 
    <header>
      <title> Log in </title>
    </header>
  </head>

  <body>
  <!-- <img src="images/background.png" id="bg" alt=""> -->

<?php
// Hides pesky errors!
error_reporting(0);

// This grabs the url with the json data
$url = 'http://49.12.108.27:6969/userdata';
$obj = json_decode(file_get_contents($url) , true);

// This checks if the json is empty and if so it stops the code and tells you no one logged in
if ($obj === null)
  {
    exit("<h5 class='error'> Hmm. No one has checked in yet.  </h5>
          <h6> Have you tried checking in? <h6>
          <br>
          <b> If checking in doesn't work, use this to troubleshoot. </b>
          
          <p>Try scanning again, it will make a *beep* sound.</p>
          <p>Check if you are using the correct card.</p>
          <p>Ask assitance from BIT coaches or SL-YJ members</p>
          ");
  }

  // These variables are a few values from the json data we previously decoded
  $id = $obj["user"]["id"];
  $name = $obj["user"]["name"];
  $level = $obj["user"]["level"];
  $time = $obj["attendanceRegistered"];

  ?>

    <!-- This script does something called 'polling'. In this case it requests data from the json every 2000 miliseconds (2 seconds) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        var previous = null;
        var current = null;
        setInterval(function() {
            $.getJSON("http://49.12.108.27:6969/userdata", function(json) {
                current = JSON.stringify(json);
                // This checks if the data is the same as the previous data it recieved. If it isn't the same the page reloads.
                if (previous && current && previous !== current) {
                    console.log('refresh');
                    location.reload();
                }
                previous = current;
            });
        }, 500);
    </script>

    <script type="text/javascript" src="js/materialize.min.js"></script>

    <img id='bitlogo' src='images/bitwit.png'>

    <!-- The next view divs builds our 'card' the html and styling is being done with the Materialize framework -->
    <div class="card">
      <div class="card-image waves-effect waves-block waves-light">
      <?php
      $lars = 'images/lars.png';
      $jim = 'images/lars.png';

      if ($name == "Lars") {
        $image = 'images/lars.png';
      } else {
        $image = 'images/jim.png';
      }

        echo "<img id='bit' class='activator' src=" . $image . ">";
      ?>
      </div>
      <div class="card-content">

<?php

echo "<span class='card-title activatorg rey-text text-darken-4'> $name <i class='material-icons right'>more_vert</i></span>";
echo "<b> id: </b>" . $id;
echo "<br>";
echo "<b> Level: </b>" . $level;
echo "<br>";
echo "<b> Attendance: </b>" . $time;

switch ($time)
{
    // This case checks if that value is ON_TIME if so it tells you how long you have until the day starts
    case "ON_TIME":
      echo "<br> <br>";
      echo "<b> You are on time! </b>";;

      date_default_timezone_set("Europe/Amsterdam");

      $checkinTime = strtotime("9:30:00");
      $calculation = $checkinTime - time();
      

      $hours = date('H', $calculation) - 1;
      $minutes = date('i', $calculation);
      $seconds = date('s', $calculation);
        
      echo "<br>";
      
      if ($hours == 0) {
        echo "We begin in " . $minutes . " minutes and " . $seconds . " seconds.";
      } else {
        echo "We begin in " . $hours . " hours, " . $minutes . " minutes and " . $seconds . " seconds.";
      }

    break;

    // This case checks if that value is TO_LATE if so it tells you how long you've been to late
    case "TO_LATE":
      echo "<br> <br>";
      echo "<b> You are late! </b>";

      date_default_timezone_set("Europe/Amsterdam");

      $checkinTime = strtotime("9:30:00");
      $calculation = time() - $checkinTime;

      $hours = date('H', $calculation) - 1;
      $minutes = date('i', $calculation);
      $seconds = date('s', $calculation);
        
      echo "<br>";

      if ($hours == 0) {
        echo "You are " . $minutes . " minutes and " . $seconds . " seconds late!";
      } else {
        echo "You are " . $hours . " hours, " . $minutes . " minutes and " . $seconds . " seconds late!";
      }
    
    break;

    // This case checks if that value is SICK if so it tells you that you are sick and need to go home
    case "SICK":
      echo "<br>";
      echo "<b> You're sick, go home. <b>";
      echo "<br>";

      echo "<img id='gun' src='images/gun.png' alt='gun'>";
    break;
}


?>

</div>
<div class="card-reveal">

<?php

echo "<span class='card-title grey-text text-darken-4'> $name <i class='material-icons right'>close</i></span>";
echo "<b> Level: </b>" . $level;

// This switch revolves around the $time variable that contains the attendanceRegistered value of our json file
switch ($time)
{
    // This case checks if that value is ON_TIME if so it tells you how long you have until the day starts
    case "ON_TIME":
      echo "<br> <br>";
      echo "<b> You are on time! </b>";;

      date_default_timezone_set("Europe/Amsterdam");

      $checkinTime = strtotime("9:30:00");
      $calculation = $checkinTime - time();
      

      $hours = date('H', $calculation) - 1;
      $minutes = date('i', $calculation);
      $seconds = date('s', $calculation);
        
      echo "<br>";
      
      if ($hours == 0) {
        echo "We begin in " . $minutes . " minutes and " . $seconds . " seconds.";
      } else {
        echo "We begin in " . $hours . " hours, " . $minutes . " minutes and " . $seconds . " seconds.";
      }

    break;

    // This case checks if that value is TO_LATE if so it tells you how long you've been to late
    case "TO_LATE":
      echo "<br> <br>";
      echo "<b> You are late! </b>";

      date_default_timezone_set("Europe/Amsterdam");

      $checkinTime = strtotime("9:30:00");
      $calculation = time() - $checkinTime;

      $hours = date('H', $calculation) - 1;
      $minutes = date('i', $calculation);
      $seconds = date('s', $calculation);
        
      echo "<br>";

      if ($hours == 0) {
        echo "You are " . $minutes . " minutes and " . $seconds . " seconds late!";
      } else {
        echo "You are " . $hours . " hours, " . $minutes . " minutes and " . $seconds . " seconds late!";
      }
    
    break;

    // This case checks if that value is SICK if so it tells you that you are sick and need to go home
    case "SICK":
      echo "<br>";
      echo "<b> You're sick, go home. <b>";
      echo "<br>";

      echo "<img id='gun' src='images/gun.png' alt='gun'>";
    break;
}

?>
      </div>
    </div>
  </body>

</html>