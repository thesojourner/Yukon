
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Yukon</title>

    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="main.css" rel="stylesheet">

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Yukon</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="games.php">Games</a></li>
          </ul>
          <form class="navbar-form navbar-right" role="form">
            <button type="submit" class="btn btn-success">Sign Out</button>
            <div class="form-group">
              <a class="username" href="profile.php">JTN614</a>
            </div>
            <i class="navglyph glyphicon glyphicon-cog whitetext"></i>
          </form>
        </div>
      </div> <!-- Container -->
    </div>

    <div class="content container">
        <div class="row">
            <div class="sidebar col-md-4">
                <h3>Your Statistics</h3>
                <p><b>Games Won:</b> 50</p>
                <p><b>Games Lost:</b> 50</p>
                <p><b>Win Ratio:</b> 50%</p>
                <p><b>Souls Crushed:</b> 5</p>
                <p><b>Problems:</b> 99</p>
            </div>
            <div class="maindiv col-md-8">
                <h3 class="whitetext">Your Profile</h3>
                <img class="profilepic" src="img/defaultprofile.png">
                <h3 class="whitetext">JTN614</h3>
                <p class="whitetext"><b>Bio:</b> I am a white middle class person from the midwest of the United States of America. I like guitars, electronic music, the bible, and other stereotypical things. I am validated by my statistics on meaningless games. Please love me, I'm very alone.</p>
            </div>
        </div>
    </div> <!-- Container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
