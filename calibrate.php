<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Calibration</title>


 <style>


    body {
        width:100%;
        height:100%;
        background-color: white;
        margin: auto;
        text-align:center;
    }

    #intro {
        width: 80%;
        height: 100%;
        text-align:center;
        background-color: silver;
         visibility: hidden;
    }

    .indicator {
        height:100%;
        width: 50px;
        background-color: #69F0AE;

    }

    #leftInd {
        top: 0px;
        left: 0px;
        position: fixed;
        display: block;

    }

     #rightInd {
        top: 0px;
        right: 0px;
        position: fixed;
        display: block;
    }


     #middleInd {
        top: 0px;
        left: 50%;
        position: fixed;
        display: block;
    }


      #buttonLeft {
        top: 0px;
        left: 0px;
        position: fixed;
        display: block;

    }

     #buttonRight {
        top: 0px;
        right: 0px;
        position: fixed;
        display: block;
    }

    .calibrateButton {
        height:800px;
        width: 100px;
        background-color: #dddddd;
        visibility: hidden;
    }


    #webgazerVideoFeed {
        visibility: hidden;
    }

    #predictionSquare {
        opacity: 0.3;
       -webkit-filter: blur(10px);
    }


  </style>

    <!-- Bootstrap -->
   <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>


<body>

  <script src="https://d3js.org/d3.v3.min.js"></script>
  <script src="webgazer.js"></script>
  <script   src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
   <script src="movingAverage.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style>

    #calibrateA {
        height:50px;
        width: 100px;
        display: block;
        position: fixed;
        top: 50%;
        left: 0%;
        text-align: center;
        z-index:5000;
    }

    #calibrateB {
        height:50px;
        width: 100px;
        display: block;
        position: fixed;
        top: 50%;
        right: 0%;
        text-align: center;
        z-index:5000;
    }


    #calibrateDone {
        height: 100px;
        width: 300px;
        display: block;
        position: fixed;
        top: 40%;
        left: 40%;
        text-align: center;
        z-index:5000;

    }



</style>




<div id = "indicators">
<div style = "padding-top:300px"><h3>Look left or right, hold that gaze.</h3></div>
    <div id = "leftInd" class = "indicator">.</div>
      <div id = "middleInd" class = "indicator">.</div>
    <div id = "rightInd" class = "indicator">.</div>
</div>








<div class = "row">
    <h1 id = "attempts"></h1>
</div>
<div id = "instructions" class = "row" style= "top:200px">
    <h2>Instructions</h2>
    <h3>We are now going to calibrate our sensing routine. <em>Without moving your head</em>, please look to the left or right to click on the button.</h3>
    <h3>Click on the button to the left or right of the screen to continue. </h3>
</div>
<a id = "calibrateDone"  class="btn btn-success btn-lg" href="main.php" role="button">Continue!!!</a>
<a id = "calibrateA" class="calibrate btn btn-primary btn-lg" href="#" role="button">** A **</a>
<a id = "calibrateB"  class="calibrate btn btn-success btn-lg" href="#" role="button">** B **</a>
<script>
    /* Calibration Routine */
var totalAttempts=6;
var attempts = 0;
var lastattempt = 0;
$("#indicators").hide();
$("#calibrateA").show();
$("#calibrateB").hide();
$("#calibrateDone").hide();
//$("#attempts").html(totalAttempts-attempts + " Clicks Left")


$( ".calibrate" ).click(function() {

  $("#attempts").html(totalAttempts-attempts+1 + " Clicks Left")

$("#calibrateA").hide();
$("#calibrateB").hide();




//console.log ("Rand:" + randomButton);

var min = 100;
var max = $(window).height()-200;

var newTop = Math.floor(Math.random() * (max - min + 1)) + min + "px";

console.log (newTop);


if (lastattempt == 0)
{
  $("#calibrateA").css('top', newTop);
  $("#calibrateA").show(300);
  $("#calibrateB").hide(300);
    $("#instructions").hide();
    lastattempt =1;
}
else {
   $("#calibrateA").hide(300);
 $("#calibrateB").css('top', newTop);
  $("#calibrateB").show(300);
   $("#instructions").hide();
    lastattempt =0;
}

 if (attempts > totalAttempts) {
        $("#calibrateA").hide();
       $("#calibrateB").hide();
        $("#overlay").hide();
        console.log("ALLDONE");
          $("#attempts").hide();
       $("#indicators").show();
    }

attempts++;


});

