<?php
/**
* User interface of the application. Once loaded never reload.
* Calls to the Ctrl should be RESTful using the CRUD pattern
*/

class baseView
{
    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $data;
    }


    public function __construct() {
        $this->renderView();
    }

    private function renderView() { ?>
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
                          <h2 style="display: inline;">Con-Man</h2>
                          <h3>A simple(ish) Contact Manager</h3>
                        </div>

                    </div>



                    <div id="data_container" style="overflow-x:hidden;overflow-y:scroll;height 50%;height: 50%"
                        class="scrollspy"
                        data-spy="scroll"
                        data-target="#navbar"
                        data-offset="0"
                    ></div>



                    <div class="add_data_container avbar navbar-default navbar-static">
                        <form id="create_form">
                            <input type="text" class="form-control" name="fname" maxlength="32" value="First Name" />
                            <input type="text" class="form-control" name="lname" maxlength="32" value="Last Name" />
                            <input type="text" class="form-control" name="city"  maxlength="32" value="City" disabled/>
                            <input type="text" class="form-control" name="state" maxlength="2"  value="State" disabled />
                            <input type="text" class="form-control" name="zip"   maxlength="5"  value="Zip" />
                            <button type="button" class="btn btn-primary create_data_button disabled" data-loading-text="Create" >Create</button>
                        </form>
                    </div>
                </div>

                <!-- msg container -->
                <div id="flash_msg" class="navbar navbar-default navbar-static"></div>



                <script type="text/javascript" src="./vendor/components/jquery/jquery.min.js"></script>
                <script type="text/javascript" src="./vendor/twitter/bootstrap/dist/js/bootstrap.min.js"></script>
                <script src="./static/js/application.js"></script>

            </body>
        </html>
        <?php
    }
}
