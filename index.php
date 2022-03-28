<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MYSQL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css"/>
</head>
<body>
    
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">ITEH2021/2022</a>
</nav>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="text-center text-danger font-weight-normal my-3">PHP MySQL AJAX BOOTSTRAP - PRVI DOMACI </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h4 class="mt-2 text-proimary"></h4>
        </div>
        <div class="col-lg-6">
            <button type="button" class="btn btn-dark m-1 float-right" data-toggle="modal" data-target="#addModal">
                Novi Korisnik
            </button>
           
        </div>
    </div>
    <hr class="my-1">   

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" id="showUser">

            </div>
        </div>
    </div>

</div>



<!-- Add New User Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Dodaj novog korisnika</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form action="" method="post" id="form-data">
                <div class="form-group">
                    <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                </div>

                <div class="form-group">
                    <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                </div>

                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="E-Mail" required>
                </div>

                <div class="form-group">
                    <input type="text" name="car" class="form-control" placeholder="Car" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="insert" id="insert" value="Add user" class="btn btn-danger btn-block">
                </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>



  <!-- Edit User Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Izmeni korisnika</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form action="" method="post" id="edit-form-data">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <input type="text" name="fname" class="form-control" id="fname" required>
                </div>

                <div class="form-group">
                    <input type="text" name="lname" class="form-control" id="lname"  required>
                </div>

                <div class="form-group">
                    <input type="text" name="email" class="form-control" id="email" required>
                </div>

                <div class="form-group">
                    <input type="text" name="car" class="form-control" id="car" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="update" id="update" value="Update user" class="btn btn-primary btn-block">
                </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>




<!-- jQuery library -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>



<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script type="text/javascript">
    $(document).ready(function(){
        

        showAllUsers();

        function showAllUsers(){
            $.ajax({
                url: "action.php",
                type:"POST",
                data:{action:"view"},
                success:function(response){
                    //console.log(response);
                    $("#showUser").html(response);
                    $("table").DataTable({
                        order:[0,'desc']
                    });
                }
            });
        }

        $("#insert").click(function(e){
            if($("#form-data")[0].checkValidity()){
                e.preventDefault();
                $.ajax({
                    url:"action.php",
                    type:"POST",
                    data: $("#form-data").serialize() + "&action=insert",
                    success:function(response){
                        Swal.fire({
                            title: 'Uspesno dodat korisnik!',
                            type: 'success'
                        })
                        $("#addModal").modal('hide');
                        $("#form-data")[0].reset();
                        showAllUsers();
                    }
                });
            }
        });

        $("body").on("click",".editBtn",function(e){

            e.preventDefault();

            edit_id = $(this).attr('id');
            $.ajax({
                url:"action.php",
                type:"POST",
                data:{edit_id:edit_id},
                success:function(response){
                    
                    data = JSON.parse(response);

                    console.log(data)

                    $("#id").val(data.id);
                    $("#fname").val(data.first_name);
                    $("#lname").val(data.last_name);
                    $("#email").val(data.email);
                    $("#car").val(data.car);
                }
            });

        });

        $("#update").click(function(e){
            if($("#edit-form-data")[0].checkValidity()){
                e.preventDefault();
                $.ajax({
                    url:"action.php",
                    type:"POST",
                    data: $("#edit-form-data").serialize() + "&action=update",
                    success:function(response){
                        Swal.fire({
                            title: 'User updated successfully!',
                            type: 'success'
                        })
                        $("#editModal").modal('hide');
                        $("#edit-form-data")[0].reset();
                        showAllUsers();
                    }
                });
            }
        });


        $("body").on("click",".delBtn",function(e){
            e.preventDefault();

            var tr = $(this).closest('tr');
            del_id = $(this).attr('id');

            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url:"action.php",
                    type:"POST",
                    data:{del_id:del_id},
                    success:function(response){


                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )

                        showAllUsers();
                    }
                }) 
            }
            });

        });


        $("body").on("click",".infoBtn",function(e){
            e.preventDefault();
            info_id = $(this).attr('id');
            //console.log(info_id);
            $.ajax({
                url:"action.php",
                type: "POST",
                data:{info_id:info_id},
                success:function(response){
                  console.log(response)
                   data = JSON.parse(response)
                   Swal.fire({
                       title:'<strong>User Info</strong>',
                       type: 'info',
                       html: '<b>First Name: </b>' + data.first_name + '<br> <b> Last Name: </b>' + data.last_name + 
                       '<br> <b> Email: </b>' + data.email + '<br> <b> Car: </b>' + data.brand,
                   })
                }
            });
        });

    });
</script>
</body>
</html>