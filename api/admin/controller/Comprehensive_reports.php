<?php
date_default_timezone_set("Asia/Karachi");
$report_type = isset($_GET['report_type']) ? $_GET['report_type'] : 'opd';
$date_from   = isset($_GET['date_from'])   ? $_GET['date_from']   : date('Y-m-01');
$date_to     = isset($_GET['date_to'])     ? $_GET['date_to']     : date('Y-m-d');
$doc_id      = isset($_GET['doc_id'])      ? $_GET['doc_id']      : '';
$search_btn  = true;
