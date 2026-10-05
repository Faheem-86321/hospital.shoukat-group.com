<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$con = mysqli_connect('localhost', 'u719432153_faheem', '9^McZ7KlT3Vr', 'u719432153_faheem');

if (!$con) {
    die('Connection Not Established');
}

$company_sql = "SELECT * FROM company_info WHERE status = '1' AND close = '1'";
$company_sql_ex = mysqli_query($con, $company_sql);

while ($key = mysqli_fetch_assoc($company_sql_ex)) {
    $_SESSION['com_name']    = $key['com_name'];
    $_SESSION['com_phone']   = $key['com_phone'];
    $_SESSION['com_email']   = $key['com_email'];
    $_SESSION['com_logo']    = $key['com_logo'];
    $_SESSION['com_address'] = $key['com_address'];
}
?>