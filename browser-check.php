<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Lazy Eye - by David oh</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

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


<style>

  .introscreen {
    background: none;
    margin-top: 100px;

  }

    .centerbox {
    width: 100px;
    height: 100px;
    display: block;
    position: relative;
    z-index: 99999;
    border: 1px solid red;
    top: 60px;
    left: 110px;
    vertical-align:bottom;
    text-align: center;
  }

  .facetext {
    font-size: 8px;
    background-color: #ffffff;
    opacity: 0.5;
    color: #000000 ;
  }

  .instructiontext {

  }

  #devicepercent {

    width: 100%;
    text-align: center;
    vertical-align: center;
    height: 100px;
  }

  .progress-bar {
    padding: 20px;
font-size: 40px;

  }

  .progress {
    height: 100px;
    vertical-align: center;
  }

</style>

<body>
 <script src="webgazer.js"></script>


 <div class = "container">
 <div class = "row"><h3>Please check that your browser width is more than 70% of your screen. (It's better if you make it full screen).</h3>
<img src = "resource/browsersize.png" class = "center-block"/>
 </div>
<div class = "row">

  <div class = "col-md-12">

    <div class="progress">
  <div class="progress-bar" id = "browsersize" role="progressbar" aria-valuenow="100%" aria-valuemin="0" aria-valuemax="100" style="">

  </div>




</div>

 <p><a class="btn btn-primary btn-lg" href="calibrate.php" role="button">Continue... &raquo;</a></p>

  </div>
</div>

 </div>

   <script>
window.onload = function() {
    webgazer.setRegression('ridge') /* currently must set regression and tracker */
        .setTracker('clmtrackr')
        .setGazeListener(function(data, clock) {
         //   console.log(data); /* data is an object containing an x and y key which are the x and y prediction coordinates (no bounds limiting) */
         //   console.log(clock); /* elapsed time in milliseconds since webgazer.begin() was called */
        })
        .begin()
        .showPredictionPoints(false); /* shows a square every 100 milliseconds where current prediction is */

    var width = 320;
    var height = 240;
    var topDist = '0px';
    var leftDist = '0px';

     var browserHeight = $(window).height();
        var browserWidth = $(window).width();

    var setup = function() {
        var video = document.getElementById('webgazerVideoFeed');
        video.style.display = 'none';
        video.style.position = 'absolute';
        video.style.top = topDist;
        video.style.left = leftDist;
        video.width = width;
        video.height = height;
        video.style.margin = '0px';

        video.style.zIndex="-1";

        video.style.WebkitFilter = "grayscale(100%) blur(10px) brightness(200%)";




        webgazer.params.imgWidth = width;
        webgazer.params.imgHeight = height;

        var overlay = document.createElement('canvas');
        overlay.id = 'overlay';
        overlay.style.position = 'absolute';
        overlay.width = width;
        overlay.height = height;
        overlay.style.top = topDist;
        overlay.style.left = leftDist;
        overlay.style.margin = '0px';
        overlay.style.backgroundColor = '#ffffff';
        overlay.style.opacity = '.7';

       // document.body.appendChild(overlay);
        $("#intro").append(overlay);
        $("#webgazerVideoFeed").appendTo("#intro");

        var cl = webgazer.getTracker().clm;

        function drawLoop() {
            requestAnimFrame(drawLoop);
            overlay.getContext('2d').clearRect(0,0,width,height);
            if (cl.getCurrentPosition()) {
                cl.draw(overlay);
            }
        }
        drawLoop();
    };

    function checkIfReady() {
        if (webgazer.isReady()) {
            showViewportSize();
            setup();
            $(window).resize(showViewportSize);
        } else {
            setTimeout(checkIfReady, 100);
        }
    }
    setTimeout(checkIfReady,100);
};


function showViewportSize() {
   var the_width = $(window).width();
   var the_height = $(window).height();
   var device_width = window.screen.width;
   $('#width').html(the_width);
   $('#devicewidth').html(device_width);
   var device_percent = Math.round((the_width/device_width)*100);
   console.log(device_percent);
   if (device_percent>70) {
    $("#browsersize").removeClass("progress-bar-danger");
     $("#browsersize").addClass("progress-bar-success");
   }
   else {
       $("#browsersize").removeClass("progress-bar-success");
       $("#browsersize").addClass("progress-bar-danger");
   }
   $('.progress-bar').html(device_percent + "%");

$('.progress-bar').css('width', device_percent+'%').attr('aria-valuenow', device_percent);



}




window.onbeforeunload = function() {
    webgazer.end(); //Uncomment if you want to save the data even if you reload the page.
    //window.localStorage.clear(); //Comment out if you want to save data across different sessions
}
        </script>





  <script src="https://d3js.org/d3.v3.min.js"></script>
  <script src="webgazer.js"></script>
  <script   src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
   <script src="movingAverage.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>

</html>
