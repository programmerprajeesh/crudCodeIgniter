<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>
  <title>Codeigniter 3 CRUD Application</title>
</head>

<body>

  <div class="container">
    <div class="row">

      <div class="col-lg-12 my-5">
        <h2 class="text-center mb-3">Codeigniter 3 CRUD (Create-Read-Update-Delete) Application</h2>
      </div>

      <div class="col-lg-12">

        <?php echo $this->session->flashdata('message'); ?>
        <div class="d-flex justify-content-between mb-3">
          <h4>Manage Posts</h4>
          <a href="<?= base_url('post/create') ?>" class="btn btn-success"> <i class="fas fa-plus"></i> Add New Post</a>
          <a class="btn btn-warning" href="<?php echo base_url(); ?>"> <i class="fas fa-angle-left"></i> Back</a>
        </div>

        <table class="table table-bordered table-default" id="dataTable">

          <thead class="thead-light">
            <tr>
              <th width="2%">#</th>
              <th width="25%">Title</th>
              <th width="53%">Description</th>
              <th width="20%">Action</th>
            </tr>
          </thead>

          <tbody id="dataTableBody">

            <?php $i = 1; foreach ($data as $post) { ?>

              <tr id="tr_<?=$i?>" data-id="<?=$i?>">
                <td><?php echo $i; ?></td>
                <td><?php echo $post->title; ?></td>
                <td><?php echo $post->description; ?></td>

                <td>
                  <a onclick = "editPost(<?=$post->id?>)" class="btn btn-primary"> <i class="fas fa-edit"></i> Edit </a>
                  <a class="btn btn-danger" onclick="deletePost(<?=$post->id?>,<?=$i?>)"> <i class="fas fa-trash"></i> Delete </a>
                </td>

              </tr>

            <?php $i++; } ?>

          </tbody>

        </table>

      </div>
      <div class="col-lg-12">
        <div id="response"></div>

        <div class="d-flex justify-content-between ">
          <h4>Add New Post</h4>          
        </div>

        <form id="add_post">

          <div class="form-group">
            <label>Title</label>
            <input class="form-control" type="text" name="title"   id="title" required>
            
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
            
          </div>

          <div class="form-group">
            <button type="submit" id="save" class="btn btn-success"> <i class="fas fa-check"></i> Submit </button>
          </div>

        </form>


      </div>
    </div>
  </div>



  <?php $this->load->view('includes/footer'); ?>

  <script type="text/javascript">

    $("#save").click(function(event){
      event.preventDefault();
      var url = 'ajax/store';
      var data = {
        title : $('#title').val(),
        description : $('#description').val(),
        last_tr_id : $('#dataTableBody tr:last').attr('data-id')
        
      }

      // console.log(data);
      
      $.ajax({
        url : url,
        data:data,
        dataType:'JSON',
        type:"POST",
        success : function(response) {
          console.log(response);
          var tr_id = $('#dataTable tr:last').attr('id');

          var responseTxt = '<div class="alert alert-'+response.status+'">'+response.message+'</div>';  
          $('#response').html(responseTxt);
          $('#dataTableBody').append(response.html);
          // $('#save').reset();
          $('#add_post')[0].reset();
          
        }
       

      });
      
    });


    function deletePost(id,row_id){
      var url = 'ajax/delete';
      var data = {
        id : id
      }
      

      $.ajax({

        url: url,
        type: 'post',
        dataType:'Json',
        data: data,
        success: function(response){
          console.log(response);
          console.log(row_id);
          var responseTxt = '<div class="alert alert-'+response.status+'">'+response.message+'</div>';
          $('#response').html(responseTxt);
          $('#tr_'+row_id).remove();

        }



      });





    }


  </script>

</body>

</html>