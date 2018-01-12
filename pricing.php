
<!DOCTYPE html>
<html class="no-js  " lang="en-US">
<?php

    $host="localhost";
    $username="root";
    $password="pecan@12345";
    $dbname="prop_details";
    $conn = mysqli_connect($host, $username, $password, $dbname);
	
	function moneyFormatIndia($num) {
    $explrestunits = "" ;
    if(strlen($num)>3) {
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if($i==0) {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}
	
?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="format-detection" content="telephone=no">
<link href="assets/images/favicon.png" rel="icon">
<!--[if lt IE 9]>
<script src="http://prodo.create.rocks/wp-content/themes/prodo/assets/js/html5shiv.min.js"></script>
<script src="http://prodo.create.rocks/wp-content/themes/prodo/assets/js/respond.min.js"></script>
<![endif]-->
<title> Pecan Reams</title>
<link rel='dns-prefetch' href='https://maps.google.com' />
<link rel='dns-prefetch' href='https://fonts.googleapis.com' />
<link rel='dns-prefetch' href='https://s.w.org' />
 
<style type="text/css">
img.wp-smiley,
img.emoji {
display: inline !important;
border: none !important;
box-shadow: none !important;
height: 1em !important;
width: 1em !important;
margin: 0 .07em !important;
vertical-align: -0.1em !important;
background: none !important;
padding: 0 !important;
}
</style>

<link rel='stylesheet' id='roboto-css'  href='https://fonts.googleapis.com/css?family=Roboto%3A300%2C400%2C400italic%2C500%2C500italic&#038;ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='open-sans-css'  href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2C400%2C400italic%2C600%2C600italic%2C700%2C700italic&#038;ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-css'  href='assets/bootstrap/css/bootstrap.min.css?ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-css'  href='assets/css/plugins/font-awesome.min.css?ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='isotope-css'  href='assets/css/plugins/isotope.min.css?ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='style-css'  href='assets/css/style.min.css?ver=2.1' type='text/css' media='all' />
<link rel='stylesheet' id='wp-style-css'  href='style.css?ver=4.6.1' type='text/css' media='all' />
<link rel='stylesheet' id='responsive-css'  href='assets/css/responsive.min.css?ver=4.6.1' type='text/css' media='all' />
   <link rel='stylesheet'   href='assets/css/login-min.css' type='text/css' media='all' />
 <link rel='stylesheet'   href='assets/css/login.css' type='text/css' media='all' />
<!--[if lt IE 9]>
<link rel='stylesheet' id='oldie-css'  href='assets/css/oldie.min.css?ver=4.6.1' type='text/css' media='all' />
<![endif]-->
 
 
 
 

 <style>
.footer-bottom {
    background-color: #191818; font-size:12px;
    width: 100%; padding:5px 0;
}
.copyright {
    color: #ccc;    text-align: right;
}
.design {
    color: #fff;
  
  
    text-align: left;
}
.design a {
    color: #fff;
}

/*------------------*/
footer .housing-line {
   padding: 13px 0 0 0;
    display: inline-block;
 
    
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
footer .housing-line img { height:88px;}
.footer .footer-logo-coloured {
  /*  height: 87px;
    background-image: url(assets/images/main-logo.png); 
    width: 167px;*/
    display: inline-block;
    background-size: contain;
    background-position: left;
    background-repeat: no-repeat;
    margin-bottom: 4px;
}

.footer .desc {
    color: #7f7f7f;
    font-size: 11px;
    line-height: 22px;
}
 .footer .footer-header {
    color: #000;
    height: 35px;  
    font-weight: 500;
    font-size: 16px;
}
 


.footer .footer-header .footer-text {
    display: inline-block; text-transform:uppercase;
    font-weight: 600; color:#fff; 
    letter-spacing:.5px;
    font-size: 12px;
}
#portfolio-details h4 { font-weight:400; font-size:25px; margin:5px 0;}
#portfolio-details h5 { font-weight:400; font-size:20px; margin:5px 0; }
.spacing-top1 { padding-top:80px;}
.spacing-top { padding-top:50px;}
.spacing-bottom { padding-bottom:50px;}
@media only screen and (max-width:380px){
.image-slider p { padding:5px; font-size:14px;}
}
.login-overlay { position:fixed; top:0; left:0; bottom:0; right:0; background:rgba(0,0,0,.6);display:none;  z-index:9999;}
.login-box { background:#fff; width:100%; max-width:480px; min-height:250px; margin:auto; display:none;}
.width-small { display:none;}
.width-large {     padding: 69px 0 0; text-align:center;} 
.width-large a {  font-size:17px; }
/*--------------form style------------->

 </style>
<style>
#embed-video {
position: fixed; overflow:hidden;	
    top: 0;
    left: 0;
    right: 0;
   bottom:0;
    z-index: 999999;
	}
	
	.close-video {
	position: fixed;
    z-index: 999999;
    color: #000;
    right: 60px;
	}
	/*----------------*/


.single-about-detail {
    position: relative;
    margin-bottom: 50px;
}	
.about-img img {
   /* height: 206px;*/
}
.about-img img {
    width: 100%;
}
.about-img img {
    width: 100% !important;
   
}

.about-details {
    background: #eee;
    border-top:0px solid #fff;
    transition: all .7s ease 0s;
    -webkit-transition: all .7s ease 0s;
    -moz-transition: all .7s ease 0s;
    -o-transition: all .7s ease 0s;
    -ms-transition: all .7s ease 0s;
}
.about-details {
    /*min-height:260px;*/
}
 body#home-page #main .container #where-to-buy-callout h3 {
    font-size: 20px;
}
body#home-page #main .container #where-to-buy-callout h3 {
    font-size: 15px;
    padding: 30px 0 10px 0;
    color: #7d4225;
}
.single-about-detail h3 {
    color: #000 !important;
    font-size:20px !important; padding:0 20px;
    line-height: 30px;
    text-transform: capitalize;
	font-weight: 400;
}
 
 
 

.single-about-detail p {
    color: #000 !important;  line-height:26px;
   
}
.about-details p {
    
    padding: 0 28px;
    padding-bottom: 30px;
}
 
 
.btn-read {
   /* position: absolute;
    bottom: 10px;  
    left:30%;  */
	
	display: block;
    margin: auto;
  /*  width: 132px;
	margin-top: -18px;*/
}
.btn-width {   margin: auto;  width: 132px; display:block;     padding-bottom: 16px;}

#share-title
{
text-align:center!important;
color:#000;padding:20px 0 0 0;
 font-family:inherit;
 }
 .close{
float:none; opacity:1;

}


</style>


<style>
.pricing {
  padding-bottom: 100px ;
}
.pricing-table {
  border: 1px solid #f2f2f2;
  border-radius: 5px;
  background-color: #fff;
  margin-top:10px;
}
.pricing-table .pricing-header .pt-price {
  font-family: Roboto, sans-serif;
  color: #4c4c4c;
  font-size: 28px;
  line-height: 40px;
  font-weight: 400;
  text-align: left;
  padding: 0px 40px;
}
.pricing-table .pricing-header .pt-price small {
  font-size: 14px;
  color: #9a9a9a;
  font-weight: 300;
  font-family: Roboto, sans-serif;
}
.pricing-table .pricing-header .pt-name {
 font-family: Roboto, sans-serif;
  padding: 10px 40px;
  text-align: left;
  font-weight: 500;
  font-size: 20px;
  line-height: 40px;
  color: #4c4c4c;
  border-top: 1px solid #f2f2f2;

}
.pricing-table .pricing-body ul {
  margin: 0;
  padding: 0;
  list-style: none;
  text-align:left
}
.pricing-table .pricing-body  {
  padding: 0px 25px;
font-family: Roboto, sans-serif;
    font-weight: 500;
	font-size:18px;
	
  margin: 0;
}
/*.pricing-table .pricing-body ul li:nth-child(even) {
  background-color: #fafafa;
}*/
.pricing-table .pricing-body ul li .fa-times {
  color: #ff6666;
}
.pricing-table .pricing-body ul li .fa-check {
  color: #2185c5;
}
.pricing-table .pricing-footer {
  text-align: left;
  padding: 15px 40px;
 /* border-top: 1px solid #f2f2f2;*/
   font-family: Roboto,sans-serif;
}
.pricing-table.featured .pricing-header {
  position: relative;
  overflow: hidden;
}
.pricing-table.featured .pricing-header .pt-price {
  color: #4ecdc4;
}
.pricing-table.featured .pricing-header .pt-price small {
  color: #4ecdc4;
}
.pricing-table.featured .pricing-header .pt-name {

  color: #4ecdc4;
}
.pricing-table.featured .pricing-header .featured-text {
  font-family: Roboto, sans-serif;
  font-size: 24px;
  line-height: 15px;
  letter-spacing: 1px;
  font-weight: 300;
  text-transform: uppercase;
  text-align: center;
  background-color: #4ecdc4;
  color: #fff;
  position: absolute;
  top: 22px;
  left: -28px;
  padding: 5px 0;
  width: 126px;
  -webkit-transform: rotate(-45deg);
      -ms-transform: rotate(-45deg);
          transform: rotate(-45deg);
}
.btn-default {
    color: #4285f4;

  border: 2px solid #4285f4;
}
.btn-default:hover {
  color: #fff;
   border: 2px solid #4285f4;

}
.pricing-plans__plan-price-bill {
    display: block;
    font-size: 16px;
    line-height: 20px;
    margin-bottom: 0;
 font-family: Roboto, sans-serif;
}
.pricing-plans__plan-price {
    color: #4285f4;
    display: block;
    font-size: 30px;
      font-family: Roboto, sans-serif;
    font-weight: 500;
    line-height: 1;
    margin-bottom: 0;
    margin-top: 20px;
}
.pricing-plans__original-price {
    color: #bdbdbd;
    font-size: 24px;
    text-decoration: line-through;
}
.pricing-plans__plan-intro {
    font-size: 15px;
    line-height: 22px;
    margin-bottom: 0;
	font-family: Roboto, sans-serif;
	padding: 0px 40px;
}
.btn {
 font-family: 'Roboto',arial,sans-serif;
  font-size: 16px;
  letter-spacing: 1px;
  border-radius: 40px;
  font-weight:400;
  padding: 8px 30px;
  margin-bottom: 5px;
  -webkit-transition: color 0.3s, background-color 0.3s, border-color 0.3s;
          transition: color 0.3s, background-color 0.3s, border-color 0.3s;
}
.btn-main {
  color: #fff;
  background-color: #4ecdc4;
  border-color: #4ecdc4;
}
.btn-main:hover,
.btn-main:focus,
.btn-main:active {
  background-color: #33b5ac;
  border-color: #33b5ac;
  color: #fff;
}
</style>
  <link rel='stylesheet'   href='assets/css/custom.css' type='text/css' media='all' />
 <link rel="stylesheet" href="assets/css/flexslider.css" type="text/css" media="screen" />
 
</head>
<body class="single single-post postid-3434 single-format-image nav-sticky">
				
		<div class="navbar navbar-fixed-top floating positive two" role="navigation">
			<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">
				<img src="assets/images/main-logo.png" data-alt="assets/images/main-logo.png" alt="">
				</a>
			</div>
		 <div class="collapse navbar-collapse" id="navbar-collapse"> 
			 	<ul id="menu-primary" class="nav navbar-nav navbar-right">
				<li ><a class="jumper" href="index.php">Home</a></li>
	  
	   
	  
				<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Solutions
						<span class="caret"></span></a>
						<ul class="dropdown-menu" >
						  <li><a href="reams_features.html">REAMS</a></li>    <li class="divider"></li>
						  <li><a href="idata_register.php">iDATA</a></li>
						  <li class="divider"></li>
						  <li><a href="assure.php">Assure</a></li>
					  
						</ul>
					</li>
	  
				
				<!--	<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" >Company
						<span class="caret"></span></a>
							<ul class="dropdown-menu ">
						  <li><a href="about.html">ABOUT US</a></li><li class="divider"></li>
						  	  	 	 <li><a href="http://pecanadvisors.com" target="_blank">PECAN ADVISORS</a></li>
					  
					  
						</ul>
					</li>-->
					
					
				<li  ><a class="jumper" href=" index.php#classroom">Classroom</a></li>
				
					<li  ><a href="pricing.php">Pricing</a></li>
				
					<li ><a class="jumper" href="index.php#map">Contact Us</a></li>
					
						<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" >Login
        <span class="caret"></span></a>
        	<ul class="dropdown-menu">
          <li><a href="https://www.pecanreams.com/app/" target="_blank">REAMS</a></li><li class="divider"></li>
          <li><a href="https://www.pecanreams.com/d3m/" target="_blank">iDATA</a></li>
      
        </ul>
      </li>
	  
	  <li><a href="register.php">REGISTER</a></li>
                 </ul>
 
			</div>
	 </div>
	</div>
<section class="section alt-background offsetTop blog-bg ">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<header>
					<h2 style=" text-align:left;color:white;">Pricing</h2>
			 <p class="info breadcrumbs" style="font-size:12px;"><span class="breadcrumbs_list" > <a href="index.php">Home ></a><a href="#">Pricing</a>  </span></p>
			</div>
		</div>
	</div>
</section>


<div class="row">
<div class="col-lg-12 col-md-12">
<div id="about-company">
  
 <section class="pricing" id="pricing">
			<div class="container">
				<div class="row">
					<h2 style="text-align: center;">Pricing</h2>
						
						<?php 
						$query = "select * from subscription";
						$result = mysqli_query($conn, $query); 
						while ($row = mysqli_fetch_assoc($result)) 
						{
							$strike_price=$row["monthly_package"]*12;
							
							print 
								'<div class="col-md-4">
						<div class="pricing-table" style="background:#fafafa;">
							<div class="pricing-header">
								<div class="pt-name">'.$row["package_name"].'</div>';
								if($row["num_of_prop"]!=null)
								{
									print '<div class="pt-price" >'.$row["num_of_prop"].' <small>No.Of Properties</small></div>';
										
								}
								else
								{
									print '<div class="pt-price" >'.$row["min_prop"].'-'.$row["max_prop"].' <small>No.Of Properties</small></div>';
								}
							print
							'<P class="pricing-plans__plan-intro">'.$row["description"].'</P>
							</div>
							<div class="pricing-body" style="padding: 0px 40px;">';
							
							if($row["monthly_package"]==0)
							{
								print'<div class="pricing-plans__plan-price">
							
							<span class="pricing-plans__original-price"	>  </span>
							&#8377 '.moneyFormatIndia($row["yearly_package"]).'
							
							</div>
							<p class="pricing-plans__plan-price-bill"> per year</p>
							
							
								
							</div><p> &nbsp </p><p> &nbsp </p>';
							}
							else
							{
								print '<div class="pricing-plans__plan-price">
							
								&#8377 '.moneyFormatIndia($row["monthly_package"]).'
			
									</div>
								<p class="pricing-plans__plan-price-bill"> per month</p>	
								<div class="pricing-plans__plan-price">
							
							<span class="pricing-plans__original-price"	> &#8377 '.moneyFormatIndia( $strike_price).' </span>
							&#8377 '.moneyFormatIndia($row["yearly_package"]).'
							
							</div>
							<p class="pricing-plans__plan-price-bill"> per year</p>
							
							
								
							</div>';
							}
							print'
							<div class="pricing-footer">
								<a href="register.php" class="btn btn-default">Get Started</a>
							</div>
						</div>
					</div>';
		
				}
	?>
					
					
					
						<!--<div class="col-md-4">
							<div class="pricing-table" style="background:#fafafa;">
							<div class="pricing-header">
								<div class="pt-name">Business</div>
								<div class="pt-price">21-50 <small>No.Of Properties</small></div>
							<P class="pricing-plans__plan-intro">Rs. 175 per property assuming full 50 Properties.</P>
							</div>
							<div class="pricing-body" style="padding: 0px 40px;">
							
							<div class="pricing-plans__plan-price">
							
					&#8377 8,750
						
							
							</div>
							<p class="pricing-plans__plan-price-bill"> per month</p>	
							
								<div class="pricing-plans__plan-price">
							
						<span class="pricing-plans__original-price"	> &#8377 1,05,000</span>
							&#8377 89,250
							
							</div>
							<p class="pricing-plans__plan-price-bill"> per year</p>
							
							
								
							</div>
							<div class="pricing-footer">
								<a href="#" class="btn btn-default">Get Started</a>
							</div>
						</div>
					</div>
				
				<div class="col-md-4">
							<div class="pricing-table" style="background:#fafafa;">
							<div class="pricing-header">
								<div class="pt-name">Enterprise</div>
								<div class="pt-price">Unlimited <small>No.Of Properties</small></div>
							<P class="pricing-plans__plan-intro">This includes managed services.</P>
							<P class="pricing-plans__plan-intro">&nbsp </P>
							</div>
							<div class="pricing-body" style="padding: 0px 40px;">
							<div class="pricing-plans__plan-price">
							
					&#8377  2,00,000
						
							
							</div>
							<p class="pricing-plans__plan-price-bill"> per year</p>	
							
								
								<br>
								<br>
							</div>
							
							<div class="pricing-footer">
								<a href="#" class="btn btn-default">Get Started</a>
							</div>
						</div>
					</div>-->
					
					
				
				
				</div>
			</div>
		</section>
  
 


</div>
</div>

<div  class="clear  "></div>




 
 
 


 
<footer class="footer  no-border">
	<div class="container offsetBottomS offsetTopS">
		<div class="row">
<div class="col-lg-4  col-md-4 col-sm-3 col-xs-12">
		<div class="housing-line">
<div class="footer-logo-coloured"> <a href="index.php"><img src="assets/images/main-logo.png" style="background:#fff; padding:5px 10px;" /> </a></div>
<!---<div class="desc">
Copyright 2016. All rights reserved.
</div>-->
</div>
	</div>	
<div class="col-lg-4  col-md-4 col-sm-5 col-xs-4 footer-clmn1">
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="footer-header">
<span class="footer-text">Company</span>
</div> 
<ul class="list-unstyled clear-margins ">
			<li><a  href="about.html"> About Us</a></li>
 <li><a href="http://pecanadvisors.com" target="_blank">Pecan Advisors</a></li>
			<li><a  href="index.php#map"> Contact Us</a></li> 
</ul>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
<div class="footer-header">
<span class="footer-text">Help</span>
</div> 
<ul class="list-unstyled clear-margins  " >
			<li><a  href="privacy-policy.html">  Privacy Policy</a></li>
			<li><a  href="terms-and-conditions.html">  Terms & Condition</a></li>    
</ul>
</div> 
</div>
<div class="col-lg-2  col-md-2 col-sm-2 col-xs-4	footer-clmn2">
<div class="footer-header">
<span class="footer-text">Solutions</span>
</div>
 
<ul class="list-unstyled clear-margins">
			<li><a  href="reams_features.html"> REAMS</a></li>
			<li><a  href="idata_register.php"> iDATA</a></li>
			<li><a  href="assure.php"> Assure</a></li>
			                         
		
</ul>
</div>

<div class="col-lg-2  col-md-2 col-sm-2 col-xs-4 footer-clmn3">
<div class="footer-header">
<span class="footer-text">Classroom</span>
</div>
 
<ul class="list-unstyled clear-margins">
			<li><a  href="blog" target="_blank"> Blogs</a></li>
</ul>
</div>

 
                
	   </div>
	</div>

<div class="footer-bottom"> 
	<div class="container  ">
		<div class="row">
				
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<div class="design">

					<a class="to-top"><i class="fa fa-angle-up"></i></a> 
				<!--	<a href="#">Privacy policy </a> |  
					<a target="_blank" href="#">Terms & Condition</a>-->

				</div>

			</div>
			
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<div class="copyright">	Copyright 2017.  All rights reserved.</div>

			</div>

				
		</div>
	</div>

 </div>
 
</footer>
<!--footer-->
 
 

<script>
var Prodo = {
	'loader': true,
	'animations': true,
	'navigation': 'sticky'
};
</script>
 <script src="js/jquery-2.1.4.min.js"></script>
  <script src="assets/bootstrap.min.js"></script>
 
	<script>
    $(document).ready(function(){
   
    $('a[href^="#"]').click(function(e) {

        jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top-80}, 1000);

        return false;

        e.preventDefault();

    });

});

	</script>
 <script src="assets/js/login.js"></script>
 
 <script src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-One-Page-Navigation-Plugin-Page-Scroll-To-ID/jquery.malihu.PageScroll2id.js"></script> 
