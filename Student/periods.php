<?php include('../includes/config.php') ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Periods</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Student</a></li>
              <li class="breadcrumb-item active">Periods</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="table-responsive">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th>S.No.</th>
                <th>Title</th>
                <th>From</th>
                <th>To</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $count = 1;
                $args = array(
                'Type' => 'Period',
                'Status' => 'Publish',
                );
                $periods = get_posts($args);
                foreach($periods as $period) {
                $from = get_metadata($period->Id, 'From')[0]->MetaValue;
                $to = get_metadata($period->Id, 'To')[0]->MetaValue;
                ?>
                <tr>
                <td><?=$count++?></td>
                <td><?=$period->title?></td>
                <td><?php echo date('h:i A',strtotime($from)) ?></td>
                <td><?php echo date('h:i A',strtotime($to)) ?></td>
                </tr>

                <?php } ?>

            </toby>


            </table>
        </div>   

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
<?php include('footer.php') ?>