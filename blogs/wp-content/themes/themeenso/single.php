<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Enso | Dubai For Life</title>

    <!-- _______ Include Common CSS AND META TAG _______ -->
    <?php include 'style_css.php' ?>
	<?php wp_head(); ?>
    <!-- _______ CSS END _______ -->

</head>

<body>
    <?php

    /**
     * The template for displaying content in the single.php template
     */
    ?>
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


    <section class="blog-detailing" data-aos="fade-up">
        <div class="container">
            <div class="blog-details">
                <div class="blog-left" data-aos="fade-up">
                    <h2>
                        <?php echo get_the_title(); ?>
                    </h2>
                    <p class="mt-4">
                        <?php echo get_the_date('jS M, Y'); ?>
                    </p>
                    <div class="blog-banner-img">
                        
                            <img src="<?php echo get_field('banner_image')['url']; ?>"
                                alt="<?php echo get_field('banner_image')['text']; ?>">

                    </div>
                    <div class="blog-content">
                        <?php echo get_field('content'); ?>
                    </div>
                    <div class="blog-share">
                        <ul>
                            <li><a data-bs-toggle="modal" data-bs-target="#exampleModal" type="button"><i
                                        class="fa-solid fa-share-nodes"></i></a></li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_post_permalink()); ?>" target="_blank"><i class="fa-brands fa-linkedin-in text-black"></i></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_post_permalink()); ?>" target="_blank"><i class="fa-brands fa-facebook-f text-black"></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_post_permalink()); ?>" target="_blank"><i class="fa-brands fa-x-twitter text-black"></i></a>
                            </li>
                            <!-- <li><a><i class="fa-brands fa-instagram"></i></a></li> -->
                        </ul>
                    </div>
                    <div class="prv-nxt-btn">
                        <div class="blog-prv-btn">
                            <?php
                            // Get the previous post in the loop
                            $prev_post = get_previous_post();
                            if (!empty($prev_post)):
                                ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>"><span><svg width="34" height="34"
                                            viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.2381 2.49907C13.6908 0.889049 17.6047 0.563829 21.2758 1.58191C24.9469 2.59999 28.1343 4.89456 30.2646 8.0529C32.3949 11.2112 33.3284 15.0261 32.8972 18.8112C32.4659 22.5964 30.6982 26.1035 27.912 28.7016C25.1258 31.2998 21.504 32.8186 17.6979 32.9848C13.8919 33.151 10.1515 31.9536 7.14945 29.6082C4.1474 27.2628 2.08075 23.9231 1.32122 20.1899C0.561681 16.4568 1.15911 12.5751 3.00606 9.2431"
                                                stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="5.79922" cy="5.00039" r="1.6" fill="black" />
                                            <path d="M13.8008 10.5996L21.8008 16.9996L13.8008 23.3996" stroke="black"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>Previous Blog</a>
                                <?php
                            endif;
                            ?>
                        </div>

                        <div class="blog-nxt-btn">
                            <?php
                            // Get the next post in the loop
                            $next_post = get_next_post();
                            if (!empty($next_post)):
                                ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>">Next Blog<span><svg width="34"
                                            height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.2381 2.49907C13.6908 0.889049 17.6047 0.563829 21.2758 1.58191C24.9469 2.59999 28.1343 4.89456 30.2646 8.0529C32.3949 11.2112 33.3284 15.0261 32.8972 18.8112C32.4659 22.5964 30.6982 26.1035 27.912 28.7016C25.1258 31.2998 21.504 32.8186 17.6979 32.9848C13.8919 33.151 10.1515 31.9536 7.14945 29.6082C4.1474 27.2628 2.08075 23.9231 1.32122 20.1899C0.561681 16.4568 1.15911 12.5751 3.00606 9.2431"
                                                stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="5.79922" cy="5.00039" r="1.6" fill="black" />
                                            <path d="M13.8008 10.5996L21.8008 16.9996L13.8008 23.3996" stroke="black"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span></a>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>

                </div>
                <div class="other-blog">
                    <h4>Latest Blog</h4>
                    <div class="news-2">
                        <?php
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 2,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        );
                        $query = new WP_Query($args);
                        if ($query->have_posts()):
                            while ($query->have_posts()):
                                $query->the_post();
                                ?>
                                <a href="<?php the_permalink(); ?>" data-aos="fade-up" data-aos-delay="300">
                                    <div class="news-text-img">
                                        <div>
                                            <?php if (has_post_thumbnail()): ?>
                                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')); ?>"
                                                    alt="<?php the_title_attribute(); ?>">
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
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            ?>
                            <p>
                                <?php esc_html_e('No posts found'); ?>
                            </p>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="share-modal">
                        <h1>Copy Link</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="form-group my-4">
                        <label for="linkCopierInput" class="sr-only">Link</label>
                        <input class="form-control w-100" id="linkCopierInput" name="link"
                            value="<?php echo the_permalink(); ?>" readonly="readonly">
                        <button class="btn btn-lg btn-primary my-2" id="linkCopierButton" type="button"
                            onclick="copyLink()">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- __________ FOOTER __________ -->
    <?php include 'footer.php' ?>
    <!-- __________ FOOTER END __________ -->

    <!-- __________ Include JS __________ -->
    <?php include 'style_js.php' ?>
    <!-- __________ JS END __________ -->
    <script>
        function copyLink() {
            var inputField = document.getElementById("linkCopierInput");
            inputField.select();
            document.execCommand("copy");
        }
    </script>
    <script>
        AOS.init({
            duration: 1200,
            once: true,
        });
    </script>
</body>

</html>