<?php

    if(isset($success_msg)){
        // Kiểm tra nếu là mảng thì duyệt qua từng phần tử
        if (is_array($success_msg)) {
            foreach($success_msg as $msg){
                echo '<script>swal("'.$msg.'", "", "success");</script>';
            }
        } else {
            // Nếu không phải mảng, hiển thị trực tiếp
            echo '<script>swal("'.$success_msg.'", "", "success");</script>';
        }
    }

    if(isset($warning_msg)){
        if (is_array($warning_msg)) {
            foreach($warning_msg as $msg){
                echo '<script>swal("'.$msg.'", "", "warning");</script>';
            }
        } else {
            echo '<script>swal("'.$warning_msg.'", "", "warning");</script>';
        }
    }

    if(isset($info_msg)){
        if (is_array($info_msg)) {
            foreach($info_msg as $msg){
                echo '<script>swal("'.$msg.'", "", "info");</script>';
            }
        } else {
            echo '<script>swal("'.$info_msg.'", "", "info");</script>';
        }
    }

    if(isset($error_msg)){
        if (is_array($error_msg)) {
            foreach($error_msg as $msg){
                echo '<script>swal("'.$msg.'", "", "error");</script>';
            }
        } else {
            echo '<script>swal("'.$error_msg.'", "", "error");</script>';
        }
    }

?>
