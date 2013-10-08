<?php
/**
* User interface of the application. Once loaded never reload.
* Calls to the Ctrl should be RESTful using the CRUD pattern
*/

class baseView
{
    //TODO move this to the controller/settings. Leave open to internationalize
    var $alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');


    public function  getAlphabet() {
        return $this->alphabet;
    }

    public function setAlphabet($data) {
        $this->alphabet = $data;
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
                          <h2>Con-Man</h2>
                        </div>
                        <div class="collapse navbar-collapse bs-js-navbar-scrollspy">
                            <ul class="nav navbar-nav">
                                <?php foreach ($this->alphabet as $letter) { ?>
                                    <li><a href="#<?= $letter; ?>"><?= $letter; ?></a></li>
                                <?php } ?>
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
                        <?php foreach ($this->alphabet as $letter) { ?>
                        <div class="bs-example" id="<?= $letter; ?>">
                            <form action="patch">
                                <input type="text" class="form-control" name="fname"    value="<?= $letter; ?> Add FName" />
                                <input type="text" class="form-control" name="lname"    value="LName" />
                                <input type="text" class="form-control" name="city"     value="City" />
                                <input type="text" class="form-control" name="state"    value="State" />
                                <input type="text" class="form-control" name="zip"      value="Zip" />
                                <button type="button" class="btn btn-success disabled update_data_button" data-loading-text="Update" >Update</button>
                            </form>
                        </div>
                        <?php } ?>
                    </div>



                    <div class="add_data_container" class="navbar navbar-default navbar-static">
                        <form action="post">
                            <input type="text" class="form-control" name="fname"    value="Add FName" />
                            <input type="text" class="form-control" name="lname"    value="LName" />
                            <input type="text" class="form-control" name="city"     value="City" />
                            <input type="text" class="form-control" name="state"    value="State" />
                            <input type="text" class="form-control" name="zip"      value="Zip" />
                            <button type="button" class="btn btn-primary create_data_button" data-loading-text="Create" >Create</button>
                        </form>
                    </div>
                </div>




                <script type="text/javascript" src="./vendor/components/jquery/jquery.min.js"></script>
                <script type="text/javascript" src="./vendor/twitter/bootstrap/dist/js/bootstrap.min.js"></script>
                <script src="./static/js/application.js"></script>

            </body>
        </html>
        <?php
    }
}

$baseView = new baseView();
