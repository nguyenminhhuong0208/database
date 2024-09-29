<?php 
if(isset($success_msg)){
    foreach($success_msg as $success_msg){
        echo'<script>swal(" '.$success_msg.' ", "","warning"):</script>';

    }
}

if(isset($warning_msg)){
    foreach($warning_msg as $warning_msg){
        echo'<script>swal(" '.$warning_msg.' ", "","warning"):</script>';

    }
}

if(isset($infor_msg)){
    foreach($infor_msg as $infor_msg){
        echo'<script>swal(" '.$infor_msg.' ", "","infor"):</script>';

    }
}

if(isset($error_msg)){
    foreach($error_msg as $error_msg){
        echo'<script>swal(" '.$error_msg.' ", "","error"):</script>';

    }
}
?>