<?php 
require_once("include/portal/header.php");
?>
   
<?php 
require_once("include/portal/topbar.php");
?>
<?php 
require_once("include/portal/nav.php");
?>
<?php 
require_once("pages/portal/top_vg.php");
?>
<?php 
require_once("pages/portal/about.php");
?>
<?php 
require_once("pages/portal/service.php");
?>
<?php 
require_once("pages/portal/facts.php");
?>
<?php 
require_once("pages/portal/causes.php");
?>
<?php 
require_once("pages/portal/donate.php");
?>
<?php 
require_once("pages/portal/event.php");
?>
<?php 
require_once("pages/portal/team.php");
?>
<?php 
require_once("pages/portal/volunteer.php");
?>
<?php 
require_once("pages/portal/testimonial.php");
?>
   
    
   
   
    
  

  
   
    <div class="contact">
        <div class="container">
            <div class="section-header text-center">
                <p>Get In Touch</p>
                <h2>Contact for any query</h2>
            </div>
            <div class="contact-img">
                <img src="assets/img/contact.jpg" alt="Image">
            </div>
            <div class="contact-form">
                <div id="success"></div>
                <form name="sentMessage" id="contactForm" novalidate="novalidate">
                    <div class="control-group">
                        <input type="text" class="form-control" id="name" placeholder="Your Name" required="required" data-validation-required-message="Please enter your name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="email" class="form-control" id="email" placeholder="Your Email" required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" class="form-control" id="subject" placeholder="Subject" required="required" data-validation-required-message="Please enter a subject" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea class="form-control" id="message" placeholder="Message" required="required" data-validation-required-message="Please enter your message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-custom" type="submit" id="sendMessageButton">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="blog">
        <div class="container">
            <div class="section-header text-center">
                <p>Our Blog</p>
                <h2>Latest news & articles directly from our blog</h2>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="blog-item">
                        <div class="blog-img">
                            <img src="assets/img/img/blog-1.jpg" alt="Image">
                        </div>
                        <div class="blog-text">
                            <h3><a href="#">Maternity & Health Care for Rural Woman</a></h3>
                            <p>
                               Maternity and healthcare for rural women faces unique challenges, including limited access to facilities, transportation barriers, and <a href="blog.php">more</a>
                            </p>
                        </div>
                        <div class="blog-meta">
                            <p><i class="fa fa-user"></i><a href="">Admin</a></p>
                            <p><i class="fa fa-comments"></i><a href="">15 Comments</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item">
                        <div class="blog-img">
                            <img src="assets/img/img/blog-2.jpg" alt="Image">
                        </div>
                        <div class="blog-text">
                            <h3><a href="#">Distributing Book to the Children for Better Future </a></h3>
                            <p>
                                Distributing books to children is a vital investment in their future, fostering literacy, education, and overall development. By <a href="blog.php">more</a> 
                            </p>
                        </div>
                        <div class="blog-meta">
                            <p><i class="fa fa-user"></i><a href="">Admin</a></p>
                            <p><i class="fa fa-comments"></i><a href="">15 Comments</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item">
                        <div class="blog-img">
                            <img src="assets/img/img/blog-3.jpg" alt="Image">
                        </div>
                        <div class="blog-text">
                            <h3><a href="#">Help and  Care Disable Children</a></h3>
                            <p>
                               Providing care and support for disabled children involves a multi-faceted approach, encompassing healthcare, education, social services, and <a href="blog.php">more</a>
                            </p>
                        </div>
                        <div class="blog-meta">
                            <p><i class="fa fa-user"></i><a href="">Admin</a></p>
                            <p><i class="fa fa-comments"></i><a href="">15 Comments</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
require_once("include/portal/footer.php");
?>

    