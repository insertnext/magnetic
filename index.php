<?php
session_start();
ob_start();
require_once '/home/rabbit/insertnext.com/include/filterInput.class.php';
$path = '/home/rabbit/insertnext.com/include/'; 
set_include_path(get_include_path() .PATH_SEPARATOR. $path);
require_once('Zend/Mail.php');

if(array_key_exists('send', $_POST)) {
  $contact = '';
  $check = new filterInput();
  $expected = array('contact', 'email', 'message');
  $required = array('contact', 'email', 'message');
  $missing = array();
  $error=array();
  $_SESSION['good'] = 'NO';

	$cnt = 0;
	$data = array();
	foreach($_POST as $key => $value){
	 $temp = is_array($value) ? $value : trim($value);
	 if($key != 'send'){
	   if(empty($temp) && in_array($key, $required)){
		  array_push($missing, $key);
	   }
	   elseif(in_array($key, $expected)){
		  ${$key} = $temp;
	   }
	   if(!empty($value)){
		 $input = $check->validTags($value);
		 if($key == 'email'){
		   if(!$check->validEmail($input)) $error[] = "Enter a valid e-mail address";
		 }
		 if($key == 'message'){
		   if(!$check->validMsgLength($input)) $error[] = "Message is either too short or too long. 5 characters min and 3000 characters max.";
		 }
		 else{
		   if(!$check->validLength($input)) $error[] = "Input for ".$key." is too long. Please no more than 80 chars.";
		 }
	   }
	   else{
		 $input = "none provided";
	   }
	  $data[$cnt] = $input;
	  $cnt++;
	 }
	}

   if($missing){
     $error[] = "All fields are required";
   }

  if(empty($missing) && !$error) {
    $html_text = 'Contact: '.$data[0].'<br><br>Message:<br>'.nl2br($data[2]);
    $mail = new Zend_Mail();
    $mail->setFrom($data[1]);
    $mail->addTo('captain@insertnext.com');
    $mail->setSubject('Message from Insert Next website');
    $mail->setBodyText($data[2]);
    $mail->setBodyHtml($html_text);
    $sent = $mail->send();

    if($sent){
      $_SESSION['good'] = 'OK';
      header('Location: sent');
      exit;
     }
    else{
      header('Location: /500?email=error');
      exit;
     }
   }

}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description" content="Often dreaming in php and javascript" />
<meta name="robots" content="index, follow" />

<title>Insert Next</title>
 
<link rel="stylesheet" href="css/main.css" media="screen" />
<!--[if lte IE 8]>
<link rel="stylesheet" type="text/css" href="css/layoutIE.css" media="screen">
<![endif]-->
<link href='http://fonts.googleapis.com/css?family=Lato:400,200' rel='stylesheet' />
<link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' />
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-25120158-1', 'auto');
  ga('send', 'pageview');

</script>
<!--[if gte IE 9]><!-->
<script>
  document.write('<'+'style type="text/css">#intro-text p, #get{display:none}'+'<'+'/style>');
</script>
<!--<![endif]-->
</head>

