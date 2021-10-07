<?php 
		 
  $name = $data['name'];
  $em = $data['email'];
  $subject = $data['subject'];
  $msg = $data['message'];
  $dept = "Unspecified";

?>

<center><img src="http://etukng.tobi-demos.tk/img/etukng.png" width="150" height="100"/></center>
<h3 style="background: #be831d; color: #fff; padding: 10px 15px;">{{$subject}}</h3>
Hello <em>{{$name}}</em>,<br><br> you have a new message from admin:<br><br>
Message: <blockquote><em>{{$msg}}</em></blockquote><br>

