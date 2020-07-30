<?php

$link = "Settings";

require('../../config/server.php');

$req_query = mysqli_query($db, "SELECT * FROM `meta`");

?>
<!DOCTYPE html>
<html lang="en">
<?php require('../../config/head.php'); ?>

<body>
    <div class="divWrap fade">
        <link rel="stylesheet" type="text/css" media="screen" href="https://13646c.firstmedtrade.com//config/assets/css/settings.css" />
        <?php require('../../config/sidebar.php'); ?>
        <section id="ref">
            <navigation id="navigation">
                <?php require('../../config/nav.php'); ?>
            </navigation>
            <div class="ref mart">
                <div id="body">
                    <div class="bodyLeft">
                        <div class="body">
                            <div id="title">
                                <h1>Meta Data</h1><span>
                                    <hr></span>
                            </div>
                            <form method="post" action="save.php">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Page</th>
                                            <th>Description</th>
                                            <th>Tags</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <a href="new.php" id="add_button">Add more meta</a>
                                        <datalist id="pages">
                                            <option value="Blog">Blog</option>
                                            <option value="Medical Market">Medical Market</option>
                                            <option value="Medical Air Transport">Medical Air Transport</option>
                                            <option value="Find Hospitals">Find Hospitals</option>
                                            <option value="Find Doctors">Find Doctors</option>
                                        </datalist>
                                        <?php
                                            if (mysqli_num_rows($req_query) > 0) {
                                                while ($show_req = mysqli_fetch_array($req_query)) {
                                                    echo '                                            
                                                        <tr class="meta" id="req_body">
                                                            <td class="editableColumns"><input type="hidden" value="' . $show_req['id'] . '" name ="id" readonly/><input list="pages" type="text" value="' . base64_decode($show_req['pages']) . '" name ="page" readonly maxlength="50"/></td>
                                                            <td class="editableColumns"><input type="text" value="' . base64_decode($show_req['description']) . '" name ="description" readonly maxlength="250"/></td>
                                                            <td class="editableColumns"><input type="text" value="' . base64_decode($show_req['tags']) . '" name ="tags" readonly/></td>
                                                            <td class="edit"><a class="edit" href="#">Edit</a></td>
                                                            <td style="display:none;" class="save"></td>
                                                            <td class="delete"><a class="delete" href="delete.php?getid=' . $show_req['id'] . '">Delete</a></td>
                                                        </tr>
                                                    ';
                                                }
                                            } else {
                                                echo '
                                                    <tr id="req_body">
                                                        <td>No data found</td>
                                                    </tr>
                                                ';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="bodyRight">
                        <div class="body">
                            <div id="title">
                                <h1>Change Password</h1><span>
                                    <hr></span>
                            </div>
                            <form method="post" action="">
                                <table>
                                    <thead>
                                        <tr>
                                            <td></td>
                                        </tr>
                                    </thead>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<script>
    //------------------------------------------------------------------------------------
    $(document).ready(function() {
        $('.view').click(function(e) {
            var link = $(this).attr("href");
            $.ajax({
                url: link,
                type: 'GET',
                success: function(response) {
                    $('.bodyLeft').html(response);
                }
            });
            return false;
        });
        //------------------------------------------------------------------------------------
        $('a.edit').one("click", function () {
            $(this).parents('tr').find('td.editableColumns').each(function() {
                var html = $(this).html();
                var input = $(this).find('input');
                input.removeAttr("readonly");
            });
            $(this).parents('tr').find('td.delete').html('<a href="./">Cancel</a>');
            $(this).parents('tr').find('td.save').html('<button>Save</button>');
            $(this).parents('tr').find('td.save').css({"display":"table-cell", "padding":"0px 10px"});
        });
        //----------------------------------------------------------------------------------------------------------
    });
</script>


</html>