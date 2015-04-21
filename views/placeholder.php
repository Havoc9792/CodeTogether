   <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>
<style>
	.page-sidebar ~ .page-container {
  padding-left: 0px;
}
*{
  margin:0;
  padding:0;
}
.day{
	background-color: #15A19F;
}
body{
  font-family:Roboto !important;
}
article.preloader{
	

	z-index: 9998;
	position: fixed;
	width: 100%;
	height: 100%;
	text-align: center;

	background-image: url(http://rachouanrejeb.be/weather/images/assets/stars.png);
	background-size: 800px;
	background-position: top;
	background-repeat: repeat; 
	background-color: #185C69;

}
article.preloader header{
	position: absolute;
	top: 50%;
	left: 50%;
	width: 300px;
	margin-top: -150px;
	margin-left: -150px;
	color: white;
	text-transform: uppercase;
	font-size: 1em;
	letter-spacing: .2em;

}
article.preloader .earth{
	
	position: fixed;
	left: 50%;
	top: 60%;
	margin-left: -75px;
	margin-top: -75px;
	width: 150px;
	height: 150px;
	border-radius: 50%;
	background-image: url(http://rachouanrejeb.be/weather/images/assets/earth.png);
	background-size: cover;
	background-position: top left;
	background-repeat: repeat-x;
	
	
	-webkit-animation: earth 5s linear infinite;
	-moz-animation: earth 5s linear infinite;
	-ms-animation: earth 5s linear infinite;
	animation: earth 5s linear infinite;

}

article.preloader .satelite{
	
	position: fixed;
	left: 50%;
	top: 60%;
	margin-left: -100px;
	margin-top: -100px;
	width: 200px;
	height: 200px;
	border-radius: 50%;
	background-image: url(http://rachouanrejeb.be/weather/images/assets/satelite.png);
	background-size: contain;
	background-repeat: no-repeat;



	-webkit-animation: sat 2s linear infinite;
	-moz-animation: sat 2s linear infinite;
	-ms-animation: sat 2s linear infinite;
	animation: sat 2s linear infinite;

}

@keyframes earth {
  0% {background-position: 0px 0px;}
  100% {background-position: -193% 0px;}
}
@-moz-keyframes earth {
  0% {background-position: 0px 0px;}
  100% {background-position: -193% 0px;}
}
@-webkit-keyframes earth {
  0% {background-position: 0px 0px;}
  100% {background-position: -193% 0px;}
}
@-ms-keyframes earth {
 0% {background-position: 0px 0px;}
  100% {background-position: -193% 0px;}
}	



@keyframes sat {
   0% {

	-moz-transform: rotate(0deg);
	-webkit-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	transform: rotate(0deg);

  }
  100% {
	
	-moz-transform: rotate(360deg);
	-webkit-transform: rotate(360deg);
	-o-transform: rotate(360deg);
	-ms-transform: rotate(360deg);
	transform: rotate(360deg);

  }
}
@-moz-keyframes sat {
   0% {

	-moz-transform: rotate(0deg);
	-webkit-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	transform: rotate(0deg);

  }
  100% {
	
	-moz-transform: rotate(360deg);
	-webkit-transform: rotate(360deg);
	-o-transform: rotate(360deg);
	-ms-transform: rotate(360deg);
	transform: rotate(360deg);

  }
}
@-webkit-keyframes sat {
  0% {

	-moz-transform: rotate(0deg);
	-webkit-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	transform: rotate(0deg);

  }
  100% {
	
	-moz-transform: rotate(360deg);
	-webkit-transform: rotate(360deg);
	-o-transform: rotate(360deg);
	-ms-transform: rotate(360deg);
	transform: rotate(360deg);

  }
}
@-ms-keyframes sat {
  0% {

	-moz-transform: rotate(0deg);
	-webkit-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	transform: rotate(0deg);

  }
  100% {
	
	-moz-transform: rotate(360deg);
	-webkit-transform: rotate(360deg);
	-o-transform: rotate(360deg);
	-ms-transform: rotate(360deg);
	transform: rotate(360deg);

  }
}	
	
</style>

<article class="preloader">
	<header><h1 style="color: #FFF;   font-size: 25px; line-height: 25px;  font-family:Roboto !important; font-weight: 900; text-transform: none; letter-spacing: 3px;"><?= $param1 ?></h1></header>
	<section class="satelite"></section>
	<section class="earth day"></section>
	<p style="color: #FFF; font-size: 16px; font-family:Roboto !important; font-weight: 700; margin-top: 20px">Final Year Project Presentation</p>
</article>

<iframe style="opacity: 0" width="420" height="345" src="https://www.youtube.com/watch?v=GquEnoqZAK0?autoplay=1" frameborder="0" allowfullscreen></iframe>