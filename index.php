<?php
$allYear = array();
$args = array(
  'post_type' => 'ir',
  'posts_per_page' => -1,
);
$the_query = new WP_Query($args);
?>
<?php if ($the_query->have_posts()) : ?>
  <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

    <?php array_push($allYear, get_the_date('Y')) ?>

  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php $uniqueYear = array_unique($allYear) ?>

<?php foreach ($uniqueYear as $year) { ?>
  <?php
  $irPosts = get_posts(array(
    'post_type' => 'ir',
    'post_per_page' => -1,
    'date_query' => array(
      array(
        'after' => array(
          'year' => $year,
          'month' => 1,
          'day' => 1,
        ),
        'before' => array(
          'year' => $year,
          'month' => 12,
          'day' => 31,
        ),
        'inclusive' => true,
      ),
    ),
  ));
  ?>

  <!-- ir dl start -->
  <div class="ir__dl">
    <div class="ir__dt">
      <div class="ir__dtYear"><?php echo $year; ?>年</div>
    </div>

    <div class="ir__dd">
      <ul class="ir__ddPostBox">

        <?php
        if (!empty($irPosts)) {
          foreach ($irPosts as $post) {
            setup_postdata($post);
        ?>

            <!-- post start -->
            <li class="ir__ddPostItem">
              <span class="ir__ddPostDate"><?php echo get_the_date('Y.m.d'); ?></span>
              <div class="ir__ddPostText"><?php the_content(); ?></div>
            </li>
            <!-- post end -->

        <?php
          }
        }
        wp_reset_postdata();
        ?>
      </ul>
    </div>
  </div>
  <!-- ir dl end -->

<?php } ?>