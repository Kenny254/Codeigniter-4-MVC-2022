<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo lang('Applicants') ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/processes') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('Applicants') ?></li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- /.container-fluid -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3"><?php echo lang('Applicants') ?></h3>
                <div class="ml-auto p-2">
                    <?php if (hasPermissions('fverifications_add')): ?>
                      <a href="<?php echo url('processes/add') ?>" class="btn btn-primary btn-sm"><span class="pr-1"><i class="fa fa-plus"></i></span> <?php echo lang('App.add_students') ?></a>
                    <?php endif ?>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                  <tr>
                    <th><?php echo lang('#') ?></th>
                    <th><?php echo lang('Student Name') ?></th>
                    <th><?php echo lang('Gender') ?></th>
                    <th><?php echo lang('Date of Birth') ?></th>
                    <th><?php echo lang('Grade 4 Report') ?></th>
                    <th><?php echo lang('Grade 5 Report') ?></th>
                    <th><?php echo lang('Grade 6 Report') ?></th>
                    <th><?php echo lang('Qualification Status') ?></th>
                    <th><?php echo lang('Action') ?></th>
                  
                  </tr>
                  </thead>
                  <tbody>
                      
                  <?php foreach ($viewInfo as $row):?>

                  <tr>
                      <td 
                      width="30"><?php echo $row->id?>
                    </td>
                    
                    <td>
                        <?php echo $row->applicant_name?>
                    </td>
 
                    <td width="50" class="text-center">
                     <?php echo $row->gender?> 
                    </td>
                    
                    <td>
                        <?php echo $row->dob ?>
                    </td>
                    
                    <td>
                      <?php 
                      
                      $four = $row->grade_4;
                       if ($four < "1") {
                                  echo "No file Submitted";
                                  } else {
                                  echo "Valid file submitted";
                                  }
                      ?>
                      
                    </td>
                   
                    <td>
                      <?php 
                      
                      $five = $row->grade_5;
                       if ($five < "1") {
                                  echo "No file Submitted";
                                  } else {
                                  echo "Valid file submitted";
                                  }
                      ?>
                      
                    </td>
                    
                    <td>
                      <?php 
                      
                      $six = $row->grade_6;
                       if ($six < "1") {
                                  echo "No file Submitted";
                                  } else {
                                  echo "Valid file submitted";
                                  }
                      ?>
                      
                    </td>
                    
                    <td>
      						    <?php
      						    //Computes the status decision
                                  $b = $row->grade_4;
                                  $c = $row->grade_5;
                                  $d = $row->grade_6;
                                  $decisionValue = $b + $c + $d; 
                                  
                                  if ($decisionValue < "3") {
                                  echo "Disqualified";
                                  } else {
                                  echo "Qualified";
                                  }
                                  
                                ?>
      				</td>
                    
                    <td>
                        <?php if (hasPermissions('processes_edit')): ?>
                        <a href="<?php echo url('processes/edit/'.$row->id) ?>" class="btn btn-sm btn-primary" title="<?php echo lang('App.edit_user') ?>" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                        <?php endif ?>
                        
                        <?php if (hasPermissions('processes_view')): ?>
                          <a href="<?php echo url('processes/view/'.$row->id) ?>" class="btn btn-sm btn-info" title="<?php echo lang('App.view_user') ?>" data-toggle="tooltip"><i class="fa fa-eye"></i></a>
                        <?php endif ?>
                        
                        <?php if (hasPermissions('processes_delete')): ?>
                          <?php if ($row->id!=1 && logged('id')!=$row->id): ?>
                          <a href="<?php echo url('processes/delete/'.$row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Do you really want to delete this user ?')" title="<?php echo lang('App.delete_user') ?>" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                            
                          <?php else: ?>
                          
                            <a href="#" class="btn btn-sm btn-danger" title="<?php echo lang('App.delete_user_cannot') ?>" data-toggle="tooltip" disabled><i class="fa fa-trash"></i></a>
                            
                          <?php endif ?>
                          
                        <?php endif ?>
                      </td>
               </tr>
                  <?php endforeach ?>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->



    <?= $this->endSection() ?>
<?= $this->section('js') ?>

<script>
window.updateUserStatus = (id, status) => {
  $.get( '<?php echo url('processes/change_status') ?>/'+id, {
    status: status
  }, (data, status) => {
    if (data=='done') {
      // code
    }else{
      alert('<?php echo lang('App.user_unable_change_status') ?>');
    }
  })
}
</script>
<?=  $this->endSection() ?>
