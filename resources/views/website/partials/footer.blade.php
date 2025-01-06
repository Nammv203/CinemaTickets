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
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">Tamil movie</a>
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
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.example.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.hello.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.example.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.hello.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.example.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.hello.com</a>
                        </li>
                        <li><i class="fa fa-circle"></i> &nbsp;&nbsp;<a href="#">www.example.com</a>
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
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-youtube-play"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- prs footer Wrapper End -->