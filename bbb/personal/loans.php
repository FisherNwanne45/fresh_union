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
                        <h3 class="breadcrumb__title">loans</h3>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__list text-center text-sm-end">
                            <span><a href="index.html">Home</a></span>
                            <span class="dvdr"><i class="fa-regular fa-angle-right"></i></span>
                            <span>loans</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about breadcrumb area end -->




    <!-- service area start -->
    <section class="tp-service-details-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="tp-service-details-wrapper">
                        <div class="tp-service-details-thumb">
                            <img src="uss-modules/uss-bank/bank-home/assets/img/service/service-details/img-1.jpg"
                                alt="">
                        </div>
                        <h3 class="tp-service-details-title"><?= $page['url_name'] ?> Loan Profile </h3>
                        <p><?= $page['url_name'] ?> makes installment loans at all of our full-service bank locations,
                            with friendly, helpful loan officers.</p>

                        <p>If you are ready to purchase an automobile or truck, whether new or used, we are ready to
                            finance the vehicle for you. We have competitive interest rates and terms on auto loans.</p>

                        <p>If you have been considering a recreational vehicle, motor home, boat or other leisure
                            vehicle, we can loan the money you need, with a repayment plan to suit you.</p>

                        <p>Every individual and family has unique needs. Situations arise when you need to borrow money
                            for special needs, whether it's a dream vacation, or an emergency. It's times like these
                            that <?= $page['url_name'] ?> can help. We are the financial friends you like to have.</p>

                        <p>For important needs in life that requires a Personal Loan, see your <?= $page['url_name'] ?>
                            loan officer right away. If you do not already have a loan officer, we will be happy to
                            introduce you to the right banker. We also make Personal Loans secured by stocks,
                            certificates of deposit, or other personal assets.</p>

                        <p>We take pride in helping families with affordable solutions to their money needs. Contact
                            your nearest <?= $page['url_name'] ?> Branches.</p>






                        <div class="tp-service-details-box-2 d-flex mb-40">
                            <div class="tp-service-details-box-content mr-30">
                                <h3 class="tp-service-details-subtitle-2">Understanding Loan</h3>
                                <p> loans can serve various purposes, such as funding personal expenses, purchasing a
                                    home (mortgage loan), buying a car (auto loan), financing education (student loan),
                                    or supporting business operations (business loan).</p>
                                <p>Borrowers typically need to submit an application to the bank, providing information
                                    about their financial situation, credit history, and the purpose of the loan. The
                                    bank evaluates the application and, if approved, determines the terms and conditions
                                    of the loan.</p>
                            </div>
                            <div class="tp-service-details-box-thumb">
                                <img src="uss-modules/uss-bank/bank-home/assets/img/service/service-details/img-2.jpg"
                                    alt="">
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="tp-service-widget">
                        <div class="tp-service-widget-item mb-40">
                            <div class="tp-service-widget-tab">
                                <h3 class="tp-service-widget-title">Available Loan</h3>
                                <ul>
                                    <li class="active"><a>Car Loan</a></li>
                                    <li><a>Business Growth Loan</a></li>
                                    <li><a>House/Logistics Loan</a></li>
                                    <li><a>Contract Execution Loan</a></li>
                                    <li><a>Security Grant Loan</a></li>
                                    <li><a>Educational Loan</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="tp-service-widget-contact mb-40"
                            data-background="uss-modules/uss-bank/bank-home/assets/img/service/service-details/img-3.jpg">
                            <div class="tp-service-widget-contact-content text-center">
                                <div class="tp-service-widget-contact-icon">
                                    <span><i class="fa-solid fa-phone"></i></span>
                                </div>
                                <p>Requesting A Call:</p>
                                <a href="tel:<?= $page['url_tel'] ?>"><?= $page['url_tel'] ?></a>
                            </div>
                        </div>

                        <div class="tp-service-widget-download mb-40">
                            <a href="#"><span>Download Loan Profile <img
                                        src="uss-modules/uss-bank/bank-home/assets/img/service/service-details/icon-3.svg"
                                        alt=""></span></a>
                        </div>

                        <div class="tp-service-widget-list">
                            <div class="tp-service-widget-list-content">
                                <ul>
                                    <li><i class="fa-light fa-circle-check"></i> Come to <?= $page['url_name'] ?> </li>
                                    <li><i class="fa-light fa-circle-check"></i> Download my<?= $page['url_name'] ?>
                                        Mobile </li>
                                    <li><i class="fa-light fa-circle-check"></i> Log in to my<?= $page['url_name'] ?>
                                        Web</li>
                                    <li><i class="fa-light fa-circle-check"></i> Get my<?= $page['url_name'] ?> Quick
                                        Loan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- service area end -->



</main>
<?php 
include_once("footer.php");
?>