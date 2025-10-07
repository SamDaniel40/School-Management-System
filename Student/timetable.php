<?php include('../includes/config.php') ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Time Table</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Student</a></li>
              <li class="breadcrumb-item active">Time Table</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Timing</th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                            <th>Saturday</th>
                            <th>Sunday</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $args = array(
                            'Type' => 'Period',
                            'Status' => 'Publish',
                        );
                        $periods = get_posts($args);

                        foreach($periods as $period){ 
                            $from = get_metadata($period->Id, 'From')[0]->MetaValue;

                            $to = get_metadata($period->Id, 'To')[0]->MetaValue;
                            ?>
                        <tr>
                            <td><?php echo date('h:i A',strtotime($from)) ?> - <?php echo date('h:i A',strtotime($to)) ?></td>
                            <?php 

                            $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                            foreach($days as $day){ 
                                $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_Posts as p 
                                                    INNER JOIN tbl_MetaData as mc ON (mc.ItemId = p.Id) 
                                                    INNER JOIN tbl_MetaData as md ON (md.ItemId = p.Id) 
                                                    INNER JOIN tbl_MetaData as mp ON (mp.ItemId = p.Id) 
                                                    WHERE p.Type = 'Timetable' AND p.Status = 'Publish' 
                                                    AND md.MetaKey = 'dayName' AND md.MetaValue = ? 
                                                    AND mp.MetaKey = 'periodId' AND mp.MetaValue = ? 
                                                    AND mc.MetaKey = 'classId' AND mc.MetaValue = 1",
                                                    array($day,$period->Id));

                                if(sqlsrv_num_rows($query) > 0)
                                {
                                    while($timetable = sqlsrv_fetch_object($query)) {
                                        
                                        
                                        ?>
                                        <td>
                                            <p>
                                                <b>Teacher: </b> 
                                                <?php 
                                                $teacherId = get_metadata($timetable->ItemId,'teacherId',)[0]->MetaValue;
                                                echo get_user_data($teacherId)[0]->Name;
                                                ?> 
                                                
                                                <br>
                                                <b>Subject: </b> 
                                                <?php 
                                                $subjectId = get_metadata($timetable->ItemId,'subjectId',)[0]->MetaValue;
                                                echo get_post(array('Id'=>$subjectId))->Title;
                                                ?>
                                            </p>
                                        </td>
                                    <?php } 
                                }else { ?>
                                    <td>
                                        Unscheduled 
                                    </td>     
                                
                                <?php }  
                            }?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
<?php include('footer.php') ?>