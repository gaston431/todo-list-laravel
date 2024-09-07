<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/font-awesome/all.min.css" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>The Awesome Todo App</title>
</head>

<body>
    <div id="root"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div id="items">
                    <form method="post" class="">
                        @csrf
                        <div class="mb-3 input-group"><input id="name" placeholder="New Item" aria-describedby="basic-addon1" name="name" type="text" class="form-control" value="">
                            <div class="input-group-append"><button id="submit" type="submit" class="btn btn-success" disabled>Add</button></div>
                        </div>
                    </form>
                    <!-- <div class="item false container-fluid">
                        <div class="row">
                            <div class="text-center col-1"><button aria-label="Mark item as complete" type="button" class="toggles btn btn-link btn-sm"><i class="far fa-square"></i></button></div>
                            <div class="name col-10">asdasd</div>
                            <div class="text-center remove col-1"><button aria-label="Remove Item" type="button" class="btn btn-link btn-sm"><i class="fa fa-trash text-danger"></i></button></div>
                        </div>
                    </div>
                    <div class="item completed container-fluid">
                        <div class="row">
                            <div class="text-center col-1"><button aria-label="Mark item as incomplete" type="button" class="toggles btn btn-link btn-sm"><i class="far fa-check-square"></i></button></div>
                            <div class="name col-10">wqewqt</div>
                            <div class="text-center remove col-1"><button aria-label="Remove Item" type="button" class="btn btn-link btn-sm"><i class="fa fa-trash text-danger"></i></button></div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('input').keyup(function() {
                if ($(this).val() == '')
                    $('#submit').attr('disabled', true)
                else
                    $('#submit').removeAttr('disabled')
            })

            //get
            $.ajax({
                url: "/items",
                method: "GET",
                //data: $(this).serialize(),
            }).done(function(response) {
                //console.log(response)
                items = response
                //let items = JSON.parse(response)

                for (let i = 0; i < items.length; i++) {
                    const item = response[i];

                    //console.log(items[i])
                    let completed = items[i].completed ? 'completed' : 'false'
                    let square = items[i].completed ? 'fa-check-square' : 'fa-square'

                    $('#items').append(
                        '<div class="item ' + completed + ' container-fluid">' +
                        '<div class="row">' +
                        '<div class="text-center col-1"><button data-id="' + items[i].id + '" aria-label="Mark item as complete" type="button" class="toggles btn btn-link btn-sm"><i class="far ' + square + '"></i></button></div>' +
                        '<div class="name col-10">' + items[i].name + '</div>' +
                        '<div class="text-center col-1"><button data-id="' + items[i].id + '" aria-label="Remove Item" type="button" class="remove btn btn-link btn-sm"><i class="fa fa-trash text-danger"></i></button></div>' +
                        '</div>' +
                        '</div>'
                    )
                }
            })

            //store
            $('form').submit(function(event) {
                event.preventDefault()

                $.ajax({
                    url: "/items",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $('#name').val()
                    },
                }).done(function(response) {
                    console.log(response)
                    let item_id = response.id
                    //let item_id = JSON.parse(response)
                    
                    $('#items').append(
                        '<div class="item false container-fluid">' +
                        '<div class="row">' +
                        '<div class="text-center col-1"><button data-id="' + item_id + '" response aria-label="Mark item as complete" type="button" class="toggles btn btn-link btn-sm"><i class="far fa-square"></i></button></div>' +
                        '<div class="name col-10">' + $("#name").val() + '</div>' +
                        '<div class="text-center col-1"><button data-id="' + item_id + '" aria-label="Remove Item" type="button" class="remove btn btn-link btn-sm"><i class="fa fa-trash text-danger"></i></button></div>' +
                        '</div>' +
                        '</div>'
                    )

                    $('#name').val('')    
                })
            })


            //update
            $(document).on('click', '.toggles', function() {

                let item_id = $(this).data('id')
                const button = $(this)
                const div = $(this).parent().parent().parent()
                let completed = Number(!div.hasClass('completed'))

                $.ajax({
                    url: "/items/" + item_id,
                    method: "PATCH",
                    //dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        // item_id: item_id,
                        completed: completed,
                        //_method: "PATCH"
                    },
                }).done(function(response) {
                    console.log(response)

                    div.toggleClass('completed')
                    if (button.children(0).hasClass('fa-square')) {
                        button.children(0).removeClass('fa-square')
                        button.children(0).addClass('fa-check-square')
                    } else {
                        button.children(0).removeClass('fa-check-square')
                        button.children(0).addClass('fa-square')
                    }
                })
            })

            //delete
            $(document).on('click', '.remove', function() {

                let item_id = $(this).data('id')
                const div = $(this).parent().parent().parent()

                $.ajax({
                    url: "/items/" + item_id,
                    method: "DELETE",
                    //dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        // item_id: item_id,
                        //_method: "DELETE"
                    },
                }).done(function(response) {
                    console.log(response)
                    div.remove()
                })
            })

        })
    </script>
</body>

</html>