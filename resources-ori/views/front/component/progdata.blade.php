<div id="content" class="site-content ">
    <div class="container">
        <div class="row default_row">
            <div class="full_width_box">
                <!--===============spacing==============-->
                <div class="pd_top_80"></div>
                <!--===============spacing==============-->
                <section class="section__counter four_column">
                    <div class="grid_show_case grid_layout clearfix">
                        <div class="grid_box _card">
                            <div class="counter-block style_two count-box">
                                <div class="icon_box   icon_yes ">
                                    <div class="icon">
                                        <span class="fa fa-graduation-cap"></span>
                                    </div>
                                </div>
                                <div class="coun_ter mt-4">
                                    <span class="count-text">{{ $program->age }}</span>
                                </div>
                                <div class="content_box">
                                    <h6>Years Old</h6>
                                </div>
                            </div>
                        </div>
                        <div class="grid_box _card">
                            <div class="counter-block style_two count-box">
                                <div class="icon_box icon_yes">
                                    <div class="icon">
                                        <span class="fa fa-trophy"></span>
                                    </div>
                                </div>
                                <div class="coun_ter mt-4">
                                    <span class="count-text" data-speed="1500"
                                        data-stop="{{ $program->weekly }}"></span>
                                </div>
                                <div class="content_box">
                                    <h6>Days in a week</h6>
                                </div>
                            </div>
                        </div>
                        <div class="grid_box _card">
                            <div class="counter-block style_two count-box">
                                <div class="icon_box   icon_yes ">
                                    <div class="icon">
                                        <span class="fa fa-users"></span>
                                    </div>
                                </div>
                                <div class="coun_ter mt-4">
                                    <span class="count-text" data-speed="1500"
                                        data-stop="{{ $program->periode }}"></span>
                                    <small></small>
                                </div>
                                <div class="content_box">
                                    <h6>Hours in a day</h6>
                                </div>
                            </div>
                        </div>
                        <div class="grid_box _card">
                            <div class="counter-block style_two count-box">
                                <div class="icon_box icon_yes">
                                    <div class="icon">
                                        <span class="fa fa-address-book"></span>
                                    </div>
                                </div>
                                <div class="coun_ter mt-4">
                                    <span class="count-text" data-speed="1500"
                                        data-stop="{{ $program->class_size }}"></span>
                                </div>
                                <div class="content_box">
                                    <h6>Student in a Class</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--===============spacing==============-->
                <div class="pd_bottom_30"></div>
                <!--===============spacing==============-->
            </div>
        </div>
    </div>
</div>
