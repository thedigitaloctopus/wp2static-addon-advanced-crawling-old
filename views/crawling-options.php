<?php
/**
 * @package WP2Static
 *
 * Copyright (c) 2011 Leon Stafford
 */

?>

<hr>

<h3>Advanced Crawling Options</h3>

<label
    for="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlPort']->name; ?>"
><?php echo $view['wp2static_advanced_crawling_addon_options']['crawlPort']->label; ?></label>

<input
    name="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlPort']->name; ?>"
    id="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlPort']->name; ?>"
    value="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlPort']->value ? $view['wp2static_advanced_crawling_addon_options']['crawlPort']->value : ''; ?>" />

<p><i><?php echo $view['wp2static_advanced_crawling_addon_options']['crawlPort']->description; ?></i></p>


<label
    for="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlUserAgent']->name; ?>"
><?php echo $view['wp2static_advanced_crawling_addon_options']['crawlUserAgent']->label; ?></label>

<input
    name="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlUserAgent']->name; ?>"
    id="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlUserAgent']->name; ?>"
    value="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlUserAgent']->value ? $view['wp2static_advanced_crawling_addon_options']['crawlUserAgent']->value : ''; ?>" />

<p><i><?php echo $view['wp2static_advanced_crawling_addon_options']['crawlUserAgent']->description; ?></i></p>


<label
    for="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlDelay']->name; ?>"
><?php echo $view['wp2static_advanced_crawling_addon_options']['crawlDelay']->label; ?></label>

<input
    name="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlDelay']->name; ?>"
    id="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlDelay']->name; ?>"
    value="<?php echo $view['wp2static_advanced_crawling_addon_options']['crawlDelay']->value ? $view['wp2static_advanced_crawling_addon_options']['crawlDelay']->value : ''; ?>" />

<p><i><?php echo $view['wp2static_advanced_crawling_addon_options']['crawlDelay']->description; ?></i></p>

<label
    for="<?php echo $view['wp2static_advanced_crawling_addon_options']['dontUseCrawlCaching']->name; ?>"
><?php echo $view['wp2static_advanced_crawling_addon_options']['dontUseCrawlCaching']->label; ?></label>

<input
    type="checkbox"
    name="<?php echo $view['wp2static_advanced_crawling_addon_options']['dontUseCrawlCaching']->name; ?>"
    id="<?php echo $view['wp2static_advanced_crawling_addon_options']['dontUseCrawlCaching']->name; ?>"
    value="1"
    <?php echo $view['wp2static_advanced_crawling_addon_options']['dontUseCrawlCaching']->value ? 'checked' : ''; ?> />

<p><i><?php echo $view['wp2static_advanced_crawling_addon_options']['dontUseCrawlCaching']->description; ?></i></p>

<input name='dontUseCrawlCaching' id='dontUseCrawlCaching' type='checkbox' />   
<label for='dontUseCrawlCaching'>Disregard cache and crawl everything</label> 
