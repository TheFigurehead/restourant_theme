<nav aria-label="Pagination">
    <ul class="pagination">
      <?php if($prev): ?>
        <li class="page-item">
          <a class="page-link prev" href="<?php echo $prev['link']; ?>">
            ←
          </a>
        </li>
      <?php endif; ?>

      <?php if($first): ?>
        <li class="page-item">
          <a class="page-link" href="<?php echo $first['link']; ?>"><?php echo $first['number']; ?></a>
        </li>
      <?php endif; ?>

      <?php if($show_prev_points): ?>

        <li class="page-item">
          <a class="page-link points" href="#">
            ...
          </a>
        </li>

      <?php endif; ?>

      <?php foreach ($pages as $page): ?>
        <li class="page-item">
          <a class="page-link <?php if($page['active']): ?> current<?php endif; ?>" href="<?php echo $page['link']; ?>"><?php echo $page['number']; ?></a>
        </li>
      <?php endforeach; ?>

      <?php if($show_next_points): ?>

        <li class="page-item">
          <a class="page-link points" href="#">
            ...
          </a>
        </li>

      <?php endif; ?>

      <?php if($last): ?>
        <li class="page-item">
          <a class="page-link" href="<?php echo $last['link']; ?>"><?php echo $last['number']; ?></a>
        </li>
      <?php endif; ?>
      <?php if($next): ?>
        <li class="page-item">
          <a class="page-link next" href="<?php echo $next['link']; ?>">
            →
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