</script>

  <script>
var cpx = 0;
var tick = 0;
var iteration = 0;
  window.onload = function() {

    var localstorageLabel = 'webgazerGlobalData';
    window.localStorage.setItem(localstorageLabel, null);

    webgazer.setRegression('ridge') /* currently must set regression and tracker */
    .setTracker('clmtrackr')
    .setGazeListener(function(data, clock) {
         //console.log(Math.round(clock));
         tick = Math.round(clock);
         if(!data)
          return;
        cpx = movingAverage(cpx,data.x);
        if (iteration > 10)
        {
            console.log ("Tick: " + tick + " CPX: " + cpx);
            iteration = 0;
        }
        //console.log (iteration);
        iteration++;
        var cpy = data.y;

        var totalwidth = window.innerWidth;


        var width1 = (totalwidth/3);
        var width2 = width1*2;


        if (cpx < width1 && cpx > 0) {
            $("#leftInd").show(500);
            $("#rightInd").hide(500);
           $("#middleInd").hide(500);
        }



        else if (cpx > width1 && cpx < width2){ //middle
            $("#leftInd").hide(500);
              $("#middleInd").show(500);
            $("#rightInd").hide(500);
        }

        else if (cpx > width2 && cpx < totalwidth){
            $("#leftInd").hide(500);
              $("#middleInd").hide(500);
            $("#rightInd").show(500);
        }


        var cl = webgazer.getTracker().clm;


      //  var cl = webgazer.getTracker().clm;



      })
    .begin()
    .showPredictionPoints(false); /* shows a square every 100 milliseconds where current prediction is */




    var width = window.innerWidth,
    height = window.innerHeight;



    function setup() {

      var width = 320;
      var height = 240;
      var topDist = '0px';
      var leftDist = '0px';

        var browserHeight = $(window).height();
        var browserWidth = $(window).width();

        console.log ("Height:" + browserHeight + " Width:" + browserWidth);

      var video = document.getElementById('webgazerVideoFeed');
      video.style.display = 'block';
      video.style.position = 'fixed';
      video.style.top = ((browserHeight/2)-(height/2))+ 'px';
      video.style.left = ((browserWidth/2)-(width/2))+ 'px';
      video.width = width;
      video.height = height;
      video.style.margin = '0px';
     // video.style.opacity = '.0';
      video.style.zIndex="-1";
      //video.style.filter = "grayscale(100%)";
      video.style.WebkitFilter = "grayscale(100%) blur(5px) contrast(3) brightness(3)";
     //  video.style.WebkitFilter = "";

      webgazer.params.imgWidth = width;
      webgazer.params.imgHeight = height;

    //  $("body").append(video);

      var overlay = document.createElement('canvas');
      overlay.id = 'overlay';
      overlay.style.position = 'fixed';
      overlay.width = width;
      overlay.height = height;
      overlay.style.top = ((browserHeight/2)-(height/2))+ 'px';
      overlay.style.left =  ((browserWidth/2)-(width/2))+ 'px';
      overlay.style.margin = '0px';
      overlay.style.backgroundColor = 'white';
      overlay.style.border = '1px solid #CCCCCC';

      $("body").append(overlay);
     // document.body.appendChild(overlay);

      var cl = webgazer.getTracker().clm;

      function drawLoop() {
        requestAnimFrame(drawLoop);
        overlay.getContext('2d').clearRect(0,0,width,height);
        if (cl.getCurrentPosition()) {
          cl.draw(overlay);
         // console.log ("Draw");
        }
      }
      drawLoop();
    };

    function checkIfReady() {
      if (webgazer.isReady()) {
        setup();
      } else {
        setTimeout(checkIfReady, 100);
      }
    }

    setTimeout(checkIfReady,100);

  };

  window.onbeforeunload = function() {
    webgazer.end(); //Uncomment if you want to save the data even if you reload the page.
   // window.localStorage.clear(); //Comment out if you want to save data across different sessions
  }

function movingAverage (avg, sample) {

    avg -= avg/20;
    avg += sample/20;

    return avg;
}



  </script>
</body>
