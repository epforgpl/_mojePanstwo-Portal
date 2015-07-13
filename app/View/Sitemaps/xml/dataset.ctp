<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    foreach ($data as $d) {
        ?>
        <url>
            <loc><?= $d['loc'] ?></loc>
            <changefreq><?= $d['changefreq'] ?></changefreq>
            <priority><?= $d['priority'] ?></priority>
        </url>
    <?
    }
    ?>
</urlset>