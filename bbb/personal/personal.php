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
                        <h3 class="breadcrumb__title">personal / private banking</h3>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__list text-center text-sm-end">
                            <span><a href="index.html">Home</a></span>
                            <span class="dvdr"><i class="fa-regular fa-angle-right"></i></span>
                            <span>personal / private banking</span>
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
                        <h3 class="tp-service-details-title">Our Personal Checking Account </h3>
                        <p>Anyone who opens a personal checking account may apply for a free Narvigrant CheckCard. It's
                            the card that works like a check, anywhere VISA is accepted. It also serves as an ATM card
                            at any PULSE/CIRRUS/DASH affiliated Automatic Teller Machine or PULSEPAY terminal. Choose
                            your own Personal Identification Number (PIN) at your nearest Narvigrant location.</p>
                        <p>There is no fee for withdrawals or transactions at ATMs we operate. There is a fee for
                            transactions at other ATMs. There is no charge or annual fee for using the CheckCard in
                            place of writing a check. No identification or checkbook to carry. All CheckCard purchases
                            are identified on your monthly statement.</p>

                        <div class="tp-service-details-box d-flex mb-60">
                            <div class="tp-service-details-item d-flex mr-30">
                                <div class="tp-service-details-icon">
                                    <img src="uss-modules/uss-bank/bank-home/assets/img/service/service-details/icon-1.svg"
                                        alt="">
                                </div>
                                <div class="tp-service-details-content">
                                    <h3 class="tp-service-details-subtitle">Secure financial services</h3>
                                    <p>Whether you're facing retirement or looking to better understand certain
                                        investment ideas, we can help you address your most pressing money questions.
                                    </p>
                                </div>
                            </div>

                            <div class="tp-service-details-item d-flex">
                                <div class="tp-service-details-icon">
                                    <img src="uss-modules/uss-bank/bank-home/assets/img/service/service-details/icon-2.svg"
                                        alt="">
                                </div>
                                <div class="tp-service-details-content">
                                    <h3 class="tp-service-details-subtitle">Good investments</h3>
                                    <p>If you're not sure the best place to park your money for the long-term, we have 7
                                        investment options that will put your money to work.</p>
                                </div>
                            </div>
                        </div>

                        <div class="tp-service-details-box-2 d-flex mb-40">
                            <div class="tp-service-details-box-content mr-30">
                                <h3 class="tp-service-details-subtitle-2">Accumulation goals</h3>
                                <p>Generally, the goal is to keep funds invested, reinvest income and capital gains, and
                                    have these compound for as long as possible.</p>
                                <p>Membership Home; Become a Member; Open a Savings, Checking, Residence and
                                    Non-Residence Account, (Sign up Required) Get Involved.</p>
                            </div>
                            <div class="tp-service-details-box-thumb">
                                <img src="uss-modules/uss-bank/bank-home/assets/img/service/service-details/img-2.jpg"
                                    alt="">
                            </div>
                        </div>

                        <div class="tp-service-details-quote">
                            <span>Some businesses are inherently more profitable than others. This can be due to
                                expenses and overhead being low or the business charging a lot for its services or
                                products. Still, all businesses, no matter how profitable they are, can be a challenge
                                getting started. If you are thinking of starting a small business, you might care about
                                potential profits.</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="tp-service-widget">
                        <div class="tp-service-widget-item mb-40">
                            <div class="tp-service-widget-tab">
                                <h3 class="tp-service-widget-title">Our service</h3>
                                <ul>
                                    <li class="active"><a>Finance & Banking</a></li>
                                    <li><a>Business Advice</a></li>
                                    <li><a>Stock market</a></li>
                                    <li><a>Foreign Exchange</a></li>
                                    <li><a>Precious metal</a></li>
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
                            <a href="#"><span>Download Profile <img
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