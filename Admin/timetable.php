<?php include('../includes/config.php') ?>

<?php
if(isset($_POST['submit']))
{
    $classId = isset($_POST['class_id'])?$_POST['class_id']:'';
    $sectionId = isset($_POST['section_id'])?$_POST['section_id']:'';
    $teacherId = isset($_POST['teacher_id'])?$_POST['teacher_id']:'';
    $periodId = isset($_POST['period_id'])?$_POST['period_id']:'';
    $dayName = isset($_POST['day_name'])?$_POST['day_name']:'';
    $subjectId = isset($_POST['subject_id'])?$_POST['subject_id']:'';
    $dateAdd = date('Y-m-d g:i:s');
    $status = 'Publish';
    $author = 1;
    $type = 'Timetable';
    // $title = 
    // $query = sqlsrv_query($db_conn, "INSERT INTO posts (`type`,`author`,`status`,`publish_date`) VALUES ('$type','$author','$status','$date_add')");
    $query = sqlsrv_query($db_conn, "INSERT INTO tbl_Posts(Author, Title, Description, Type`, Status,Parent`) VALUES ('1',?,'Description','Timetable','Publish',0)", array($type)) or die('DB error');
    if($query)
    {
        //$post_id = mysqli_insert_id($db_conn);
        $post_id=sqlsrv_get_field($query,0);
    }
    $metadata = array(
        'classId' => $classId,
        'sectionId' => $sectionId,
        'teacherId' => $teacherId,
        'periodId' => $periodId,
        'dayName' => $dayName,
        'subjectId' => $subjectId,
    );
    
    foreach ($metadata as $key => $value) {
        sqlsrv_query($db_conn, "INSERT INTO tbl_MetaData (ItemId,MetaKey,MetaValue) VALUES (?,?,?)", array($post_id,$key,$value));
    }

    header('Location: timetable.php');
}
?>