<body>

    <div id="header-wrapper">
       <div id="header">
         <div id="logo">
               <a href="/">insert_next</a>
         </div>
         
         <div id="toggle-btn"></div>
         <div id="main-nav">
              <ul>
                 <li><a href="/" id="about" class="here">{about}</a></li>
                 <li><a id="work" href="#projects">{projects}</a></li>
                 <li><a id="contact" href="#footer">{contact}</a></li>
              </ul>
         </div>
       </div>
    </div>
    
    <div id="intro">
       <div id="intro-text">
           <h3 id="big-text">Often dreaming in javascript and php</h3>
           <p>Hello. My name is Bakir and I am a freelance web developer. I enjoy building small business sites and interactive web applications.
           My skills range from HTML, CSS, Javascript on the frontend to PHP, Wordpress and Linux server administration on the backend.
           </p>
           <ul>
             <li><a href="#footer" class="btn" id="get">Get in touch</a></li>
           </ul>
       </div>
    </div>
    
    <div id="projects">

		<div class="site" data-slide="1">
		       <div class="site-thumb">
			   <a href="http://www.psynthesys.com" class="newin"><img src="/images/work/psynthesys.jpg" alt="" /></a>
			   </div>
				<div class="work">
				<div class="heading">Psynthesys</div>
				<ul>
					<li class="type">medical research</li>
					<li class="desc">Modified existing template by editing CSS, jQuery, Bootstrap, PHP, MySql and Wordpress. Integrated Mail Chimp with subscriptions.</li>
				</ul>
				</div>
		</div>
        
        <div class="site" data-slide="2">
               <div class="site-thumb">
			   <a href="http://www.insertnext.com/greela/map#q=san+francisco" class="newin"><img src="/images/work/SomeFun.jpg" alt="" /></a>
			   </div>
			   <div class="work">
				<ul>
					<li class="heading">Somewhere Fun</li>
					<li class="type">social</li>
					<li class="desc">Built and designed web app from scratch using CSS, jQuery, PHP, MySql, Solr search and Google Maps</li>
				</ul>
                </div>
		</div>
		
		<div class="site" data-slide="3">
                <div class="site-thumb">
                <a href="http://www.lavie-jewelry.com" class="newin"><img src="/images/work/Lavie.jpg" alt="Lavie Jewelry" /></a>
                </div>
                <div class="work">
                    <ul>
                        <li class="heading">Lavie Jewelry</li>
                        <li class="type">e-commerce</li>
                        <li class="desc">Modified template and shopping cart by editing HTML, CSS, jQuery, Bootstrap, PHP and MySql</li>
                    </ul>
                </div>
        </div>

	    <div class="site" data-slide="4">
                <div class="site-thumb">
                <a href="http://www.loneneutron.com" class="newin"><img src="/images/work/LN.jpg" alt="Lone Neutron" /></a>
                </div>
                <div class="work">
                    <ul>
                        <li class="heading">Lone Neutron</li>
                        <li class="type">music</li>
                        <li class="desc">Built custom HTML5 audio player from scratch with HTML5 Audio, CSS, jQuery Mobile and integrated youtube videos</li>
                    </ul>
                </div>
        </div>
        
        <div class="site" data-slide="5">
                <div class="site-thumb">
                <a href="http://www.mbgermancarservice.com" class="newin"><img src="/images/work/mbgerman.jpg" alt="MB German Car Service" /></a>
                </div>
                <div class="work">
                    <ul>
                        <li class="heading">MB German Car Service</li>
                        <li class="type">auto shop</li>
                        <li class="desc">Redesigned old website using HTML, CSS, javascript and jQuery Mobile</li>
                    </ul>
                </div>
        </div> 
    
    </div>

    <div id="footer">

          <div id="connect">

               <form method="post" id="form">

                <p>Get in touch</p>

                <?php
                if(isset($error)) {
                   echo '<ul id="error">';
                   foreach($error as $item) {
                      echo "<li>$item</li>";
                   }
                   echo '</ul>';
                } ?>
                
                  <fieldset class="input-box" id="name-box">
                     <input name="contact" id="name" placeholder="What is your name?" type="text" data-parsley-required data-parsley-required-message="required" 
                     <?php 
                     if(isset($missing)) {
                      echo 'value="'.htmlentities($_POST['contact']).'"';
                     }?> tabindex="1"/>
                  </fieldset>
                  <fieldset class="input-box">
                  <input name="email" id="email" placeholder="What is your email address?" data-parsley-required type="text" data-parsley-type="email" data-parsley-required-message="required"
                  <?php 
                  if(isset($missing)) {
                     echo 'value="'.htmlentities($_POST['email']).'"';
                    } ?> />
                  </fieldset>
                    <fieldset>
                   <textarea name="message" id="message" placeholder="Your inquiry" rows="1" cols="1" data-parsley-required data-parsley-required-message="required"><?php if(isset($missing)){
                    echo htmlentities($_POST['message']);
                    }?></textarea>

                   </fieldset>
                 
                 <fieldset>
                     <input type="submit" name="send" value="send" class="btn" />
                 </fieldset>
                 
              </form>
                               
              <div id="note">
                   <h3>Web Design | Web Development | Mobile Design | Server Setup And Maintenance | Multimedia | SEO</h3>
                   
                   <h3>If you have any questions, comments or you have a great idea for web application, I am listening.
                     <br />I'll get back to you as soon as possible.
                   </h3>
              </div>
              
           </div>
        
    </div>

<script src="/js/es5-shim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="/js/stellar.min.js"></script>
<script src="/play/js/waypoints.js"></script>
<script src="/play/js/jquery.easing.1.3.js"></script>
<script src="/js/parsley.min.js"></script>
<script src="/js/insert.js"></script>
</body>
</html>
