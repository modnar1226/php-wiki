<?php
$first = true;
/*
<?php foreach ($sections as $section) : ?>
    <?php if (!empty($section)) : ?>
        <li class="<?php echo $navListItemClass ?>">
            <a href="#<?php echo $section['id'] ?>" class="<?php echo $navLinkClass ?>"><?php echo $section['title'] ?></a>
        </li>
    <?php endif; ?>
<?php endforeach; ?>
*/
?>
<section>
    <div class="<?php echo $containerClass ?>">
        <div class="<?php echo $innerContainerClass ?>">
            <!-- navigation -->
            <aside class="col-lg-3">
                <div class="sticky sticky-with-header">
                    <button class="overlay-menu-open"></button>
                    <div class="overlay-menu boxed bg-dark text-white mb-3 mb-lg-0">
                        <ul id="page-nav" class="nav flex-column nav-vertical">
                            <?php foreach ($menuData as $category => $data) : ?>
                                <li class="nav-item active">
                                    <a class="nav-link" data-toggle="collapse" href="#menu-1" role="button" aria-expanded="true" aria-controls="menu-1"><?php echo $category ?></a>
                                    <div class="collapse <?php echo ($first ? 'show' : '') ?>" id="menu-1" data-parent="#page-nav">
                                        <ul class="nav flex-column">
                                            <?php foreach ($data as $link) : ?>
                                                <li class="nav-item">
                                                    <a class="nav-link doc-link" href="#<?php echo $link['id'] ?>"><?php echo $link['title'] ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php $first = false ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </aside>
            <!-- / toc -->

            <!-- content -->
            <article id="content" class="col-lg-7">
                <?php echo $content ?>
            </article>
            <!-- / content -->

            <!--
            <nav id="nav" class="<?php echo $navClass ?>">
            <form id="searchForm" class="<?php echo $searchFormClass ?>">
                <input class="<?php echo $searchInputClass ?>" type="search" placeholder="Search" aria-label="Search">
                <button class="<?php echo $searchButtonClass ?>" type="submit">Search</button>
            </form>
            <ul id="nav-list" class="<?php echo $navListClass ?>">
                <?php foreach ($sections as $section) : ?>
                    <?php if (!empty($section)) : ?>
                        <li class="<?php echo $navListItemClass ?>">
                            <a href="#<?php echo $section['id'] ?>" class="<?php echo $navLinkClass ?>"><?php echo $section['title'] ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
                    -->
        </div>
    </div>
</section>