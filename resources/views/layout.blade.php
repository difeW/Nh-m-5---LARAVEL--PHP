<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!---------Seo--------->
    <meta name="description" content="{{$meta_desc}}">
    <!-- metakeyword -->
    <meta name="robots" content="INDEX,FOLLOW" />
    <link rel="canonical" href="{{$url_canonical}}" />
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="" />

    {{-- <meta property="og:image" content="{{$image_og}}" />
    <meta property="og:site_name" content="http://localhost/tutorial_youtube/shopbanhanglaravel" />
    <meta property="og:description" content="{{$meta_desc}}" />
    <meta property="og:title" content="{{$meta_title}}" />
    <meta property="og:url" content="{{$url_canonical}}" />
    <meta property="og:type" content="website" /> --}}
    <!--//-------Seo--------->
    <title>{{$meta_title}}</title>
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/sweetalert.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{('frontend/images/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<!--/head-->

<body>

    <header id="header">
        <!--header-->
        <div class="header_top">
            <!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> 0932325268</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> musetechvn.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 title-header">
                        MuseTech
                    </div>
                    <div class="col-sm-4">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header_top-->
        <div style="background-color: var(--saphire-blue); height: 8px;"></div>

        <div class="header-middle">
            <!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu navbar-container">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{URL::to('/trang-chu')}}">Trang ch???</a></li>
                                <li class="dropdown"><a href="#">S???n ph???m<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach($category as $key => $danhmuc)
                                        <li><a
                                                href="{{URL::to('/danh-muc/'.$danhmuc->category_id)}}">{{$danhmuc->category_name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li><a href="{{URL::to('/gio-hang')}}">Gi??? h??ng</a></li>

                                <?php
                                $customer_id = Session::get('customer_id');
                                $shipping_id = Session::get('shipping_id');
                                if ($customer_id != NULL && $shipping_id == NULL) {
                                ?>
                                <li><a href="{{URL::to('/checkout')}}"> Thanh to??n</a></li>

                                <?php
                                } elseif ($customer_id != NULL && $shipping_id != NULL) {
                                ?>
                                <li><a href="{{URL::to('/payment')}}"> Thanh to??n</a></li>
                                <?php
                                } else {
                                ?>
                                <li><a href="{{URL::to('/dang-nhap')}}"> Thanh to??n</a></li>
                                <?php
                                }
                                ?>


                                <?php
                                $customer_id = Session::get('customer_id');
                                if ($customer_id != NULL) {
                                ?>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                        <span class="username">
                                            <?php
                                                $name = Session::get('customer_name');
                                                if ($name) {
                                                    echo $name;
                                                }
                                                ?>
                                        </span>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu extended logout">
                                        <!-- <li><a href="#"></i>Profile</a></li> -->
                                        <li><a href="{{URL::to('/handcash')}}"> ????n mua</a></li>
                                        <li><a href="{{URL::to('/logout-checkout')}}">????ng xu???t</a></li>
                                    </ul>
                                </li>
                                <?php
                                } else {
                                ?>
                                <li><a href="{{URL::to('/dang-nhap')}}">T??i kho???n</a></li>
                                <?php
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <form action="{{URL::to('/tim-kiem')}}" method="POST">
                            {{csrf_field()}}
                            <div class="search_box search_container">
                                <input type="text" name="keywords_submit" class="search_box-text"
                                    placeholder="T??m ki???m s???n ph???m" />
                                <input type="submit" name="search_items" class="search_box-button" value="T??m ki???m">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-middle-->

        <!--/header-bottom-->
    </header>
    <!--/header-->
    <section id="slider">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>
                        <style type="text/css">
                        img.img.img-responsive.img-slider {
                            height: 350px;
                        }
                        </style>
                        <div class="carousel-inner">
                            <?php
                            $i = 0;
                            ?>
                            @foreach($slider as $key => $slide)
                            <?php
                            $i++;
                            ?>
                            <div class="item {{$i==1 ? 'active' : '' }}">

                                <div class="col-sm-12">
                                    <img alt="{{$slide->slider_desc}}"
                                        src="{{asset('uploads/slider/'.$slide->slider_image)}}" height="100"
                                        width="120%" class="img img-responsive img-slider">

                                </div>
                            </div>
                            @endforeach
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            @yield('content')
        </div>
    </section>

    <footer id="footer">
        <!--Footer-->
        <div class="footer-top">
            <!-- <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>e</span>-shopper</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{asset ('frontend/images/iframe1.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                         <img src="{{ asset('frontend/images/iframe2.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                         <img src="{{asset('frontend/images/iframe3.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                         <img src="{{asset('frontend/images/iframe4.png')}}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="images/home/map.png" alt="" />
                            <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

            <div class="footer-widget">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="single-widget">
                                <h2>Ch??nh s??ch d???ch v???</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#">H??? tr??? tr???c tuy???n</a></li>
                                    <li><a href="#">V??? sinh s???n ph???m tr???n ?????i</a></li>
                                    <li><a href="#">Giao h??ng t???n nh??</a></li>
                                    <li><a href="#">?????i tr??? s???n ph???m</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="single-widget">
                                <h2>C??c chi nh??nh c???a MuseTech</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#">Chi nh??nh 1: 14 C???ng H??a, Qu???n T??n B??nh, TpHCM</a></li>
                                    <li><a href="#">Chi nh??nh 2: 2 L??? B??n B??ch, Qu???n T??n Ph??, TpHCM</a></li>
                                    <li><a href="#">Chi nh??nh 3: 15 Nguy???n Tr??i, Qu???n Ho??n Ki???m, tpHN</a></li>
                                    <li><a href="#">Chi nh??nh 4: 521 C??ch M???ng Th??ng 8, Qu???n 3, TpHCM</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="single-widget">
                                <h2>Nh???n tin khuy???n m??i</h2>
                                <form action="#" class="searchform">
                                    <input type="text" class="single-widget-input"
                                        placeholder="?????a ch??? email c???a b???n" />
                                    <button type="submit" class="btn btn-default single-widget-button"><i
                                            class="fa fa-arrow-circle-o-right"></i></button>
                                    <p>Nh???n nh???ng th??ng tin khuy???n m??i s???m nh???t t??? MuseTech<br />musetech@gamil.com</p>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div style="background-color: var(--saphire-blue); height: 8px;"></div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <p class="pull-left">MuseTech: <span style="color: var(--dark-blue);">Ph???ng s??? ?????t n?????c v?? con
                                ng?????i</span></p>
                        <p class="pull-right">Designed by <span><a target="_blank"
                                    href="https://github.com/difeW/https---github.com-difeW-Nhom5-Laravel">Team's
                                    Git</a></span></p>
                    </div>
                </div>
            </div>

    </footer>
    <!--/Footer-->



    <script src="{{asset('frontend/js/jquery.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('frontend/js/price-range.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>


    <script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
    <script>paypal.Buttons().render('body');</script> --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=2339123679735877&autoLogAppEvents=1">
    </script>


    <script type="text/javascript">
    $(document).ready(function() {
        $('.send-order').click(function() {
            Swal.fire({
                    title: "X??c nh???n ????n h??ng",
                    text: "????n h??ng s??? kh??ng ???????c ho??n tr??? khi ?????t,b???n c?? mu???n ?????t kh??ng?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "C???m ??n, Mua h??ng",

                    cancelButtonText: "????ng,ch??a mua",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var shipping_email = $('.shipping_email').val();
                        var shipping_name = $('.shipping_name').val();
                        var shipping_address = $('.shipping_address').val();
                        var shipping_phone = $('.shipping_phone').val();
                        var shipping_notes = $('.shipping_notes').val();
                        var shipping_method = $('.payment_select').val();
                        var order_fee = $('.order_fee').val();
                        var order_coupon = $('.order_coupon').val();
                        var _token = $('input[name="_token"]').val();

                        $.ajax({
                            url: '{{url(' / confirm - order ')}}',
                            method: 'POST',
                            data: {
                                shipping_email: shipping_email,
                                shipping_name: shipping_name,
                                shipping_address: shipping_address,
                                shipping_phone: shipping_phone,
                                shipping_notes: shipping_notes,
                                _token: _token,
                                order_fee: order_fee,
                                order_coupon: order_coupon,
                                shipping_method: shipping_method
                            },
                            success: function() {
                                swal("????n h??ng",
                                    "????n h??ng c???a b???n ???? ???????c g???i th??nh c??ng",
                                    "success");
                            }
                        });

                        window.setTimeout(function() {
                            location.reload();
                        }, 3000);

                    } else {
                        swal("????ng", "????n h??ng ch??a ???????c g???i, l??m ??n ho??n t???t ????n h??ng", "error");

                    }

                });


        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        //alert('1');
        $('.add-to-cart').click(function() {
            $.ajax({
                url: "demo_test.txt",
                success: function(url) {
                    alert('1');
                }
            });
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.add-to-cart').click(function() {
            var id = $(this).data('id_product');

            var cart_product_id = $('.cart_product_id_' + id).val();
            var cart_product_name = $('.cart_product_name_' + id).val();
            var cart_product_image = $('.cart_product_image_' + id).val();
            var cart_product_quantity = $('.cart_product_quantity_' + id).val();
            var cart_product_price = $('.cart_product_price_' + id).val();
            var cart_product_qty = $('.cart_product_qty_' + id).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('/add-cart-ajax')}}",
                method: "POST",
                data: {
                    cart_product_id: cart_product_id,
                    cart_product_name: cart_product_name,
                    cart_product_image: cart_product_image,
                    cart_product_price: cart_product_price,
                    cart_product_qty: cart_product_qty,
                    _token: _token,
                    cart_product_quantity: cart_product_quantity
                },
                success: function() {
                    Swal.fire({
                        title: "???? th??m s???n ph???m v??o gi??? h??ng",
                        text: "B???n c?? th??? mua h??ng ti???p ho???c t???i gi??? h??ng ????? ti???n h??nh thanh to??n",
                        showCancelButton: true,
                        cancelButtonText: "Xem ti???p",
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "??i ?????n gi??? h??ng",
                        closeOnConfirm: false
                    }).then((t) => {
                        if (t.isConfirmed) {
                            window.location.href = "{{url('/gio-hang')}}";
                        }
                    });
                }
            });
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.choose').on('change', function() {
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if (action == 'city') {
                result = 'province';
            } else {
                result = 'wards';
            }
            $.ajax({
                url: '{{url(' / select - delivery - home ')}}',
                method: 'POST',
                data: {
                    action: action,
                    ma_id: ma_id,
                    _token: _token
                },
                success: function(data) {
                    $('#' + result).html(data);
                }
            });
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.calculate_delivery').click(function() {
            var matp = $('.city').val();
            var maqh = $('.province').val();
            var xaid = $('.wards').val();
            var _token = $('input[name="_token"]').val();
            if (matp == '' && maqh == '' && xaid == '') {
                alert('L??m ??n ch???n ????? t??nh ph?? v???n chuy???n');
            } else {
                $.ajax({
                    url: '{{url(' / calculate - fee ')}}',
                    method: 'POST',
                    data: {
                        matp: matp,
                        maqh: maqh,
                        xaid: xaid,
                        _token: _token
                    },
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
    });
    </script>
</body>

</html>