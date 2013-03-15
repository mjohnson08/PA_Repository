=== Esplanade ===
Contributors: Daniel Tara
Tags: blue, brown, gray, green, tan, white,
light, one-column, two-columns, three-columns, four-columns,
left-sidebar, right-sidebar, fixed-width, flexible-width,
custom-background, custom-colors, custom-header, custom-menu,
editor-style, featured-images, full-width-template, microformats,
post-formats, sticky-post, theme-options, threaded-comments, translation-ready
Requires at least: 3.1
Tested up to: 3.3.2
Stable tag: 1.0.7

Description: A stylish, modern and flexible theme with responsive layout. Includes several custom templates, layouts and color schemes to choose from, 5 widget-ready areas and a user friendly options page to keep everything in control.

== Description ==

A stylish, modern and flexible theme with responsive layout.
Includes several custom templates, layouts and color schemes to choose from,
5 widget-ready areas and a user friendly options page to keep everything in control.


== Installation ==

Manual installation:

1. Upload the `esplanade` folder to the `/wp-content/themes/` directory

Installation using "Add New Theme"

1. From your Admin UI (Dashboard), use the menu to select Themes -> Add New
2. Search for 'esplanade'
3. Click the 'Install' button to open the theme's repository listing
4. Click the 'Install' button

Activiation and Use

1. Activate the Theme through the 'Themes' menu in WordPress
2. See Appearance -> Theme Options to change theme specific options

== License ==

Unless otherwise specified, all the theme files, scripts and images
are licensed under GNU General Public Licemse version 2, see file license.txt.
The exceptions to this license are as follows:
* The Flash Audio Player is licensed under MIT/Expat License, see audio-player/license.txt
* The script colorbox.js is licensed under MIT
* The script jquery.layout.js is dual licensed under GPL and MIT
* The script html5.js is licensed under MIT
* The Flash Video Player is licensed under LGPL v3

== Theme Notes ==

=== Featured Post Slider ===

The slider handles sticky posts as featured. If the slider option is enabled
sticky posts will be displayed in the slider and the main loop will ignore them.
If the option is disabled the loop will display normally, with sticky posts on top.

=== Grid and Blog View ===

The theme comes with 2 view modes: Grid and Blog.
The Grid mode is similar to a web magazine and shown only on the front page.
Secondary pages display in blog view.
You can override this behavior in theme options.

=== Post Thumbnail Functionality ===

Post Thumbnails appear only in post lists, not on single posts.
They can be set by choosing "Set as Featured Image" when uploading an image.

=== Image Post Format ===

Posts with the image format will display the last attached image in a caption.
If a post thumbnail is set, this one will appear instead.

=== Gallery Post Format ===

Posts with the gallery format will display the first 6 attached images, on 3 columns,
and also offers a lightbox for full screen preview.
On single pages images from the [gallery] shortcode display in a lightbox.

=== Audio & Video Post Formats ===

Posts with the audio & video post format will display the attached media files
in a HTML5 <audio> tag with flash fallback.
If more than one media file is attached to the post,
then these will be used as fallback sources.

=== Other Post Formats ===

Posts with the aside, status & quote post formats will displayed with no title;
the status post format will display the user's avatar, in a mannersimilar to Twitter;
the quote post format will only display the post's first <blockquote> tag.
Posts with the link post format will link out to the first <a> tag in the post.

=== Widgets Areas ===

The Theme has 4 customizable sidebars, a widget area in the footer and one on the 404 page.
You can use these area to customize the content of your website.
If no content is be added to the sidebars these will not display.

== Frequently Asked Questions ==

= How do I add thumbnails to posts? =

When editing a post, open the upload tool, select the image you wish to set as thumbnail
and select "Use as Featured Image". Note that thumbnails appear only in blog post lists.
To display then in single posts you need to isert them manually.

= How do I add posts to the slider? =

The slider displays sticky posts as featured. Mark the posts you wish to add to the slider as sticky
and they will be added automatically. Note that this mode disables the normal post order with sticky posts on top
and sticky posts will appear only in the slider.

= The slider is disproportioned =