<script>
		(function($){
			$(window).load(function(){
				
				/* Page Scroll to id fn call */
				$("#menu-primary a,a[href='#top'],a[rel='m_PageScroll2id']").mPageScroll2id({
					highlightSelector:"#menu-primary a"
				
				});
				
				/* demo functions */
				$("a[rel='next']").click(function(e){
					e.preventDefault();
					var to=$(this).parent().parent(" ").next().attr("id");
					$.mPageScroll2id("scrollTo",to);
					 
					 
					 
				});
				
				
			});
		})(jQuery);
	</script>

  <script defer src="assets/js/jquery.flexslider.js"></script> 
 <script type="text/javascript">
     
	 
	 
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 215,
		slideshow: false,
		 controlNav: false,
        itemMargin: 0,
        minItems:1,
        maxItems: 5  
      });
    });
	
	
	
  </script>
<script src="js/jquery.flip.min.js"></script>
<script>
    $(function(){
    	$(".flip-horizontal").flip({
  			trigger: 'hover'
		});
		$(".flip-vertical").flip({
			axis: 'x',
  			trigger: 'hover'
		});
		
		$(".one-hover").hover(function(){
			if($('.service-overlay').is(":visible")){
				$('.service-overlay').hide();
				$('.one-hover').css("z-index","9999");
				 
			}
			else {
				$('.service-overlay').slideDown("fast");
				$('.one-hover').css("z-index","999999");
				$('.two-hover').css("z-index","9");
				$('.three-hover').css("z-index","9");
				$('.four-hover').css("z-index","9");
				$('.five-hover').css("z-index","9");
				$('.six-hover').css("z-index","9");
				//$('.one-hover').css("background","#fff");
				
			}
		});
		
		$(".two-hover").hover(function(){
			if($('.service-overlay').is(":visible")){
				$('.service-overlay').hide();
				$('.two-hover').css("z-index","9999");		 
			}
			else {
				$('.service-overlay').slideDown("fast");
				$('.two-hover').css("z-index","999999");
				$('.one-hover').css("z-index","9");
				$('.three-hover').css("z-index","9");
				$('.four-hover').css("z-index","9");
				$('.five-hover').css("z-index","9");
				$('.six-hover').css("z-index","9");
				
			}
		});
		
		$(".three-hover").hover(function(){
			if($('.service-overlay').is(":visible")){
				$('.service-overlay').hide();
				$('.three-hover').css("z-index","9999");
				 
			}
			else {
				$('.service-overlay').slideDown("fast");
				$('.three-hover').css("z-index","999999");
				$('.one-hover').css("z-index","9");
				$('.two-hover').css("z-index","9");
				$('.four-hover').css("z-index","9");
				$('.five-hover').css("z-index","9");
				$('.six-hover').css("z-index","9");				 
			}
		});
		
		$(".four-hover").hover(function(){
			if($('.service-overlay').is(":visible")){
				$('.service-overlay').hide();
				$('.four-hover').css("z-index","9999");
				 
			}
			else {
				$('.service-overlay').slideDown("fast");
				$('.four-hover').css("z-index","999999");	
				$('.one-hover').css("z-index","9");
				$('.three-hover').css("z-index","9");
				$('.two-hover').css("z-index","9");
				$('.five-hover').css("z-index","9");
				$('.six-hover').css("z-index","9");
			}
		});
		
			
		$(".five-hover").hover(function(){
			if($('.service-overlay').is(":visible")){
				$('.service-overlay').hide();
				$('.five-hover').css("z-index","9999");
				 
			}
			else {
				$('.service-overlay').slideDown("fast");
				$('.five-hover').css("z-index","999999");	
				$('.one-hover').css("z-index","9");
				$('.three-hover').css("z-index","9");
				$('.four-hover').css("z-index","9");
				$('.two-hover').css("z-index","9");
				$('.six-hover').css("z-index","9");
			}
		});
		$(".six-hover").hover(function(){
			if($('.service-overlay').is(":visible")){
				$('.service-overlay').hide();
				$('.six-hover').css("z-index","9999");
				 
			}
			else {
				$('.service-overlay').slideDown("fast");
				$('.six-hover').css("z-index","999999");	
				$('.one-hover').css("z-index","9");
				$('.three-hover').css("z-index","9");
				$('.four-hover').css("z-index","9");
				$('.five-hover').css("z-index","9");
				$('.two-hover').css("z-index","9");
			}
		});
		
		$("#loginclick").click(function(){
			 
				$('.login-overlay').show();
				$('.login-box').show();
			//	$('.one-hover').css("z-index","9999");
				 
			 
		});
		
		$(".btn-cls").click(function(){
			// $('#login-modal').attr("aria-hidden","true");
			// $('#login-modal').removeClass("in");
			//	$('#login-modal').hide();
				$('#login-modal').modal('toggle');
			 
			//	$('.one-hover').css("z-index","9999");
				 
			 
		});
		
		
    });
  	</script>
	

	
	<script>
	$(document).ready(function(){
	 
		$('.video-control').click(function() {
			$('#embed-video').removeClass("hidden");
			$('.autocreate').removeClass("hidden");
			$('.video-section').attr("autoplay");
			var video = $(".video-section")[0]; // id or class of your <video> tag
if (video.paused) {
    video.play();
}    
			
		
		});
		
		$('.close-video').click(function() {
			$('#embed-video').addClass("hidden");
			$('.autocreate').addClass("hidden");
			var video = $(".video-section")[0]; // id or class of your <video> tag
if (video.play) {
    video.pause();
          video.currentTime = 0;
}    
		
		});
	});
	
	
	</script>

<script type='text/javascript' src='assets/bootstrap/js/bootstrap.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='https://maps.google.com/maps/api/js?key=AIzaSyBQ9dVY1A4D4HbKBhh7HuXY3QRwLMWhg88'></script>
<script type='text/javascript' src='assets/js/jquery.gmap.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/retina.min.js?ver=1.3.0'></script>

<script type='text/javascript' src='assets/js/smoothscroll.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/jquery.mb.ytplayer.min.js?ver=25062016'></script>
<script type='text/javascript' src='assets/js/jquery.parallax.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/jquery.isotope.min.js?ver=4.6.1'></script>


<script type='text/javascript' src='assets/js/jquery.scrollto.min.js?ver=2.1.3'></script>
<script type='text/javascript' src='assets/js/jquery.knob.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/prodo.min.js?ver=2.1'></script>
<script type='text/javascript' src='js/comment-reply.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='js/wp-embed.min.js?ver=4.6.1'></script>

 

  
</body>
</html>