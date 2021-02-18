<?php foreach ($sections as $section) : ?>
    <?php if (!empty($section)) : ?>
        <section id="<?php echo $section['id'] ?>">
            <h2 class="<?php echo $secTitleClass ?>">
                <?php echo $section['title'] ?>
            </h2>
            <?php foreach ($section['content'] as $content) : ?>
                <h4 class="<?php echo $secHeaderClass ?>">
                    <?php echo $content['heading'] ?>
                </h4>
                <p class="<?php echo $secParagraphClass ?>">
                    <?php echo $content['sub_content'] ?>
                </p>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
<?php endforeach; ?>