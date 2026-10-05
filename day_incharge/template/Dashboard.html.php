<?php 
// This if else condition will be same
if(mysqli_num_rows($execuit)>0){
	?>
    <?php header("location: private_indoor_dashboard") ?>
<script>

</script>	
<?php  }else{
    header('location:logout');
} ?>       