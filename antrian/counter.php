<!doctype html>  

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>jquery.stopwatch.js demo</title>
    <meta name="description" content="jquery.stopwatch.js demo">
    <meta name="author" content="Rob Cowie">
    <script src="https://raw.github.com/nene/jintervals/master/jintervals.js"></script>
    
    <style>
        h1 {
            text-align: center;
        }
        .example {
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            width: 70%;
            height: 26px;
            line-height: 26px;
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            color: #333;
        }
        .label {
            float: left;
            width: 25em;
            text-align: right;
            padding-right: 10px;
        }
        .demo {
            margin-bottom: 10px;
            width: 150px;
            border-bottom-left-radius: 4px 4px;
            border-bottom-right-radius: 4px 4px;
            border-top-left-radius: 4px 4px;
            border-top-right-radius: 4px 4px;
            border: 2px solid #EEE;
            float: left;
            padding: 0px 8px;
        }
        #demo2, #demo3 {
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div id="container">
        <header>
            <h1>jquery.stopwatch.js Examples</h1>
        </header>
        
        <div id="main">
            <div class="example">
                <div class="label">Count up from now</div>
                <div id="demo1" class="demo">00:00:00</div>
            </div>
            <div class="example">
                <div class="label">Click to toggle (start/stop)</div>
                <div id="demo2" class="demo">00:00:00</div>
            </div>
            <div class="example">
                <div class="label">Click to reset</div>
                <div id="demo3" class="demo">00:00:00</div>
            </div>
            <div class="example">
                <div class="label">Count up from seed time (10000000 milliseconds)</div>
                <div id="demo4" class="demo">00:00:00</div>
            </div>
            <div class="example">
                <div class="label">2 second update interval</div>
                <div id="demo5" class="demo">00:00:00</div>
            </div>
            <div class="example">
                <div class="label">Custom format using <a href="https://github.com/nene/jintervals">jintervals</a></div>
                <div id="demo6" class="demo">00:00:00</div>
            </div>
        </div>
        
        <footer></footer>
    </div>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="../jquery.stopwatch.js"></script>
    <script>
        $(document).ready(function() {
            $('#demo1').stopwatch().stopwatch('start');
            $('#demo2').stopwatch().click(function(){ 
                $(this).stopwatch('toggle');
            });
            $('#demo3').stopwatch().click(function(){ 
                $(this).stopwatch('reset');
            }).stopwatch('start');
            $('#demo4').stopwatch({startTime: 10000000}).stopwatch('start');
            $('#demo5').stopwatch({updateInterval: 2000}).stopwatch('start');
            $('#demo6').stopwatch({format: '{Minutes} and {s.}'}).stopwatch('start');
        });
    </script>
</body>
</html>