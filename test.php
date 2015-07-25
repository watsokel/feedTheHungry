<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: text/html; charset=utf-8');
include 'dbpass.php';

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    </head>

  <body>
     <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Feed The Hungry</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.html">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="../navbar/">Default</a></li>
              <li class="active"><a href="./">Static top</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <form style="margin: 0px" accept-charset="UTF-8" action="/sessions" method="post">
                    <!--Citation: http://mimi.kaktusteam.de/blog-posts/2012/02/login-menu-with-twitter-bootstrap/00-->
                    <div style="margin:0; padding:0; display:inline">
                      <input name="utf8" type="hidden" value="&#x2713;" /><input name="authenticity_token" type="hidden" value="4L/A2ZMYkhTD3IiNDMTuB/fhPRvyCNGEsaZocUUpw40=" />
                    </div>
                    <fieldset class='textbox' style="padding:10px">
                      <input style="margin-top: 8px" type="text" placeholder="Username" />
                      <input style="margin-top: 8px" type="password" placeholder="Passsword" />
                      <input class="btn btn-primary" name="commit" type="submit" value="Log In" />
                    </fieldset>
                  </form>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
    
    <div class="container"> 
      <div class="row">
        <div class="col-md-8">
          <h1>Enter your food items</h1>
          <h3>Form</h3> 
          <div id="formContainer">
            <form class="form-horizontal" action="#" method="post" role="form">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="fName">First Name</label>
                <div class="col-sm-9">
                  <input class="form-control" id="fName" type="text" placeholder="First name" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="lName">Last Name</label>
                <div class="col-sm-9">
                  <input class="form-control" id="lName" type="text" placeholder="Last name" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-sm-3 control-label">User Name</label>
                <div class="col-sm-9">
                  <input class="form-control" id="uName" type="text" placeholder="Username" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="passWord1">Password</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="pWord1" placeholder="Password" required>
                  </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="passWord2">Password (re-enter)</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="pWord2" placeholder="Password" required>
                  </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="userType">Role</label>
                <div class="col-sm-9 controls radio">
                  <div class="radio">
                    <input type="radio" name="userType" id="accessPatient" value="Patient" checked="checked">
                    <label class="control-label" for="accessPatient">Patient</label>
                  </div>
                  <div class="radio">
                    <input type="radio" name="userType" id="accessMOA" value="MOA">
                    <label class="control-label" for="accessMOA">Medical Office Assistant (Administrator)</label>
                  </div>  
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="createUser"></label>
                <div class="col-sm-9 controls">
                  <button id="createUser" name="createUser" class="btn btn-primary">Create Account</button>
                  <button id="cancel" name="cancel" class="btn btn-defa">Cancel</button>
                </div>
              </div>
            </form> 
          </div>



        </div>
        <div class="col-md-4">
          <div>
            Some Content
          </div>    
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <h3>Column</h3>
            <p>Some Text</p>
            <p><a href="#" class="btn btn-info">More &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h3>Column</h3>
            <p>Some Text.</p>
            <p><a href="#" class="btn btn-info">More &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h3>Column</h3>
            <p>Some Text.</p>
            <p><a href="#" class="btn btn-info">More &raquo;</a></p>
        </div>
      </div>


      <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
          <p class="navbar-text pull-left">Site Built By Kelvin Watson</p>
          <a class="navbar-btn btn btn-danger pull-right" href="#contact" data-toggle="modal">Need Help?</a>
        </div>
      </div>


      <!--<hr>
      <div class="footer">
      <p>&copy; 2015</p>
      </div>-->
    </div>

  <div class="modal fade" id="contact" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal">
          <div class="modal-header">
            <h4>Contact ClinAssist</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="contact-name" class="col-lg-2 control-label">Name:</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="contact-name" placeholder="Full Name">
              </div>
            </div>
            
            <div class="form-group">
              <label for="contact-email" class="col-lg-2 control-label">Email:</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" id="contact-email" placeholder="you@example.com">
              </div>
            </div>

            <div class="form-group">
              <label for="contact-msg" class="col-lg-2 control-label">Message:</label>
              <div class="col-lg-10">
                <textarea class="form-control" rows="8"></textarea>
              </div>
            </div>
          
          </div>
          <div class="modal-footer">
            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
            <button class="btn btn-primary" type="submit">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script language="javascript">
    $('.dropdown-toggle').dropdown();
    $('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
      });
  </script>    
  </body>
</html>