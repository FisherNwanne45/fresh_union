<?php 
$pageName  = "Home";
include_once("header.php");
?>

<!-- sticky header end -->
<main>


    <!-- about breadcrumb area start -->
    <section class="breadcrumb__area pt-165 pb-150 p-relative z-index-1 fix text-capitalize" data-bg-color="#16243E">
        <div class="breadcrumb__bg" data-background="uss-modules/uss-bank/bank-home/assets/img/breadcrumb/bg.png"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumb__content">
                        <h3 class="breadcrumb__title">contact</h3>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__list text-center text-sm-end">
                            <span><a href="index.html">Home</a></span>
                            <span class="dvdr"><i class="fa-regular fa-angle-right"></i></span>
                            <span>contact</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about breadcrumb area end -->



    <!-- contact area start -->
    <section class="tp-contact-breadcrumb-area pt-120 pb-120">
        <div class="container">
            <div class="tp-contact-breadcrumb-box">
                <div class="tp-contact-breadcrumb-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="tp-contact-breadcrumb-content">
                            <h3 class="tp-contact-breadcrumb-title">Get in touch</h3>
                            <p>We are here for you! how can we help, We are here for you! </p>
                            <form id="contact-form"
                                action="https://template.wphix.com/finbest-prv/finbest/https://amcafipelo.com/uss-modules/uss-bank/bank-home/assets/mail.php"
                                method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tp-contact-input">
                                            <input name="name" type="text" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp-contact-input">
                                            <input name="email" type="email" placeholder="Email Here">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp-contact-input">
                                            <textarea name="message" placeholder="Message Here"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp-contact-breadcrumb-btn">
                                            <button type="submit" class="tp-btn">SUBMIT</button>
                                            <p class="ajax-response"></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="tp-contact-breadcrumb-wrapper">

                            <div class="tp-contact-breadcrumb-item mb-40 d-flex">
                                <div class="tp-contact-breadcrumb-item-icon">
                                    <span><i class="fa-solid fa-location-dot"></i></span>
                                </div>
                                <div class="tp-contact-breadcrumb-item-content">
                                    <h3 class="tp-contact-breadcrumb-item-title">Address</h3>
                                    <a href="https://www.google.com/maps"
                                        target="_blank"><?= $page['url_address'] ?></a>
                                </div>
                            </div>

                            <div class="tp-contact-breadcrumb-item mb-40 d-flex">
                                <div class="tp-contact-breadcrumb-item-icon">
                                    <span><i class="fa-solid fa-envelope"></i></span>
                                </div>
                                <div class="tp-contact-breadcrumb-item-content">
                                    <h3 class="tp-contact-breadcrumb-item-title">Mail Us</h3>
                                    <a href="mailto:<?= $page['url_email'] ?>"
                                        target="_blank"><?= $page['url_email'] ?></a>

                                </div>
                            </div>

                            <div class="tp-contact-breadcrumb-item d-flex">
                                <div class="tp-contact-breadcrumb-item-icon">
                                    <span><i class="fa-solid fa-phone"></i></span>
                                </div>
                                <div class="tp-contact-breadcrumb-item-content">
                                    <h3 class="tp-contact-breadcrumb-item-title">Telephone</h3>
                                    <a href="tel:<?= $page['url_tel'] ?>"><?= $page['url_tel'] ?></a>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact area end -->



    <!-- contact map area start -->
    <div class="tp-contact-map-area map-margin">
        <div class="tp-contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6311.195276483494!2d-122.46937946508179!3d37.72912131867138!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808f7dc87d56f1a9%3A0xecd4728ee92942b7!2sAptos%20Park!5e0!3m2!1sen!2sbd!4v1688876299603!5m2!1sen!2sbd"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <!-- contact map area end -->




</main>
<?php 
include_once("footer.php");
?>