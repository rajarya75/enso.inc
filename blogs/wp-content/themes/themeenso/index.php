<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Blogs - ENSO</title>
     <link rel="canonical" href="https://www.enso.inc/blogs" />
    <meta name="description" content="Explore insightful real estate articles and updates on ENSO's blog. Stay informed and inspired about the latest trends and tips in the market." />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://www.enso.inc/assets/images/Enzo-banner-logo.png">
    <meta property="og:title" content="Blogs - ENSO" />
    <meta property="og:description" content="Explore insightful real estate articles and updates on ENSO's blog. Stay informed and inspired about the latest trends and tips in the market." />
    <meta property="og:url" content="https://www.enso.inc/blogs" />
    <meta property="og:site_name" content="ENSO" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Explore insightful real estate articles and updates on ENSO's blog. Stay informed and inspired about the latest trends and tips in the market." />
    <meta name="twitter:title" content="Blogs - ENSO" />
    <meta name="twitter:image" content="https://www.enso.inc/assets/images/Enzo-banner-logo.png" />

    <!-- _______ Include Common CSS AND META TAG _______ -->
    <?php include 'style_css.php' ?>
    <!-- _______ CSS END _______ -->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KNM4K7M5');</script>
<!-- End Google Tag Manager -->

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNM4K7M5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <!-- __________ HEADER __________ -->
    <?php include 'header.php' ?>
    <!-- __________ HEADER END __________ -->
    <div class="grid">
        <div class="grid-line"></div>
        <div class="grid-line"></div>
        <div class="grid-line"></div>
        <div class="grid-line"></div>
        <div class="grid-line"></div>
    </div>

    <section class="blog-banner">
        <div class="container">
            <div>
                <h1>Blogs</h1>
            </div>
        </div>
    </section>

    <section class="latest-news news-margin mt-5" data-aos="fade-up">
        <div class="container">
            <div class="future-dubai-heading">
                <div class="heading-sub">
                    <h2>Feature Blogs</h2>
                </div>
            </div>
            <div class="news-list news-list-desktop">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'category_name' => 'featured-post',
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $query = new WP_Query($args);


                if ($query->have_posts()):
                    $first_post = true;
                    while ($query->have_posts()):
                        $query->the_post();
                        ?>
                                        <?php if ($first_post): ?>
                                                    <a href="<?php the_permalink(); ?>">
                                                        <div class="news-1 blog-1">
                                                            <div class="imgwithdesc">
                                                                <?php if (has_post_thumbnail()): ?>
                                                                            <img src="<?php the_post_thumbnail_url(); ?>">
                                                                <?php endif; ?>
                                                                <div class="dubai-proj-desciption news-first blog-desc">
                                                                    <div class="news-date blog-titles">
                                                                        <h3>
                                                                            <?php the_title(); ?>
                                                                        </h3>
                                                                        <div class="mt-3">
                                                                            <p>
                                                                                <?php echo get_the_date('jS M, Y'); ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                        <?php else: ?>
                                                    <div class="news-2 blog-2">
                                                        <a href="<?php the_permalink(); ?>" data-aos="fade-up" data-aos-delay="300">
                                                            <div class="news-text-img">
                                                                <div>
                                                                    <?php if (has_post_thumbnail()): ?>
                                                                                <img src="<?php the_post_thumbnail_url(); ?>">
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="news-details">
                                                                    <div class="news-date blog-titles">
                                                                        <h3>
                                                                            <?php the_title(); ?>
                                                                        </h3>
                                                                        <div>
                                                                            <p>
                                                                                <?php echo get_the_date('jS M, Y'); ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                        <?php endif;
                                        $first_post = false; ?>
                            <?php endwhile;
                    wp_reset_postdata();
                else: ?>
                            <p>
                                <?php esc_html_e('No posts found'); ?>
                            </p>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>



            <div class="news-list news-list-mobile">
                <div class="news-1 blog-1">
                <div class="news-slider slick-slider">
    <?php
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'category_name' => 'featured-post',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            ?>
                    <div class="item">
                        <a href="<?php the_permalink(); ?>">
                            <div class="imgwithdesc">
                                <div>
                                    <?php if (has_post_thumbnail()): ?>
                                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="dubai-proj-desciption news-first blog-desc">
                                    <div class="news-date blog-titles">
                                        <h3><?php the_title(); ?></h3>
                                        <div class="mt-3">
                                            <p><?php echo get_the_date('jS M, Y'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
        endwhile;
        wp_reset_postdata(); // Reset post data to restore the global post object
    else:
        // If no posts found
        ?>
            <p><?php esc_html_e('No posts found'); ?></p>
            <?php
    endif;
    ?>
</div>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
    <section class="blog-section" data-aos="fade-up" data-aos-delay="800">
        <div class="container">
            <div class="future-dubai-heading">
                <div class="heading-sub">
                    <h2>Latest Blogs</h2>
                </div>
            </div>
            <div class="latest-blog-slider">
    <?php
    // WP_Query arguments
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1, // Retrieve all posts
    );

    // The Query
    $query = new WP_Query($args);

    // The Loop
    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            ?>
                            <div class="item">
                                <div class="imgwithdesc">
                                    <div>
                                        <?php if (has_post_thumbnail()): ?>
                                                    <img class="blog-img" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="dubai-proj-desciption blog-des">
                                        <p><?php the_title(); ?></p>
                                        <span><?php echo get_the_date('Y, M j'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
        endwhile;
        wp_reset_postdata(); // Reset post data to restore the global post object
    else:
        // If no posts found
        ?>
                <p><?php esc_html_e('No posts found'); ?></p>
                <?php
    endif;
    ?>
</div>

        </div>
    </section>
    <!-- __________ FOOTER __________ -->
    <?php include 'footer.php' ?>
    <!-- __________ FOOTER END __________ -->

    <!-- __________ Include JS __________ -->
    <?php include 'style_js.php' ?>
    <!-- __________ JS END __________ -->

    <script>
        AOS.init({
            duration: 1200,
            once: true,
        });
    </script>
</body>

</html>