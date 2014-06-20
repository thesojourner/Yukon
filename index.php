
<?php

require "scripts/connect.php";

//initialize variables
$name = $pass = "";

//check for the POST request, get login info
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = test_input($_POST["name"]);
	$pass = md5(test_input($_POST["pass"])); //passwords should be md5-hashed when stored
    //check user and pass in database
	$result = mysqli_query($con, "SELECT * FROM Users WHERE Name='$name' and Pass='$pass'");
    //should have exactly one row if successful
	if (mysqli_num_rows($result) == 1) {
        //set login info as session variables (persistent, client-side)
		$_SESSION['name'] = $name;
        //redirect to main page
		header('Location: scripts/main.php');
	} else {
		echo "Wrong Username or Password";
	}
}

//prevent injection
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

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
            <li class="active"><a href="#">Home</a></li>
            <li><a href="games.php">Games</a></li>
          </ul>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	   <input type="text" name="name" placeholder="username"><br>
	   <input type="password" name="pass" placeholder="password"><br>
	   <input type="submit" value="Login">
	</form>
        </div>
      </div> <!-- Container -->
    </div>

    <div class="content container">
        <div class="row">
            <div class="sidebar col-md-4">
                <h3>Users Online</h3>
                <div class="users">
                    <p><img style="margin-bottom: 5px; margin-right: 5px;" src="img/greendot.png">Bloodbath And Beyond</p>
                    <p><img style="margin-bottom: 5px; margin-right: 5px;" src="img/greendot.png">Ranger Rick</p>
                    <p><img style="margin-bottom: 5px; margin-right: 5px;" src="img/greendot.png">RCC Slayer</p>
                    <p><img style="margin-bottom: 5px; margin-right: 5px;" src="img/greendot.png">theBrockEllis</p>
                    <p><img style="margin-bottom: 5px; margin-right: 5px;" src="img/greendot.png">sojourner</p>
                    <p><img style="margin-bottom: 5px; margin-right: 5px;" src="img/greendot.png">Cay</p>
                    <p><img style="margin-bottom: 5px; margin-right: 5px;" src="img/greendot.png">Victorious Secret</p>
                    <p><img style="margin-bottom: 5px; margin-right: 5px;" src="img/greendot.png">Gandalf</p>
                </div>
            </div>
            <div class="maindiv col-md-8">
                <h3 class="whitetext">It's Like Landgrab... But Better!</h3>
                <p class="whitetext">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vehicula sapien eu magna consequat, non convallis diam lacinia. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras commodo venenatis sagittis. Ut nec pulvinar urna, ac rutrum quam. Etiam luctus fringilla vehicula. Fusce non mauris interdum metus rhoncus sagittis nec sed lectus. Etiam eros diam, mattis vitae enim vel, malesuada consectetur ipsum.
                </p>
                <img style="width: 100%; padding: 10px;" src="img/filler.gif">
                <p class="whitetext">
                  Fusce eget turpis eros. Aliquam venenatis dictum justo eu ultricies. Praesent malesuada orci non tortor sollicitudin, ac consectetur felis sagittis. Ut dui felis, eleifend ut convallis et, euismod a elit. Sed sit amet ultricies orci. Aliquam ac vestibulum nunc, eu semper urna. Nunc tristique et eros eget malesuada. Nulla non dapibus libero. Nam accumsan laoreet turpis, ut tristique sem hendrerit in. Ut accumsan ac tellus vitae faucibus. Vestibulum dignissim mollis est nec gravida. Vestibulum eros urna, malesuada sit amet orci adipiscing, sagittis aliquam ipsum. In in dui aliquet, elementum lectus eget, euismod arcu.
                </p>
                <p class="whitetext">
                  Nunc metus erat, dignissim vitae gravida ut, volutpat a tortor. Etiam tempor, dolor eget ultricies sollicitudin, ipsum nisl adipiscing eros, ac fermentum ligula dui vitae diam. Sed porta sit amet tortor sit amet varius. Vestibulum eget erat tempor, consequat magna ut, facilisis mauris. Sed sem felis, pharetra pulvinar fringilla id, faucibus id magna. Donec lacinia arcu orci, vel malesuada risus ullamcorper vitae. Vivamus ut ligula sit amet orci semper malesuada. Morbi condimentum leo sit amet sapien malesuada ultrices commodo nec libero. Proin in lectus et eros semper sollicitudin. Nam semper elementum purus in porttitor. Nunc convallis fringilla turpis. Integer fermentum pharetra nisi in pulvinar. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean rhoncus dui nec dignissim imperdiet. Integer aliquam elit eu quam feugiat auctor.
                </p>
                <p class="whitetext">
                  Etiam iaculis, diam ac luctus adipiscing, mauris quam iaculis nibh, a tempus nisl lorem a arcu. Quisque sodales sollicitudin libero, ut volutpat lacus congue eu. Donec varius id augue ac vehicula. Morbi in consequat nulla, a dapibus nunc. Vestibulum id arcu vel mi mattis vehicula. Proin pharetra leo metus. Maecenas rutrum fringilla tortor. Morbi suscipit eu elit eget rutrum. Cras vel ligula sem. Aliquam viverra quam non ipsum tempus elementum. Curabitur sem justo, sagittis a tellus at, rutrum scelerisque erat. Ut viverra sollicitudin erat ultricies varius. Nam nec odio lectus. Donec eleifend quam nunc, vel vehicula nulla tempor in. Donec volutpat tortor ante, sit amet lacinia felis faucibus eu. Proin nec fermentum turpis.
                </p>
                <p class="whitetext">
                  Sed rutrum faucibus tortor. Quisque pellentesque hendrerit orci vel ornare. Nulla vel rhoncus lacus. Praesent sit amet lorem sit amet elit euismod vehicula sit amet et nisi. Aliquam eu tincidunt leo. Etiam ac nisl eu enim varius scelerisque. Vivamus faucibus accumsan ante, malesuada molestie risus aliquam id. Aliquam sit amet porta orci, vitae euismod metus. Ut egestas pulvinar pulvinar. Praesent ut rhoncus urna. Nam sed venenatis orci. Morbi fermentum, leo tempor commodo varius, sem enim congue nibh, sit amet placerat magna erat nec quam. Proin facilisis leo nisi, vitae pulvinar ante rhoncus eu. Quisque in libero sed est scelerisque consequat a a metus. Etiam pharetra fermentum lacus.
                </p>
                <p class="whitetext">
                  Praesent ut sapien tristique, pretium lacus id, interdum lorem. Nunc eu diam purus. Quisque euismod pellentesque felis ut dignissim. Fusce ornare fringilla mauris, eget condimentum velit. Vivamus id volutpat orci. Nullam ut iaculis nisi. Mauris faucibus nec nunc sit amet lacinia. Morbi pretium nibh sed sapien consectetur luctus. Donec lobortis urna erat, a vulputate libero fermentum id. In molestie commodo sollicitudin. Curabitur gravida convallis lacinia. Nulla semper tellus nunc, pulvinar tincidunt justo accumsan at. Suspendisse leo enim, tristique id malesuada ut, pretium ut nunc. Phasellus tempor urna ut libero aliquet, tincidunt lacinia magna bibendum. Duis gravida metus eu quam auctor sagittis. Ut ut blandit mi, quis faucibus lorem.
                </p>
                <p class="whitetext">
                  Praesent cursus nec risus a aliquam. Curabitur cursus vehicula dolor, eget accumsan massa volutpat sed. Suspendisse gravida elementum sem, at mollis arcu fringilla vel. Aliquam auctor dui eget tempor elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent augue lacus, porta nec orci vitae, interdum cursus velit. Nunc pulvinar nunc ut metus faucibus, ultricies imperdiet erat condimentum. Etiam pretium eget nibh et viverra. Suspendisse eget tortor felis.
                </p>
                <p class="whitetext">
                  
                </p>
            </div>
        </div>
    </div> <!-- Container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
