<?php 
include('../includes/config.php');




if(isset($_POST['type']) && $_POST['type'] == 'student')
{
    $uploadOk =1;
    $user_id = !empty($_POST['user_id'])? $_POST['user_id'] : 0;
    
    $result = sqlsrv_query($db_conn, "SELECT Id FROM tbl_Accounts` WHERE Type = 'Student'")->NumOfRows;
    $std_enroll = $result+1;
    
    $target_dir = "../dist/uploads/student-docs/";
    
    $name = isset($_POST['name'])?$_POST['name']:'';
    $dob = isset($_POST['dob'])?$_POST['dob']:'';
    $mobile = isset($_POST['mobile'])?$_POST['mobile']:'';
    $email = isset($_POST['email'])?$_POST['email']:'';
    $address = isset($_POST['address'])?$_POST['address']:'';
    $country = isset($_POST['country'])?$_POST['country']:'';
    $state = isset($_POST['state'])?$_POST['state']:'';
    $zip = isset($_POST['zip'])?$_POST['zip']:'';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $religion = isset($_POST['religion']) ? $_POST['religion'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    
    $password = date('dmY',strtotime($dob));
    $md_password = md5($password);
    
    $father_name = isset($_POST['father_name'])?$_POST['father_name']:'';
    $father_mobile = isset($_POST['father_mobile'])?$_POST['father_mobile']:'';
    $mother_name = isset($_POST['mother_name'])?$_POST['mother_name']:'';
    $mother_mobile = isset($_POST['mother_mobile'])?$_POST['mother_mobile']:'';
    $parents_address = isset($_POST['parents_address'])?$_POST['parents_address']:'';
    $parents_country = isset($_POST['parents_country'])?$_POST['parents_country']:'';
    $parents_state = isset($_POST['parents_state'])?$_POST['parents_state']:'';
    $parents_zip = isset($_POST['parents_zip'])?$_POST['parents_zip']:'';
    
    $school_name = isset($_POST['school_name'])?$_POST['school_name']:'';
    $previous_class = isset($_POST['previous_class'])?$_POST['previous_class']:'';
    $status = isset($_POST['status'])?$_POST['status']:'';
    $total_marks = isset($_POST['total_marks'])?$_POST['total_marks']:'';
    $obtain_mark = isset($_POST['obtain_mark'])?$_POST['obtain_mark']:'';
    $previous_percentage = isset($_POST['previous_percentage'])?$_POST['previous_percentage']:'';
    
    $class = isset($_POST['class'])?$_POST['class']:'';
    $section = isset($_POST['section'])?$_POST['section']:'';
    $subject_streem = isset($_POST['subject_streem'])?$_POST['subject_streem']:'';
    $doa = isset($_POST['doa'])?$_POST['doa']:'';
    
    $std_enroll = isset($_POST['enrollment_no'])? $_POST['enrollment_no']  : date('Y', strtotime($doa)).date('dm', strtotime($dob)).sprintf('%06d',$std_enroll);
    $usermeta = [];
    foreach ($_FILES['documention']['name'] as $key => $value) {
        // Check file size
        if($_FILES["documention"]["name"][$key]){
            if ($_FILES["documention"]["size"][$key] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            $imageFileType = strtolower(pathinfo(basename($_FILES["documention"]["name"][$key]),PATHINFO_EXTENSION));
            $target_file = $target_dir.''.$std_enroll.'_'.$key.'.'.$imageFileType;
            if($uploadOk){
                move_uploaded_file($_FILES["documention"]["tmp_name"][$key], $target_file);
            }
    
            $usermeta[$key] = $std_enroll.'_'.$key.'.'.$imageFileType;
        }
        
    }

    $type = isset($_POST['type'])?$_POST['type']:'';
    $date_add = date('Y-m-d');
    
    $payment_method = isset($_POST['payment_method'])?$_POST['payment_method']:'';

    
    
    $usermeta += array(
        'DOB' => $dob,
        'Mobile' => $mobile,
        'PayMethod' => $payment_method,
        'Class' => $class,
        'Address' => $address,
        'Country' => $country,
        'State' => $state,
        'Zip' => $zip,
        'Gender' => $gender,
        'Religion' => $religion,
        'Category' => $category,
        'FatherName' => $father_name,
        'FatherMobile' => $father_mobile,
        'MotherName' => $mother_name,
        'MotherMobile' => $mother_mobile,
        'ParentsAddress' => $parents_address,
        'ParentsCountry' => $parents_country,
        'ParentsState' => $parents_state,
        'ParentsZip' => $parents_zip,
        'SchoolName' => $school_name,
        'PreviousClass' => $previous_class,
        'Status' => $status,
        'TotalMarks' => $total_marks,
        'ObtainMarks' => $obtain_mark,
        'PreviousPercentage' => $previous_percentage,
        'Section' => $section,
        'SubjectStreem' => $subject_streem,
        'DOA' => $doa,
        'EnrollmentNo' => $std_enroll,
    );
    

    
    if($user_id){  
        foreach ($usermeta as $key => $value) {

            $check_query = sqlsrv_query($db_conn, "SELECT * FROM tbl_UserMeta WHERE UserId = ? AND MetaKey = ?",array($user_id,$key));

            if(sqlsrv_num_rows($check_query)>0){

                sqlsrv_query($db_conn, "UPDATE tbl_UserMeta SET MetaValue = ? WHERE UserId = ? AND MetaKey = ?",array($value,$user_id,$key)) or die(sqlsrv_errors());
            }else{
                sqlsrv_query($db_conn, "INSERT INTO tbl_UserMeta (UserId,MetaKey,MetaValue) VALUES (?,?,?)",array($user_id,$key,$value)) or die(sqlsrv_errors());
            }
        }
        $_SESSION['success_msg'] = 'User has been succefuly updated';
    }else{    
        $query = sqlsrv_query($db_conn, "INSERT INTO tbl_Accounts (Name,Email,Password,Type) VALUES (?,?,?,?)",array($name,$email,$md_password,$type)) or die(sqlsrv_errors());
        if($query)
        {
            //$user_id = mysqli_insert_id($db_conn);
            $user_id=sqlsrv_get_field($query,0);
        }

        // Parent registration
        $check_query = sqlsrv_query($db_conn, "SELECT * FROM tbl_Accounts as a JOIN tbl_UserMeta as m ON a.Id = m.UserId WHERE a.Type = 'Parent' AND ( Email = ? OR (m.MetaKey = 'Mobile' AND m.MetaValue = ?) )",array($father_mobile,$father_mobile));
        
        if(sqlsrv_num_rows($check_query) > 0){
            $parent = sqlsrv_fetch_array($check_query);
            $parent_id = $parent['user_id'];
            $parent = get_user_data($parent_id,false);
            $child = unserialize($parent['Child']);
            $child[] = $user_id;
            $child = serialize($child);
            $query = sqlsrv_query($db_conn, "UPDATE tbl_UserMeta SET MetaValue = ? WHERE MetaKey = 'Child' AND UserId = ?",array($child,$parent_id))or die(sqlsrv_errors());;
        }else{    
            $md_password = md5($father_mobile);
            $query = sqlsrv_query($db_conn, "INSERT INTO tbl_Accounts (Name,Email,Password,Type) VALUES (?,?,?,'Parent')",array($father_name,$father_mobile,$md_password)) or die(sqlsrv_errors());
            if($query)
            {
                //$parent_id = mysqli_insert_id($db_conn);
                $parent_id=sqlsrv_get_field($query,0);
            }
            $chld = [$user_id];
            $chld = serialize($chld);
            sqlsrv_query($db_conn, "INSERT INTO tbl_UserMeta (UserId,MetaKey,MetaValue) VALUES (?,'Child',?)",array($parent_id,$chld)) or die(sqlsrv_errors());
        }

        

        foreach ($usermeta as $key => $value) {
            sqlsrv_query($db_conn, "INSERT INTO tbl_UserMeta (UserId,MetaKey,MetaValue) VALUES (?,?,?)",array($user_id,$key,$value)) or die(sqlsrv_errors());
        }
    
        $months = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
    
        $att_data = [];
        for ($i=1; $i <= 31; $i++) { 
            $att_data[$i] = [
                'signin_at' => '',
                'signout_at' => '',
                'date' => $i
            ];
        }
        $att_data = serialize($att_data);
        foreach ($months as $key => $value) {
            sqlsrv_query($db_conn, "INSERT INTO tbl_Attendance (AttendanceMonth,AttendanceValue,StdId) VALUES (?,?,?)",array($value,$att_data,$user_id)) or die(sqlsrv_errors());
        }
        
        $_SESSION['success_msg'] = 'User has been succefuly registered';
    
        
    }
    

    $response = array(
        'success' => TRUE,
        'std_id' => $user_id
    );
    echo json_encode($usermeta);
    die;
}

?>