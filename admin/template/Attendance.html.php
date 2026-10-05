<style type="text/css">
    input[type=file]::-webkit-file-upload-button {
        display: none;
    }
</style>
<div class="col-xl-12  col-lg-12">
    <div class="card">
        <div class="card-body" dir="ltr">
            <div class="card-widgets ">
                <a href="javascript: void(0);" onclick="reloadtablecontent()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    

                    <div class="form-group col-md-3 col-sm-12">
                        <input  class="form-control"   type="file" name="excel_file"  autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-2">
                        <input id="btn1" type="submit" name="Generatesalary" class="btn btn-Success search " style="border-radius: 3px;" value="Import Attendance" >
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-4">
                   
                </div>
                <div class="col-md-12 mt-2">
                   <form action="" method="get" enctype="multipart/form-data">
                    <div class="row  "> 

                        <div class="form-group col-md-7">
                            <input type="date" class="form-control m-1 "  name="date"  style="width: 150px;float: left;" required> <input type="submit" class="btn btn-success m-1  "  name="search_date" value="Search"  style=" height: 36px;">
                        </div>
                        <div class="form-group col-md-3">
                           
                        </div>
                    </div>   
                </form>
            </div>

        </div>
        <table id="attendanceTable" class="table table-centered table-striped table-bordered mb-0 toggle-circle">
    <thead>
        <tr>
            <th>Uploaded Date</th>
            <th>File</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($con, "SELECT * FROM attendance ORDER BY datetime DESC");

        while ($row = mysqli_fetch_assoc($result)) {
            $fileUrl = "admin/backup/uploads/" . htmlspecialchars($row['file_name']);
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['datetime']) . "</td>";
    
            echo "<td>" . $row['name'] . "</td>";
            echo "<td><a href='" .  htmlspecialchars($fileUrl) . "' target='_blank' class='btn btn-sm btn-danger'>View</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

                                 
        

        