<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="jquery.min.js"></script>
    <script src="jquery-ui.js"></script>

    <title>Crud Ajax</title>
</head>

<body>
    <h4>Crud Php , Ajax</h4>
    <div class="container">
        <div id="user_data"></div>
        <div align="right" style="margin-bottom:5px;">
            <button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
        </div>
        <!-- <button class="btn btn-info" name="add" id="add">Add</button> -->
    </div>

    <div id="user_dialog" title="Add Data">
        <form method="post" id="user_form">
            <div class="form-group">
                <label>Enter First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" />
                <span id="error_first_name" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label>Enter Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" />
                <span id="error_last_name" class="text-danger"></span>
            </div>


            <div class="form-group">
                <input type="hidden" name="action" id="action" value="insert" />
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
            </div>
        </form>
    </div>

    <div id="action_alert" title="Action"></div>

    <div id="delete_confiramtion" title="Delete">
        <p>Are you sure you want to Delete this Data !?</p>
    </div>

    <script>
        $(document).ready(function() {
            load_data();

            function load_data() {
                $.ajax({
                    url: "fetch.php",
                    method: "POST",
                    success: function(data) {
                        $('#user_data').html(data);
                    }
                });
            };

            $("#user_dialog").dialog({
                autoOpen: false,
                width: 400,

            });
            $('#add').click(function() {
                $('#user_dialog').attr('title', 'Add Data');
                $('#action').val('insert');
                $('#form_action').val('Insert');
                $('#user_form')[0].reset();
                $('#form_action').attr('disabled', false);
                $("#user_dialog").dialog('open');
            });

            $('#user_form').on('submit', function(event) {
                event.preventDefault();

                var error_first_name = '';
                var error_last_name = '';

                if ($('#first_name').val() == '') {
                    error_first_name = 'Frist Name is required';
                    $('#error_first_name').text(error_first_name);
                    $('#first_name').css('border-color', '#cc0000');

                } else {
                    error_first_name = '';
                    $('#error_first_name').text(error_first_name);
                    $('#first_name').css('border-color', '');
                }
                if ($('#last_name').val() == '') {
                    error_last_name = 'Last Name is required';
                    $('#error_last_name').text(error_last_name);
                    $('#last_name').css('border-color', '#cc0000');

                } else {
                    error_last_name = '';
                    $('#error_last_name').text(error_last_name);
                    $('#last_name').css('border-color', '');
                }

                if (error_first_name != '' || error_last_name != '') {
                    return false;

                } else {
                    $('#form_action').attr('disabled', 'disabled');
                    var form_data = $(this).serialize();
                    $.ajax({
                        url: "action.php",
                        method: "POST",
                        data: form_data,
                        success: function(data) {
                            $('#user_dialog').dialog('close');
                            $('#action_alert').html(data);
                            $('#action_alert').dialog('open');
                            load_data();
                            $('#form_action').attr('disabled', false);

                        }
                    })
                }
            });
            $('#action_alert').dialog({
                autoOpen: false,
            });

            $(document).on('click', '.edit', function() {
                var id = $(this).attr("id");
                var action = 'fetch_single';
                $.ajax({
                    url: 'action.php',
                    method: 'POST',
                    data: {
                        id: id,
                        action: action
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#first_name').val(data.first_name);
                        $('#last_name').val(data.last_name);
                        $('#user_dialog').attr('title', 'Edit Date');
                        $('#action').val('update');
                        $('#hidden_id').val(id);
                        $('#form_action').val('Update');
                        $('#user_dialog').dialog('open');

                    }
                });

            });



            $('#delete_confiramtion').dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Ok: function() {
                        var id = $(this).data('id');
                        var action = 'delete';
                        $.ajax({
                            url: "action.php",
                            method: "POST",
                            data: {
                                id: id,
                                action: action
                            },
                            success: function(data) {
                                $('#delete_confiramtion').dialog('close');
                                $('#action_alert').html(data);
                                $('#action_alert').dialog('open');
                                load_data();
                            }
                        });
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                    }
                }
            });
            $(document).on('click', '.delete', function() {
                var id = $(this).attr("id");
                $('#delete_confiramtion').data('id', id).dialog('open');


            });
        });
    </script>
</body>

</html>