You need to set a featured image of at least 640x395 for the slider's proportions to align.
The slider cannot be given fixed proportions to comply with the responsive layout.

= It doesn't look good in Opera browser on smaller screens =

Opera browser doesn't (yet) support decimans in percentage dimensions,
hence support for responsive layouts is only limited.

= Some content is not properly aligned =

Because of the responsive nature of the layout it is not possible to make all types of content
fit in all possible dimensions. The layout has been optimized to format the content well on
most poppular desktop and mobile resolutions. If your have a device that does not display them properly
please let us know and we will try to fix it.

= Why does the header widget area have fixed dimensions? =

The header widget area is intended exclusively for displaying ads.
The dimensions are those of standard header ad sizes.

= My media files won't play =

It may be that the server doesn't recognize the media types.
You'll have to register their MIME types.
Add this to your .htaccess file:

AddType audio/ogg .ogg
AddType audio/mpeg .mp3
AddType video/ogg .ogv
AddType video/webm .webm
AddType video/mp4 .mp4
AddType video/x-m4v .m4v

= I can't upload large files =

This is a limitation from your hosting provider.
Try adding the following to your .htaccess file:

php_value upload_max_filesize 128M
php_value max_execution_time 800
php_value post_max_size 128M
php_value max_input_time 800
php_value memory_limit 128M

128M is the maximum file size.
64M should be enough if you're uploading Video
and 16M if you're uploading Audio.

= I don't want to go through all this, isn't there an easier way that just works? =

The simplest way to accomplish this is to add just a FLV video or an MP3 audio.
They should be handled by the flash players and servers should recognize their type.
But you're missing on all the HTML5 goodies.

= I uploaded more media files, but I only see one =

Post formats are designed so only one media file is shown.
The other detected files are used as fallback sources for the first one.
If you would like to embed more media, a plugin may be more helpful.

== Support ==

You can use this support forum, for any support questions:
http://www.onedesigns.com/support/forum/theme-support/esplanade

== Additional Notes ==

The theme is released for free under the terms of the GNU General Public License version 2
and some parts under their respective licenses.
In general words, feel free and encouraged to use, modify and redistribute this theme however you like.
You may remove any copyright references (unless required by third party components) and crediting is not necessary.
The theme is offered free of charge. If someone asked money for it, someone just tricked you.

== Changelog ==

= 1.0.9 =

Fixed warning sometimes thrown when updating a post

= 1.0.8 =

* Fixed padding on post navigation with template No Sidebars
* Added new WordPress 3.4 custom headers and backgrounds method
* Deprecated custom image width option

= 1.0.7 =

* Fixed embedded media not displaying in slider

= 1.0.6 =
* Reduced dimensions of No Sidebars template to content width
* Embeds are now made responsive with fitvids.js

= 1.0.5 =
* Added flash player fallback for video post formats
* Silenced HTML5 warnings thrown by DOMDocument objects
* Fixed padding on static front pages
* Fixed padding on post navigation

= 1.0.4 =
* Added Pinterest button
* Added option to disable lightbox
* Added template and layout option "No Sidebars"
* Default to "No Sidebars" layout when no sidebars are active
* Adapted color schemes for drop-down menus
* Corrected first embed function
* Fixed header image styling when text is not shown
* Fixed 2nd level navigation menus
* Fixed search form styling on mobile devices
* Fixed embedded video dimensions in slider
* Fixed teaser dimensions on WebKit mobile browsers
* Fixed social bookmarks height
* Fixed Facebook like post dialog
* Fixed farbtastic script not loading

= 1.0.3 =
* Fixed teaser clearfix
* Used core bundled json2.js
* Small translation strings corrections

= 1.0.2 =
* Fixed footer widget area font color
* Fixed styling for search widget
* Various code optimizations

= 1.0.1 =
* Fixed lightbox border
* Added translation strings
* Changed `request` filter with `pre_get_posts` for home page query
* Added filter to `wp_title` instead of hard coding custom function in <title> tag
* Fixed 404 page padding
* Protected posts display password form in excerpts
* Added permalinks to teasers without titles

= 1.0 =
* Initial Release