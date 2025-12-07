<?php
$pageName  = "Home";
include_once("header.php");
?>
<!-- sticky header start -->

<!-- sticky header end -->
<main>


    <!-- about breadcrumb area start -->
    <section class="breadcrumb__area pt-165 pb-150 p-relative z-index-1 fix text-capitalize" data-bg-color="#16243E">
        <div class="breadcrumb__bg" data-background="uss-modules/uss-bank/bank-home/assets/img/breadcrumb/bg.png"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumb__content">
                        <h3 class="breadcrumb__title">credits</h3>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__list text-center text-sm-end">
                            <span><a href="index.html">Home</a></span>
                            <span class="dvdr"><i class="fa-regular fa-angle-right"></i></span>
                            <span>credits</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about breadcrumb area end -->



    <!-- postbox area start -->
    <section class="tp-postbox-area pt-120 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-xl-8 col-lg-8">
                    <div class="tp-postbox-wrapper">
                        <article class="tp-postbox-item mb-50">
                            <div class="tp-postbox-thumb p-relative">
                                <a href="blog-details.html">
                                    <img src="uss-modules/uss-bank/bank-home/assets/img/blog/postbox/img-1.jpg" alt="">
                                </a>

                            </div>
                            <div class="tp-postbox-content">

                                <h3 class="tp-postbox-title">
                                    <a>Building digital experiences that matter</a>
                                </h3>
                                <div class="tp-postbox-text">
                                    <p>

                                        This is an insured investment account which pays higher interest and provides
                                        check writing privileges.</p>

                                    <p>You will receive monthly statements, along with images of your cancelled checks.
                                        There is limited check writing on money market accounts. You may have up to six
                                        debit transactions a month at no fee, with only three by check or debit card as
                                        limited by regulation.</p>

                                    <p>The Money Market Account earns interest when your daily collected balance is
                                        <?php echo $curr; ?>1000 or more. Interest is compounded and paid monthly into your account.</p>

                                    <p>There is a monthly fee of <?php echo $curr; ?>5 for the Money Market Account. You can avoid the fee
                                        with a <?php echo $curr; ?>1000 minimum daily balance, or a <?php echo $curr; ?>2000 average monthly balance.</p>

                                    <p>Individuals and businesses are eligible for Money Market Accounts. Overdraft
                                        Privilege available after qualifying period.</p>

                                    <p>Open this account with a minimum opening deposit of <?php echo $curr; ?>1000 at your nearest
                                        <?= $page['url_name'] ?> location.
                                    </p>



                                    <p>Our Small Business Checking is the best value for businesses in the Belgium and
                                        environ!</p>

                                    <p>There is no minimum balance requirement. You'll receive monthly statements with
                                        images of your cancelled checks.</p>

                                    <p>The monthly fee is <?php echo $curr; ?>10. Your business may have up to 100 checks per month with no
                                        check fee. If more than 100 checks, the fee is 20 cents per check.</p>
                                    <p>Your account may have up to 300 deposited items per month at no fee. If more than
                                        300 items, the fee is 5 cents per item.</p>



                                </div>

                            </div>





                    </div>
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-4">


                    <div class="tp-sidebar-widget mb-40">
                        <h3 class="tp-sidebar-widget-title">Credits Details</h3>
                        <div class="tp-sidebar-widget-content">
                            <ul>
                                <li><a><i class="fa-solid fa-chevrons-right"></i> Agency</a></li>
                                <li><a><i class="fa-solid fa-chevrons-right"></i> Corporate</a></li>
                                <li><a><i class="fa-solid fa-chevrons-right"></i> Business</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="tp-sidebar-widget mb-40">
                        <h3 class="tp-sidebar-widget-title">Banking Services</h3>
                        <div class="tp-sidebar-widget-content">
                            <div class="tp-sidebar-post tp-rc__post">
                                <div class="tp-rc__post d-flex align-items-center">
                                    <div class="tp-rc__post-thumb mr-25">
                                        <a><img src="uss-modules/uss-bank/bank-home/assets/img/blog/postbox/img-5.jpg"
                                                alt=""></a>
                                    </div>
                                    <div class="tp-rc__post-content">
                                        <h3 class="tp-rc__post-title">
                                            <a>Investment/ Benefit Care Taking</a>
                                        </h3>

                                    </div>
                                </div>
                                <div class="tp-rc__post d-flex align-items-center">
                                    <div class="tp-rc__post-thumb mr-25">
                                        <a><img src="uss-modules/uss-bank/bank-home/assets/img/blog/postbox/img-6.jpg"
                                                alt=""></a>
                                    </div>
                                    <div class="tp-rc__post-content">
                                        <h3 class="tp-rc__post-title">
                                            <a>Business Cash Management</a>
                                        </h3>

                                    </div>
                                </div>
                                <div class="tp-rc__post d-flex align-items-center">
                                    <div class="tp-rc__post-thumb mr-25">
                                        <a><img src="uss-modules/uss-bank/bank-home/assets/img/blog/postbox/img-7.jpg"
                                                alt=""></a>
                                    </div>
                                    <div class="tp-rc__post-content">
                                        <h3 class="tp-rc__post-title">
                                            <a>Foreign Exchange Risk Management</a>
                                        </h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tp-sidebar-work mb-40 p-relative"
                        data-background="uss-modules/uss-bank/bank-home/assets/img/blog/postbox/img-8.jpg">
                        <h3 class="tp-sidebar-work-title text-center">Work with us</h3>
                        <div class="tp-sidebar-work-content text-center">
                            <div class="tp-sidebar-work-icon">
                                <span><img src="uss-modules/uss-bank/bank-home/assets/img/blog/postbox/icon-1.svg"
                                        alt=""></span>
                            </div>
                            <p><?= $page['url_name'] ?> is licensed by the WB</p>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- postbox area end -->




</main>
<?php
include_once("footer.php");
?>