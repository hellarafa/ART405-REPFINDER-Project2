<?php 
	$show_modal = true;
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
<h1>TEST</h1>

<script>$(document).ready(function(){$("#pModal").modal("show");});</script>

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
    <script src="../bower_components/scrollreveal/dist/scrollreveal.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  </body>
</html>