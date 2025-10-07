<?php include('../includes/config.php') ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>

<?php
if (isset($_POST['submit'])) {
  $title = $_POST['title'];

  $sections = $_POST['section'];
  // $added_date = date('Y-m-d');
  $query = sqlsrv_query($db_conn, "INSERT INTO tbl_Posts(Author, Title, Description, Type, Status,Parent) VALUES ('1',?,'Description','Class','Publish',0); SELECT SCOPE_IDENTITY() as LastInsertId", array($title)) or die('DB error');

  if ($query) {
    //$post_id = mysqli_insert_id($db_conn);
    $post_id=sqlsrv_get_field($query,0);
  }
  foreach ($sections as $key => $value) {
    sqlsrv_query($db_conn, "INSERT INTO tbl_MetaData (ItemId,MetaKey,MetaValue) VALUES (?,'Section',?)", array($post_id, $value)) or die(sqlsrv_errors());
  }
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Manage Classes</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="">Admin</a></li>
          <li class="breadcrumb-item active">Classes</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Info boxes -->
    <?php
    if (isset($_REQUEST['action'])) { ?>
      <div class="card">
        <div class="card-header py-2">
          <h3 class="card-title">
            Add New class</h3>
        </div>
        <div class="card-body">
          <form action="" method="POST">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" name="title" placeholder="Title" required class="form-control">
            </div>
            <div class="form-group">
              <label for="title">Sections</label>
              <?php
              $args = array(
                'Type' => 'Section',
                'Status' => 'Publish',
              );
              $sections = get_posts($args);
              foreach ($sections as $key => $section) { ?>
                <div>
                  <label for="<?php echo $key ?>">
                    <input type="checkbox" name="section[]" id="<?php echo $key ?>" value="<?= $section->Id ?>"
                      placeholder="section">
                    <?php echo $section->Title ?>
                  </label>
                </div>
                <?php
              } ?>
            </div>
            <button name="submit" class="btn btn-success">Submit</button>
          </form>
        </div>
      </div>
    <?php } else { ?>
      <div class="card">
        <div class="card-header py-2">
          <h3 class="card-title">Classes</h3>
          <div class="card-tools">
            <a href="?action=add-new" class="btn btn-success btn-xs"><i class="fa fa-plus mr-2"></i>Add New</a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive bg-white">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>section</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $count = 1;
                $args = array(
                  'Type' => 'Class',
                  'Status' => 'Publish',
                );
                $classes = get_posts($args);
                foreach ($classes as $class) { ?>
                  <tr>
                    <td><?= $count++ ?></td>
                    <td>Class <?= $class->Title ?></td>
                    <td>
                      <?php
                      $class_meta = get_metadata($class->Id, 'Section');
                      foreach ($class_meta as $meta) {
                        $section = get_post(array('Id' => $meta->MetaValue));
                        echo $section->Title;
                      } ?>
                    </td>
                    <td><?= $class->PublishDate ?></td>
                    <td></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    <?php } ?>
  </div>
</section>
<!-- /.content -->
<?php include('footer.php'); ?>