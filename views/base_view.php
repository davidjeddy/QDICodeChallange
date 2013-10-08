<?php
/**
*
*/

?>
<DocType html>
<html>
    <head>
        <title>ConMan</title>

        <!-- load app css -->
        <link rel="stylesheet" href="./static/css/reset.css">
        <link rel="stylesheet" href="./vendor/twitter/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./vendor/twitter/bootstrap/dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="./static/css/application.css">
    </head>
    <body>



        <div id="static_header" class="bs-example">

            <div role="navigation" class="navbar navbar-default navbar-static" id="navbar">
                <div class="navbar-header">
                  <h2>Con-Man</h2>
                </div>
                <div class="collapse navbar-collapse bs-js-navbar-scrollspy">
                    <ul class="nav navbar-nav">
                    <li><a href="#a">A</a></li>
                    <li><a href="#b">B</a></li>
                    <li><a href="#c">C</a></li>
                    <li><a href="#d">D</a></li>
                    <li><a href="#e">E</a></li>
                    <li><a href="#f">F</a></li>
                    <li><a href="#g">G</a></li>
                    <li><a href="#h">H</a></li>
                    <li><a href="#i">I</a></li>
                    <li><a href="#j">J</a></li>
                    <li><a href="#k">K</a></li>
                    <li><a href="#l">L</a></li>
                    <li><a href="#m">M</a></li>
                    </ul>
                </div>
            </div>



            <div id="data_container" style="overflow-x:hidden;overflow-y:scroll;height 50%;height: 50%"
                class="scrollspy"
                data-spy="scroll"
                data-target="#navbar"
                data-offset="0"
            >

                <!-- Loop this part -->
	            <div class="bs-example" id="a">
	            	<form>
	                    <input type="text" class="form-control" name="fname" 	value="Add FName" />
	                    <input type="text" class="form-control" name="lname" 	value="LName" />
	                    <input type="text" class="form-control" name="city" 	value="City" />
	                    <input type="text" class="form-control" name="state" 	value="State" />
	                    <input type="text" class="form-control" name="zip" 		value="Zip" />
	                    <button type="button" class="btn btn-success disabled" data-loading-text="Save" >Save</button>    
	                </form>
	            </div>
            </div>



            <div class="add_data_container" class="navbar navbar-default navbar-static">
            	<form>
                    <input type="text" class="form-control" name="fname" 	value="Add FName" />
                    <input type="text" class="form-control" name="lname" 	value="LName" />
                    <input type="text" class="form-control" name="city" 	value="City" />
                    <input type="text" class="form-control" name="state" 	value="State" />
                    <input type="text" class="form-control" name="zip" 		value="Zip" />
                    <button type="button" class="btn btn-primary add" data-loading-text="Add" >Add</button>    
                </form>
            </div>
        </div>




        <script type="text/javascript" src="./vendor/components/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="./vendor/twitter/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="./static/js/application.js"></script>

    </body>
</html>