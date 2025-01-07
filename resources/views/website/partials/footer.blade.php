     <!-- prs patner slider Start -->
     <div class="prs_patner_main_section_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="prs_heading_section_wrapper">
                        <h2>Đối tác</h2>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="prs_pn_slider_wraper">
                        <div class="owl-carousel owl-theme">
                            <div class="item">
                                <div class="prs_pn_img_wrapper">
                                    <img src="{{ asset('assets-website') }}/images/content/p1.jpg"
                                        alt="patner_img">
                                </div>
                            </div>
                            <div class="item">
                                <div class="prs_pn_img_wrapper">
                                    <img src="{{ asset('assets-website') }}/images/content/p2.jpg"
                                        alt="patner_img">
                                </div>
                            </div>
                            <div class="item">
                                <div class="prs_pn_img_wrapper">
                                    <img src="{{ asset('assets-website') }}/images/content/p3.jpg"
                                        alt="patner_img">
                                </div>
                            </div>
                            <div class="item">
                                <div class="prs_pn_img_wrapper">
                                    <img src="{{ asset('assets-website') }}/images/content/p4.jpg"
                                        alt="patner_img">
                                </div>
                            </div>
                            <div class="item">
                                <div class="prs_pn_img_wrapper">
                                    <img src="{{ asset('assets-website') }}/images/content/p5.jpg"
                                        alt="patner_img">
                                </div>
                            </div>
                            <div class="item">
                                <div class="prs_pn_img_wrapper">
                                    <img src="{{ asset('assets-website') }}/images/content/p6.jpg"
                                        alt="patner_img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- prs patner slider End -->
    <!-- prs Newsletter Wrapper Start -->
    <div class="prs_newsletter_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="prs_newsletter_text">
                        <h3>Nhận thông tin cập nhật, đăng ký ngay!</h3>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <div class="prs_newsletter_field">
                        <input type="text" placeholder="Enter Your Email">
                        <button type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- prs Newsletter Wrapper End -->
 <!-- prs footer Wrapper Start -->
 <div class="prs_footer_main_section_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="prs_footer_cont1_wrapper prs_footer_cont1_wrapper_1">
                    <h2>PHỤ ĐỀ PHIM</h2>
                    <ul>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">English movie</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">Vietnamese movie</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">Punjabi Movie</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">Hindi movie</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">Malyalam movie</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">English Action movie</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">Hindi Action movie</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="prs_footer_cont1_wrapper prs_footer_cont1_wrapper_2">
                    <h2>CÁC THỂ LOẠI PHIM</h2>
                    <ul>
                        @php
                            $categories = get_all_category(10) ?? [];
                            @endphp
                        @foreach($categories as $category)
                            <li>
                                <i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="{{ route('client.categories', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="prs_footer_cont1_wrapper prs_footer_cont1_wrapper_3">
                    <h2>ĐỐI TÁC ONLINE</h2>
                    <ul>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.beta.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.cgv.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.lotte.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.galaxy.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.mega.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.cinemax.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="prs_footer_cont1_wrapper prs_footer_cont1_wrapper_4">
                    <h2>Ứng dụng</h2>
                    <p>Download App and Get Free Movie Ticket !</p>
                    <ul>
                        <li>
                            <a href="#">
                                <img src="{{ asset('assets-website') }}/images/content/f1.jpg"
                                    alt="footer_img">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="{{ asset('assets-website') }}/images/content/f2.jpg"
                                    alt="footer_img">
                            </a>
                        </li>
                    </ul>
                    <h5><span>$50</span> Payback on App Download</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="prs_bottom_footer_wrapper"> <a href="javascript:" id="return-to-top"><i
            class="flaticon-play-button"></i></a>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                <div class="prs_bottom_footer_cont_wrapper">
                    <p>Copyright {{date('Y')}} <a href="#">Movie Pro</a> . All rights reserved - Design by <a
                            href="#">FPT POLY</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                <div class="prs_footer_social_wrapper">
                    <ul>
                        <li><a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#f7f7f7" d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/></svg>
                            </a>
                        </li>
                        <li><a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#fafafa" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>
                            </a>
                        </li>
                        <li><a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z"/></svg>
                            </a>
                        </li>
                        <li><a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/></svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- prs footer Wrapper End -->