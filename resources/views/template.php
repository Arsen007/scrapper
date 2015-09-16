<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/css/am.css" rel="stylesheet" type="text/css">
    <link href="/css/cssAuto.css" rel="stylesheet" type="text/css">
    <base href="http://www.auto.am" target="_blank">
    <title></title>
</head>
<body>
<table>
<?php
foreach($tr_html_arr as $tr_content){
    echo '<tr>'.$tr_content.'</tr>';
}
?>
</table>
</body>
</html>