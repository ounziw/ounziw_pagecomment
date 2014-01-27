<?php
$comments = '<div style="width:100%; height:200px; overflow:scroll; background-color:#EEE;">';
$format = '<p>投稿日: %s<br />投稿者: %s<br /> %s</p><hr />';
foreach ($natures as $nature) {
    $comments .= nl2br(sprintf($format, $nature->comm_created_at, $nature->comm_author, $nature->comm_content));
}
$comments .= '</div>';
echo $comments;