<?php include('header.php') ?>
<?php include('sidebar.php') ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Time Table 

            <a href="?action=add" class="btn btn-success btn-sm"> Add New</a>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
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

        <?php if(isset($_GET['action']) && $_GET['action'] == 'add') {?>
        
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                <div class="row">
                        <div class="col-lg">
                            <div class="form-group">
                                <label for="class_id">Select Class</label>
                                <select require name="class_id" id="class_id" class="form-control">
                                    <option value="">-Select Class-</option>
                                    <?php
                                    $args = array(
                                      'Type' => 'Class',
                                      'Status' => 'Publish',
                                    );
                                    $classes = get_posts($args); 
                                    foreach ($classes as $key => $class) { ?>
                                    <option value="<?php echo $class->Id ?>"><?php echo $class->Title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group" id="section-container">
                                <label for="section_id">Select Section</label>
                                <select require name="section_id" id="section_id" class="form-control">
                                    <option value="">-Select Section-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group" id="section-container">
                                <label for="teacher_id">Select Teacher</label>
                                <select require name="teacher_id" id="teacher_id" class="form-control">
                                    <option value="">-Select Teacher-</option>
                                    <option value="1">Teacher 1</option>
                                    <option value="2">Teacher 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group" id="section-container">
                                <label for="period_id">Select Period</label>
                                <select require name="period_id" id="period_id" class="form-control">
                                    <option value="">-Select Period-</option>
                                    <?php
                                    $args = array(
                                        'Type' => 'Period',
                                        'Status' => 'Publish',
                                      );
                                      $periods = get_posts($args); 
                                      foreach ($periods as $key => $period) { ?>
                                      <option value="<?php echo $period->Id ?>"><?php echo $period->Title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group" id="section-container">
                                <label for="day_name">Select Day</label>
                                <select require name="day_name" id="day_name" class="form-control">
                                    <option value="">-Select Day-</option>

                                    <?php
                                     $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                                     foreach ($days as $key => $day) { ?>
                                        <option value="<?php echo $day ?>"><?php echo ucwords($day)?></option>
                                      <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group" id="section-container">
                                <label for="subject_id">Select Subject</label>
                                <select require name="subject_id" id="subject_id" class="form-control">
                                    <option value="">-Select Subject-</option>
                                    <option value="19">Mathematics</option>
                                    <option value="20">English</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="from-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" value="submit" name="submit" class="btn btn-success form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php } else {?>

        <form action="" method="get">
            <?php
            $classId = isset($_GET['class'])?$_GET['class']:43;
            $sectionId = isset($_GET['section'])?$_GET['section']:3;
            ?>
            <div class="row">
                <div class="col-auto">
                    <div class="form-group">
                        <select name="class" id="class" class="form-control">
                            <option value="">Select Class</option>
                            <?php
                            $args = array(
                            'Type' => 'Class',
                            'Status' => 'Publish',
                            );
                            $classes = get_posts($args);
                            foreach ($classes as $class) {
                                $selected = ($class_id ==  $class->Id)? 'selected': '';
                                echo '<option value="' . $class->Id . '" '.$selected.'>' . $class->Title . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group" id="section-container">
                        <select name="section" id="section" class="form-control">
                            <option value="">Select Section</option>
                            <?php
                            $args = array(
                            'Type' => 'Section',
                            'Status' => 'Publish',
                            );
                            $sections = get_posts($args);
                            foreach ($sections as $section) {
                                $selected = ($section_id ==  $section->Id)? 'selected': '';
                            echo '<option value="' . $section->Id . '" '.$selected.'>' . $section->Title . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">Apply</button>
                </div>
            </div>

        </form>

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
                            $from = get_metadata($period->Id, 'from')[0]->MetaValue;

                            $to = get_metadata($period->Id, 'to')[0]->MetaValue;
                            ?>
                        <tr>
                            <td><?php echo date('h:i A',strtotime($from)) ?> - <?php echo date('h:i A',strtotime($to)) ?></td>
                            <?php 

                            $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                            
                            foreach($days as $day){ 
                                $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_Posts as p 
                                INNER JOIN tbl_MetaData as md ON (md.ItemId = p.Id) 
                                INNER JOIN tbl_MetaData as mp ON (mp.ItemId = p.Id) 
                                INNER JOIN tbl_MetaData as mc ON (mc.ItemId = p.Id) 
                                INNER JOIN tbl_MetaData as ms ON (ms.ItemId = p.Id) 
                                WHERE p.Type = 'Timetable' AND p.Status = 'Publish' 
                                AND md.MetaKey = 'dayName' AND md.MetaValue = ? 
                                AND mp.MetaKey = 'periodId' AND mp.MetaValue = ? 
                                AND mc.MetaKey = 'classId' AND mc.MetaValue = ? 
                                AND ms.MetaKey = 'sectionId' AND ms.MetaValue = ?",
                                array($day,$period->Id,$classId,$sectionId));

                
                                
                                if(sqlsrv_num_rows($query) > 0)
                                {
                                    while($timetable = sqlsrv_fetch_object($query)) {
                                        
                                        
                                        ?>
                                        <td>
                                            <p>
                                                <b>Teacher: </b> 
                                                <?php 
                                                $teacherId = get_metadata($timetable->ItemId,'teacherId')[0]->MetaValue;
                                                
                                                echo get_user_data($teacherId)->Name;
                                                ?> 
                                                
                                                
                                                <br>
                                                <b>Class: </b> 
                                                <?php 
                                                $classId = get_metadata($timetable->ItemId,'classId',)[0]->MetaValue;
                                                echo get_post(array('Id'=>$classId))->Title;
                                                ?>
                                                <br>
                                                <b>Section: </b>
                                                <?php 
                                                $sectionId = get_metadata($timetable->ItemId,'sectionId',)[0]->MetaValue;
                                                echo get_post(array('Id'=>$sectionId))->Title;
                                                ?>
                                                <br>
                                                <b>Subject: </b> 
                                                <?php 
                                                $subjectId = get_metadata($timetable->ItemId,'subjectId',)[0]->MetaValue;
                                                echo get_post(array('Id'=>$subjectId))->Title;
                                                ?>
                                                <br>
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

        <?php } ?>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <!-- Subject -->
<script>
jQuery(document).ready(function(){

  jQuery('#class_id').change(function(){
    // alert(jQuery(this).val());

    jQuery.ajax({
      url:'ajax.php',
      type : 'POST',
      data  : {'class_id':jQuery(this).val()},
      dataType : 'json',
      success: function(response){
        if(response.count > 0)
        {
          jQuery('#section-container').show();        
        }
        else
        {
          jQuery('#section-container').hide();
        }
        jQuery('#section_id').html(response.options); 
      }
    });
  });

})
</script>
<?php include('footer.php') ?>