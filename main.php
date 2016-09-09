<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>


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
        width: 30px;
        background-color: #DDDDDD;

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

    #indicators {

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







<div id = "indicators" >
    <div id = "leftInd" class = "indicator"></div>
    <div id = "rightInd" class = "indicator"></div>
</div>



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


        if (cpx > window.innerWidth/2) {
            $("#leftInd").hide(500);
            $("#rightInd").show(500);
        }

        else {
            $("#leftInd").show(500);
            $("#rightInd").hide(500);
        }


       // root.py = data.y;
     //  force.resume();

        //svg.select("#eyeline1").remove();
        var cl = webgazer.getTracker().clm;

      /*  var line = svg.append("line")
                  .attr("x1",data.x)
                  .attr("y1",data.y)
                  .attr("x2",cl.getCurrentPosition()[27][0])
                  .attr("y2",cl.getCurrentPosition()[27][1])
                  .attr("stroke-width",2)
                  .attr("stroke","red")
                  .attr("id","eyeline1"); */

       // svg.select("#eyeline2").remove();
        var cl = webgazer.getTracker().clm;



      })
    .begin()
    .showPredictionPoints(true); /* shows a square every 100 milliseconds where current prediction is */




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
      video.style.opacity = '.0';
      video.style.zIndex="-1";
      //video.style.filter = "grayscale(100%)";
      //video.style.WebkitFilter = "grayscale(100%) blur(5px) contrast(3)";
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
      //overlay.style.backgroundColor = 'white';
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
    //window.localStorage.clear(); //Comment out if you want to save data across different sessions
  }

function movingAverage (avg, sample) {

    avg -= avg/20;
    avg += sample/20;

    return avg;
}



  </script>
</body>
