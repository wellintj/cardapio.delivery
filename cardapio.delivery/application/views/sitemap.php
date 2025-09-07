<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($urls as $row) : ?>
        <url>
            <loc><?php echo prep_url($row['url']); ?></loc>
            <lastmod><?php echo $row['created_at']; ?></lastmod>
            <changefreq><?php echo $row['changefreq']; ?></changefreq>
            <priority>0.8</priority>
        </url>
    <?php endforeach; ?>
</urlset>