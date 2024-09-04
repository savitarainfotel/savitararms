<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="sign-up contact section">
        <div class="container py-5">
            <div class="row gy-5 gy-xl-0 justify-content-center justify-content-lg-between">
                <div class="col-12 col-lg-7 col-xxl-8">
                    <form method="POST" autocomplete="off" id="frmContactus" class="sign-up__form wow fadeInDown" data-wow-duration="0.8s" novalidate="novalidate" style="visibility: visible; animation-duration: 0.8s; animation-name: fadeInDown;">
                        <h3 class="contact__title wow fadeInDown" data-wow-duration="0.8s" style="visibility: visible; animation-duration: 0.8s; animation-name: fadeInDown;">Get in touch with us.</h3>
                        <div class="sign-up__form-part">
                            <div class="input-group">
                                <div class="input-single">
                                    <label class="label" for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name..." required="">
                                </div>
                                <div class="input-single">
                                    <label class="label" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email..." required="">
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-single">
                                    <label class="label" for="phone">Phone</label>
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter Your Number..." required="">
                                </div>
                                <div class="input-single">
                                    <label class="label">Country</label>
                                    <select class="form-control cus-sel-active" style="display: none;">
                                        <option data-display="Country...">Country...</option>
                                        <option value="1">United States</option>
                                        <option value="2">Australia</option>
                                        <option value="4">Canada</option>
                                        <option value="4">France</option>
                                      </select><div class="nice-select form-control cus-sel-active" tabindex="0"><span class="current">Country...</span><ul class="list"><li data-value="Country..." data-display="Country..." class="option selected">Country...</li><li data-value="1" class="option">United States</li><li data-value="2" class="option">Australia</li><li data-value="4" class="option">Canada</li><li data-value="4" class="option">France</li></ul></div>
                                </div>
                            </div>
                            <div class="input-single">
                                <label class="label" for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="8" placeholder="Enter Your Message..." required=""></textarea>
                            </div>
                        </div>
                        <span id="msg"></span> 
                        <button type="submit" class="btn_theme btn_theme_active mt_40 " name="submit" id="submit">Send Message <i class="bi bi-arrow-up-right"></i><span></span></button>
                    </form>
                </div>
                <div class="col-12 col-lg-5 col-xxl-4">
                    <div class="more-help wow fadeInUp" data-wow-duration="0.8s" style="visibility: visible; animation-duration: 0.8s; animation-name: fadeInUp;">
                        <h3 class="contact__title wow fadeInUp" data-wow-duration="0.8s" style="visibility: visible; animation-duration: 0.8s; animation-name: fadeInUp;">Need more help?</h3>
                        <div class="more-help__content">
                            <div class="card card--small">
                                <div class="card--small-icon">
                                    <i class="bi bi-telephone"></i> 
                                </div>
                                <div class="card--small-content">
                                    <h5 class="card--small-title">Call Now</h5>
                                    <div class="gap-1 flex-column">
                                        <a href="tel:+1234567891" class="card--small-call">(123) 456-7891</a>
                                        <a href="tel:+1234567891" class="card--small-call">(907) 456-7891</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card card--small">
                                <div class="card--small-icon">
                                    <i class="bi bi-envelope-open"></i> 
                                </div>
                                <div class="card--small-content">
                                    <h5 class="card--small-title">Email Address</h5>
                                    <div class="gap-1 flex-column">
                                        <a href="mailto:info@example.com" class="card--small-call">info@example.com</a>
                                        <a href="mailto:info@example.com" class="card--small-call">info@example.com</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card card--small">
                                <div class="card--small-icon">
                                    <i class="bi bi-geo-alt"></i> 
                                </div>
                                <div class="card--small-content">
                                    <h5 class="card--small-title">Location</h5>
                                    <div class="gap-1 flex-column">
                                        <p>Royal Ln. Mesa, New Jersey 45463</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>