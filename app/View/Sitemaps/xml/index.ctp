<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    foreach ($data as $d) {
        ?>
        <sitemap>
            <loc><?= $d['loc'] ?></loc>
            <lastmod><?= $d['lastmod'] ?></lastmod>
        </sitemap>
    <?
    }
    ?>
</sitemapindex>