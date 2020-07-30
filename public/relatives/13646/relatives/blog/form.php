<?php
require('../../config/server.php');
$date = date('Y-m-d H:i:s');

$create = mysqli_query($db, "INSERT INTO `blog`(`new`, `published`, `date_created`) VALUES ('1', '0', '" . $date . "') ");
$getdata = mysqli_query($db, "SELECT `id` FROM `blog` WHERE `published`='0' AND `new`='1' ORDER BY `updates` DESC LIMIT 1 ");
$getdata = mysqli_fetch_assoc($getdata);

if ($create) {
?>
    <div id="fdm">
        <link rel="stylesheet" type="text/css" media="screen" href="https://13646c.firstmedtrade.com//config/assets/css/blog.css" />
        <div class="fdm_holder">
            <a href="../blog" id="back">
                <p>Back</p>
            </a>
            <div class="form-group autosave mdide">
                <p id="autoSave"></p>
            </div>
            <form novalidate id="createTicle" method="POST" action="./add.php" enctype="multipart/form-data">
                <fieldset>
                    <div id="title">
                        <h2>Create new article</h2>
                        <span>
                            <hr></span>
                    </div>
                    <p>Fields marked with * are required!</p>
                    <div class="form-group">
                        <textarea name="title" placeholder="Title *" required></textarea>
                    </div>
                    <div class="form-group">
                        <div id="img">
                            <label for="ticleImage">Choose article Image *</label>
                            <img id="output" alt="Image preview" />
                            <input type="file" name="ticleImage" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="subtitle" placeholder="Subtitle *" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="toolbar">
                            <ul class="tool-list">
                                <li class="tool">
                                    <button type="button" data-command='justifyLeft' class="tool--btn">
                                        <i class="mdi mdi-format-align-left"></i>
                                    </button>
                                </li>
                                <li class="tool">
                                    <button type="button" data-command='justifyCenter' class="tool--btn">
                                        <i class="mdi mdi-format-align-center"></i>
                                    </button>
                                </li>
                                <li class="tool">
                                    <button type="button" data-command="bold" class="tool--btn">
                                        <i class="mdi mdi-format-bold"></i>
                                    </button>
                                </li>
                                <li class="tool">
                                    <button type="button" data-command="italic" class="tool--btn">
                                        <i class="mdi mdi-format-italic"></i>
                                    </button>
                                </li>
                                <li class="tool">
                                    <button type="button" data-command="underline" class="tool--btn">
                                        <i class="mdi mdi-format-underline"></i>
                                    </button>
                                </li>
                                <li class="tool">
                                    <button type="button" data-command="insertOrderedList" class="tool--btn">
                                        <i class="mdi mdi-format-list-numbered"></i>
                                    </button>
                                </li>
                                <li class="tool">
                                    <button type="button" data-command="insertUnorderedList" class="tool--btn">
                                        <i class="mdi mdi-format-list-bulleted"></i>
                                    </button>
                                </li>
                                <li class="tool">
                                    <button type="button" data-command="createlink" class="tool--btn">
                                        <i class="mdi mdi-link-plus"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div id="textoutput" name="textoutput" contenteditable="true"></div>
                    </div>
                </fieldset>
                <fieldset>
                    <div id="title">
                        <h2>Author information</h2>
                        <span>
                            <hr></span>
                    </div>
                    <div class="form-group">
                        <input type="text" name="author" placeholder="Author's name *" value="" minlength="5" maxlength="50" required />
                    </div>
                    <div class="form-group">
                        <input type="text" name="tags1" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags2" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags3" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags4" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags5" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags6" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags7" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags8" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags9" id="tags" placeholder="Enter article tags" value="" required />
                        <input type="text" name="tags10" id="tags" placeholder="Enter article tags" value="" required />
                    </div>
                </fieldset>
                <div class="form-group error-hold mdider" style="border-top: none; padding: 0px;">
                    <p id="r-error"></p>
                    <p id="r-success"></p>
                </div>
                <div class="form_bottm">
                    <div class="form-group">
                        <a class="pub" href="./publish.php/?id=<?php echo $getdata['id'] ?>&&pub='true'"><button type="button" name="publish">Publish<i class="mdi mdi-arrow-right"></i></button></a>
                    </div>
                </div>
            </form>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="https://639.firstmedtrade.com/public/13646/config/assets/js/jquery-3.2.1.min.js"></script>
            <script>
                $(document).ready(function() {
                    //--------------------------------------------------------------------------------------
                    let output = document.getElementById('textoutput');
                    let buttons = document.getElementsByClassName('tool--btn');
                    for (let btn of buttons) {
                        btn.addEventListener('click', () => {
                            let cmd = btn.dataset['command'];
                            if (cmd === 'createlink') {
                                let url = prompt("Enter the link here: ", "http:\/\/");
                                document.execCommand(cmd, false, url);
                            } else {
                                document.execCommand(cmd, false, null);
                            }
                        })
                    }
                    //--------------------------------------------------------------------------------------
                    $('#createTicle').on('keyup change paste', function(e) {
                        var form = $('#createTicle')[0]; // You need to use standard javascript object here
                        var data = new FormData(form);
                        data.append('content', $('#textoutput').html())
                        $.ajax({
                            url: './add.php',
                            type: "POST",
                            data: data,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(response) {
                                if (response == 'added!') {
                                    $('#autoSave').text("Saving draft...");
                                    setInterval(function() {
                                        $('#autoSave').text('');
                                    }, 12500);
                                } else {
                                    $('#r-error').html(response);
                                }
                            }

                        });
                    })
                    //--------------------------------------------------------------------------------------
                    $(".pub").on('click', function(e) {
                        var link = $(this).attr("href");
                        $.ajax({
                            url: link,
                            type: 'GET',
                            success: function(response) {
                                if (response == 'Published!') {
                                    alert('Success!! Your article has been published!');
                                    window.location.replace("../blog/");
                                } else {
                                    $('#r-error').html(response);
                                }
                            }
                        })
                        return mdilse;
                    });
                });
            </script>
        </div>
    </div>
<?php

} else {
    echo '<h3 id="info">OOPS! we couldn\'t create a new article at this time, please try again!!</h3>';
}


?>