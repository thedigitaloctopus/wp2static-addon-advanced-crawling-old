<?php
/**
 * @package WP2Static
 *
 * Copyright (c) 2011 Leon Stafford
 */

?>

<hr>

<h3>Advanced Crawling Options</h3>

 
<h4>Exclude URL Patterns</h4>

<label
    for="<?php echo $view['wp2static_advanced_crawling_addon_options']['excludeURLs']->name; ?>"
><?php echo $view['wp2static_advanced_crawling_addon_options']['excludeURLs']->label; ?></label>

<textarea
    class="widefat"
    name="<?php echo $view['wp2static_advanced_crawling_addon_options']['excludeURLs']->name; ?>"
    id="<?php echo $view['wp2static_advanced_crawling_addon_options']['excludeURLs']->name; ?>"
    rows="5"
    cols="10"><?php echo $view['wp2static_advanced_crawling_addon_options']['excludeURLs']->value ? $view['wp2static_advanced_crawling_addon_options']['excludeURLs']->value : ''; ?></textarea>

<p><i><?php echo $view['wp2static_advanced_crawling_addon_options']['excludeURLs']->description; ?></i></p>

<h4>Force-include URLs</h4>

<label
    for="<?php echo $view['wp2static_advanced_crawling_addon_options']['additionalURLs']->name; ?>"
><?php echo $view['wp2static_advanced_crawling_addon_options']['additionalURLs']->label; ?></label>

<textarea
    class="widefat"
    name="<?php echo $view['wp2static_advanced_crawling_addon_options']['additionalURLs']->name; ?>"
    id="<?php echo $view['wp2static_advanced_crawling_addon_options']['additionalURLs']->name; ?>"
    rows="5"
    cols="10"><?php echo $view['wp2static_advanced_crawling_addon_options']['additionalURLs']->value ? $view['wp2static_advanced_crawling_addon_options']['additionalURLs']->value : ''; ?></textarea>

<p><i><?php echo $view['wp2static_advanced_crawling_addon_options']['additionalURLs']->description; ?></i></p>
