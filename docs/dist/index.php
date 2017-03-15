<?php 
    $show_modal = false;
    //debug stuff
    //ini_set('display_errors', 'On');
    //error_reporting(E_ALL | E_STRICT);
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,600" rel="stylesheet">     
    <script src="https://use.fontawesome.com/7ef7608cc6.js"></script>

  </head>
  <body>
  <nav class="navbar navbar-toggleable-md navbar-light navbar-inverse bg-blue" id="top">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand mb-0" href="index.php">Repfinder</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#search">Search</a>
        </li>
      </ul>
    </div>
  </nav>
<div class="jumbotron jumbotron-fluid">
  <div class="container text-center">
    <h1 class="display-3 ">Welcome to Repfinder.</h1>
    <p class="lead">Have you ever sent a letter to your senator? What about your state legislators or even the mayor of your town? Their contact information is scattered throughout the web on various official and unofficial websites. Our website helps you find all the government representatives for an address. Stay informed.</p>
  </div>
</div>

<section id="search">
  <div class="container-fluid bg-blue bigger-box">
    <div class="row">
      <div class="col-lg-4 offset-lg-2 text-center">
        <h1 class="display-4">Enter your Address: </h1>
      </div>
      <div class="col-lg-4 text-center align-middle">

        <form action="" class="form-signin" method="post">
            <!-- <div class="group">
              <input type="text" id="searchaddress" name="searchaddress" value="<?php echo $searchaddress; ?>">
              <button class="btn btn-primary">Search</button>   
              <span class="highlight"></span>
              <span class="bar"></span> -->
            <input type="hidden" value="checked" name="firsttime">
            <input type="text" id="searchaddress" name="searchaddress">
            <button class="btn btn-primary">Search</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php
  if(isset($_POST['searchaddress'])){
    $searchaddress = $_POST['searchaddress']; 
    $searchaddress_final = str_replace(' ', '%20', $searchaddress);
  }
  $data = json_decode(file_get_contents('https://www.googleapis.com/civicinfo/v2/representatives?key=AIzaSyA2oUu1o-zH4MvJkIrxZ1-imss5gH_P_cI&address='.$searchaddress_final));  

  //modal trigger
  if (isset($_POST['firsttime'])){
    $check = count($data);
    if ($check == 0) {
      $show_modal = true;
    }  
  }

  $jobs = [];
  // loop through each office 
  foreach ($data->offices as $office) {
    // loop through each officialIndices array
    if (isset($office->officialIndices)) {
      foreach ($office->officialIndices as $officialIndices) {
        $jobs += [ $officialIndices => $office->name];
      }
    }
  }
  $i = 0;
  echo '<div class="bg-grey container-fluid">';
  $list = count($jobs);//list counts how many results came back from Google
    if($list>0){
      echo '<br><h2 class="text-center display-3">This is who represents you:</h2><br>';
      echo '<div class="container">';
      echo '<div class="card-columns ">';
    } else {
      echo '<div class="container">';
      echo '<div class="card-columns">';
    }

  foreach ($data->officials as $person) {
    //create card 
    echo '<div class="card text-center reveal-1">';  
    //photo
    echo '<div class="card-header">'.(isset($person->party)? $person->party :'Not Listed').'</div>';
    echo '<img class="img-fluid card-img-top" src="'.(isset($person->photoUrl)? $person->photoUrl : 'http://placehold.it/360x250?text=Not+Available').'">';
    //name
    echo '<div class="card-block">';
    echo '<h4 class="card-title">'.$person->name.'</h4>';
    //role
    echo '<h6 class="card-subtitle mb-2 text-muted">'.$jobs[$i].'</h6></div>';
    echo '<ul class="list-group list-group-flush">';
    //address
    echo '<li class="list-group-item text-left">Address: '.(isset($person->address[0]->line1)? $person->address[0]->line1 :'Not Listed').'
    <br>City: '.(isset($person->address[0]->city)? $person->address[0]->city :'Not Listed').'
    <br>State: '.(isset($person->address[0]->state)? $person->address[0]->state :'Not Listed').'
    <br>Zip: '.(isset($person->address[0]->zip)? $person->address[0]->zip :'Not Listed').'</li>';
    //phone number
    echo '<li class="list-group-item"><i class="fa fa-phone" aria-hidden="true"></i>
&nbsp;Phone: '.(isset($person->phones[0])? $person->phones[0] :'Not Listed').'</li>';
    //email, if any
    echo ''.(isset($person->emails[0])? '<li class="list-group-item"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Email: <a href="mailto:'.$person->emails[0].'">'.$person->emails[0].'</a></li>' :'').'';
    //social media
    get_social($person);
    echo '</ul>';
    //website
    echo '<div class="card-block">';
    echo '<a href="'.$person->urls[0].'" class="card-link">Website</a></div>';
    echo '</div>';
    $i++;
  }
  function get_social($person){
    foreach ($person->channels as $media){
      //echo $media->type;
      if ($media->type == "Facebook"){
        echo '<li class="list-group-item text-center"><a href="http://www.facebook.com/'.$media->id.'"><i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;'.$media->id.'</a></li>';
      }
      elseif ($media->type == "Twitter"){
        echo '<li class="list-group-item"><a href="http://www.twitter.com/'.$media->id.'"><i class="fa fa-twitter" aria-hidden="true"></i>&nbsp;'.$media->id.'</a></li>';
      }
      elseif ($media->type == "YouTube"){
        echo '<li class="list-group-item"><a href="http://www.youtube.com/'.$media->id.'"><i class="fa fa-youtube" aria-hidden="true"></i>&nbsp;'.$media->id.'</a></li>';
      }
      elseif ($media->type == "GooglePlus"){
        echo '<li class="list-group-item"><a href="http://plus.google.com/'.$media->id.'"><i class="fa fa-google-plus" aria-hidden="true"></i>&nbsp;'.$media->id.'</a></li>';
      }
      else {
        //no-media
      }
    }
  }
?>
    </div> <!--close card-columns-->
  </div> <!--close container-->
</div> <!--close color-container-->


<footer class="bd-footer text-muted text-center">
  <div class="container">
      <p>Made by Rafa &hearts; Built with the <a href="https://developers.google.com/civic-information/" target="_blank">Google Civic Information API</a>.
      </p>
  </div> <!--close container-->
</footer> <!--close footer-->

<?php if($show_modal):?>
<script>$(document).ready(function(){$("#pModal").modal("show");});</script>
<?php endif;?>

<div class="modal fade" id="pModal" tabindex="-1" role="dialog" aria-labelledby="pModalLabel">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header alert-warning">
          <h4 class="modal-title" id="pModalLabel">Error: Wrong Address</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
      </div>
  </div>
</div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="js/bootstrap.min.js"></script> 
    <!--script src="../bower_components/scrollreveal/dist/scrollreveal.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
  </body>
</html>