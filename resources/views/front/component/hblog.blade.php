<section class="blog-section bg_light_1">
    <!--===============spacing==============-->
    <div class="pd_top_80"></div>
    <!--===============spacing==============-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title_all_box style_two text-center dark_color">
                    <div class="title_sections two">
                        <div class="before_title">
                            AIS Update
                        </div>
                        <h2>Berita &amp; Artikel</h2>
                    </div>
                    <!--===============spacing==============-->
                    <div class="mr_bottom_20"></div>
                    <!--===============spacing==============-->
                </div>
            </div>
        </div>
        <div class="row gutter_40px">
            <div class="col-lg-12">
                <div class="blog_post_section  three_column news_wrapper_grid style_four ">
                    <div class="grid_show_case grid_layout clearfix">
                        @foreach($posts as $post)
                        <div class="grid_box _card style_man">
                            <div class="news_box style_four has_images" style="background-image: url('{{asset('/storage/posts/'.$post->image)}}');">
                                <div class="overlay"></div>
                                <div class="date">
                                    <span class="date_in_month">{{date('m y', strtotime($post->pub_date))}}</span>
                                    <span class="date_in_number">{{date('d', strtotime($post->pub_date))}}</span>
                                </div>
                                <div class="content_box">
                                    <div class="category">
                                        <a href="{{route('post.post.show',$post->slug)}}" class="categories"><i class="icon-folder"></i>{{ $post->category->name }}</a>
                                    </div>
                                    <h2 class="title"><a href="{{route('post.post.show',$post->slug)}}" rel="bookmark">{{$post->title}}</a></h2>
                                </div>
                                <div class="auhtour_box">
                                    <img alt="img" src="assets/images/auth-1.png" height="60" width="60" class="img-fluid">
                                    <div class="contnet_a">
                                        <p>POSTED BY</p>
                                        <h4> {{ $post->user->name }} </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===============spacing==============-->
    <div class="pd_bottom_70"></div>
    <!--===============spacing==============-->
</section>