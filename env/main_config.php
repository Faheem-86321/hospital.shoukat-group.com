<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    @session_start();
}

// Hostinger Remote IP Connection
$con = @mysqli_connect('srv1934.hstgr.io', 'u719432153_Faheem', '$Bf1Yl=QAYZb', 'u719432153_Faheem');

if (!$con) {
    // Agar connection fail ho toh blank 500 ke bajaye error screen par dikhegi
    die("Database Connection Failed: " . mysqli_connect_error());
}

$company_sql = "SELECT * FROM company_info WHERE status = '1' AND close = '1'";
$company_sql_ex = mysqli_query($con, $company_sql);

if ($company_sql_ex) {
    while ($key = mysqli_fetch_assoc($company_sql_ex)) {
        $_SESSION['com_name']    = $key['com_name'];
        $_SESSION['com_phone']   = $key['com_phone'];
        $_SESSION['com_email']   = $key['com_email'];
        $_SESSION['com_logo']    = $key['com_logo'];
        $_SESSION['com_address'] = $key['com_address'];
    }
}
?>
