=== roo! Framework ===
Contributors: butterflymedia
Tags: directory, link, business, url, custom post, taxonomy
License: GPLv3
Requires at least: 4.5
Tested up to: 4.7.2
Stable tag: 5.3.0

== Description ==

roo! Framework is a full-featured, compact and quick to set up framework for creating link directories, business directories, classified ad listings, jobs, article directories, recipe lists and more. Packaged as a plugin for WordPress, roo! Framework allows users to add their items to your directory based on multiple criteria.

== Installation ==

1. Upload the roo-framework folder to your `/wp-content/plugins/` directory
2. Activate the plugin via the Plugins menu in WordPress
3. Create and publish a new page and add this shortcode: `[roo]`
4. A new roo! Items menu will appear in WordPress with items, categories, options and general help
5. Create the desired categories and adjust the directory settings

== Changelog ==

= 5.3.0 =
* UPDATE: Updated WordPress compatibility
* UPDATE: Removed old migration help section

= 5.2.4 =
* UPDATE: Updated WordPress compatibility

= 5.2.3 =
* FIX: Fixed a misspelled option

= 5.2.2 =
* FIX: Fixed lots of PHP notices and warnings
* FIX: Fixed email charset to UTF-8

= 5.2.1 =
* UPDATE: Updated custom post type and taxonomy registration

= 5.2 =
* FIX: Fixed widget constructors
* FIX: Fixed unset variables
* FIX: Fixed WordPress 4.4 styling

= 5.1 =
* FIX: Fixed obsolete option ("Show comments")
* FIX: Fixed plugin localization
* UPDATE: Updated WordPress compatibility

= 5.0.7 =
* FIX: Removed redundant jQuery enqueue

= 5.0.6 =
* UPDATE: Tweaked backend tabs styling
* UPDATE: Checked compatibility with latest WordPress (4.2.2)

= 5.0.5 =
* FIX: Load Google Maps on demand only
* UPDATE: Updated FontAwesome to 4.3.0

= 5.0.4 =
* FIX: Fixed 'category' parameter

= 5.0.3 =
* IMPROVEMENT: Cleaned up _rate.js file
* IMPROVEMENT: Removed IE6 and IE7 compatibility (placeholders)
* IMPROVEMENT: Removed custom .navbar styles as it interfered with WordPress styles
* IMPROVEMENT: Removed dashicons in settings tabs
* UPDATE: Updated WordPress 4.0 compatibility

= 5.0.2 =
* FIX: Fixed a foreach() warning
* FIX: Removed custom dashicons script
* UPDATE: Changed menu icon to dashicon

= 5.0.1.1 =
* DOCUMENTATION: Added sample template files to documentation and fixed the sample code textareas inside the help section

= 5.0.1 =
* VERSION: Added WordPress 3.9 compatibility
* IMPROVEMENT: Added permalink to item title (missing in 5.0-final)
* IMPROVEMENT: Updated Google Maps function

= 5.0 =
* FIX: Fixed plugin path constant
* FIX: Fixed category assignment on submission
* FIX: Fixed type assignment on submission

= 5.0-beta3 =
* FIX: Fixed WordPress comments option, not being properly saved
* FIX: Fixed the item count on the dashboard page
* FIX: Fixed tabs UI style (removed margin)
* FEATURE: Added more help for creating single and taxonomy templates
* IMPROVEMENT: Moved all admin inline styles to a separate CSS file

= 5.0-beta2 =
* FEATURE: Updated the settings engine

= 5.0-beta1 =
* FEATURE: Code refactoring (merged Roo Link Directory, Roo Classifieds and Jobbin into roo! Framework)

= 4.5.4 =
* IMPROVEMENT: Removed formalize.js

= 4.5.3 =
* FEATURE: Added global categories exclusion
* FEATURE: Added shortcode categories exclusion [roold exclude="20,33"]
* IMPROVEMENT: Removed country selection and replaced it with a regular text input
* IMPROVEMENT: Various code cleanup

= 4.5.2 =
* FEATURE: Added link sorting (asc/desc) by date or title
* IMPROVEMENT: Better draft-to-publish detection
* IMPROVEMENT: Added paragraph styling in category view
* IMPROVEMENT: Added reCAPTCHA theme

= 4.5.1 =
* IMPROVEMENT: Directory columns are now pure CSS
* IMPROVEMENT: More CSS cleanup and fixes
* FIX: Fixed Alexa rank SimpleXML() issue
* FIX: Removed Google PR information, as it's deprecated and no longer updated

= 4.5 =
* FIX: Fixed a custom post notification error
* IMPROVEMENT: Moved settings menu to custom post menu

= 4.4.2.2 =
* FEATURE: Added option to show/hide image upload for links

= 4.4.2.1 =
* FIX: Fixed a meta key ordering issue

= 4.4.2 =
* Removed a useless multisite check

= 4.4.1 =
* Added 10 thumbshot generator providers

= 4.4 =
* Removed Thumbshots due to service change
* Removed icons/badges
* Removed conflicting bootstrap.css
* Removed content from latest links (summary)
* Fixed a misspelled option (summary)
* Fixed Google Maps unique inclusion

= 4.3 =
* Fixed 1 warning for WordPress 3.6
* Added reCAPTCHA option
* UI tweaks and redesigned Dashboard page
* Replaced a multisite function for individual settings (not global) - better when using the plugin on multiple sites on a single WordPress multisite installation
* Roo Framework: Small code tweaks and source comments
* Roo Framework: Added contact form to shared functions
* Roo Framework: Map tweaks (JS and CSS)


= 4.2.1 =
* Added CSS Bootstrap (implemented default styles)
* Added Formalize jQuery plugin
* Fixed a string bug with reciprocal links
* Fixed a missing label
* Small UI tweaks
* Added translation to https://poeditor.com/projects/

= 4.2 =
* Added Alexa Rank and Google PageRank
* Added option to show/hide reciprocal link
* Fixed address field on detail display
* Removed a duplicate header

= 4.1.1 =
* Added option to show/hide address on summary page
* Fixed some translation strings having the wrong description
* Added license declaration and license.txt (GPL v3)
* Tested the plugin with latest 3.5.2-alpha and 3.6-alpha

= 4.1 =
* Added placeholder compatibility for IE7, IE8 and IE9
* Removed SQL-intensive query from Roo framework

= 4.0.4 =
* Added 2 more translated strings
* Removed a debug message
* Fixed an unquoted constant
* Roo Framework updated to version 1.2

= 4.0.3 =
* Added pending links count bubble
* Added multiple category selection (hold CTRL to select multiple items)
* Added featured links (use a flavour for this)
* Fixed bug with switching off address field
* Fixed a conflict with Gravity Forms

= 4.0.2 =
* Added ordering by name for categories
* Added possibility of changing slugs (for SEO purposes)
* Updated Russian translation (thanks Nisadoji)
* Fixed the submission alert bug
* Removed the autocomplete feature for country selector (bad idea)

= 4.0.1 =
* Added URL address and name to notification email
* Added a better country selector
* Added a text link inside Roo link editing panel for quick visit
* Added two more translated strings
* Fixed IDs of submission form
* Fixed rating system appearing inside posts, too
* Fixed deprecated query argument
* Fixed a missing closing tag
* Moved all CSS styles in one styesheet
* Rearranged some code
* Removed the entire SEO/SERP section due to CURL errors and performance degradation

= 4.0-beta =
* Complete rewrite of the plugin, using custom post types and taxonomies
* Added multiple categories
* Added tags (in form of "flavours")
* Added SEO options
* Added better ratings
* Added WordPress-based comments (use Akismet and other filters on links comments)
* Added separate fields for city/county and country
* Added dedicated, WordPress-based search form
* Added compatibility with vote5 plugin
* Removed extra/custom database tables
* Removed unused fields and options

= 3.2.10 =
* Fixed a paragraph issue in Javascript code

= 3.2.9 =
* Added option to enable/disable star rating
* Added link title to comments page (instead of ID)
* Added better Google PageRank calculation
* Added Alexa Rank and Alexa backlinks

= 3.2.8 =
* Fixed option for duplicate link check (only for subdomains or subfolders)
* Fixed description size for non-numeric sizes
* Fixed the ampersand (&) issue with multipage categories
* Added more tags to description field
* Added summary page enhancements
* Tiny HTML5 additions, such as tags, attributes and source validation

= 3.2.7 =
* FEATURE: removed hardcoded path (plugin folder can now be renamed)
* FEATURE: link (URL) can now be hidden, both on category page and on listing page
* FIX: added a slashes fix inside comments/reviews
* FIX: added a missing translation string
* FIX: corrected some translatable title strings
* FIX: fixed deprecated whois.net link
* FIX: fixed an uninitialized variable
* TWEAK: minor UI enhancements to directory front-end (cleaned up the stylesheet and combined several styles)
* TWEAK: comments/reviews form now has HTML5 browser validation and pretty dates
* TWEAK: contact form now has HTML5 browser validation
* TWEAK: buttons and forms now inherit all font properties (no more forced fonts)
* CHANGE: Removed pre-2.6 compatibility

= 3.2.6 =
* FEATURE: added option to turn on or off the error_reporting() function
* FEATURE: added HTML5 placeholder attribute to listing contact form
* FEATURE: added editor capabilities to email template
* FEATURE: added option to show or hide the navigation bar
* FEATURE: overhauled settings page (more streamlined, separated option groups)
* SECURITY: added honeypot CAPTCHA to listing contact form
* FIX: added options save confirmation
* ACCESSIBILITY: added some missing labels inside Settings page
* TWEAK: minor UI enhancements to directory back-end

= 3.2.5 =
* FEATURE: added HTML5 field validation
* FEATURE: added description truncation in category view
* FEATURE: added multisite compatibility

= 3.2.4 =
* Added verification code message (if wrong or invalid)
* Added 2 missing translated fields
* Removed an invalid HTML tag (for W3C validation)
* Fixed all HTML source to be HTML5 valid (according to W3C)
* Fixed the pagination issue with links not going to their detail pages
* Improved SEO (link titles are inside a titled H3 tag, address is inside an ADDRESS tag)
* FEATURE: added summary shortcode
* FEATURE: added new widget: most visited links
* FEATURE: added links export option (CSV format)

= 3.2.3 =
* Fixed the mail class fatal error on some WordPress installations
* Fixed stylesheet to override some default theme styles
* Fixed premium ribbon height and intensity
* Switched to wp_mail and simplified the HTML email format
* Removed an obsolete function, having no effect on frontend, but breaking some themes

= 3.2.2 =
* Added Russian translation (thanks to Stepchuk)
* Featured links are now better emphasized using a ribbon image
* Featured links can now be turned back to regular links
* All fields are now editable (including phone, fax and open-hours)
* "Add a link" text is now editable
* Email template is now configurable (email sent to link submitter)
* Fixed the "Add a link" button not working with several Permalink structures
* Fixed icon styles using CSS overrides
* Fixed display version entry in WordPress options (nothing major, but caused confusion in the source)
* Removed the error reporting function, as it conflicted with another debugging plugin
* Removed the update notification function as many users reported wrong notifications

= 3.2.1 =
* Fixed comments double posting when refreshing page
* Added ratings on category page
* The usual layout tweaks :)
* Corrected an untranslated string in email
* Fixed description size errors appearing with some themes (description will be trimmed if longer than limit)
* Added search form shortcode
* Added new link form shortcode
* New demo page - http://getbutterfly.com/bookmarks/
* Reformatted form fields

= 3.2 =
* Added comments
* Added ratings
* Added French translation
* Added a dashboard/help page
* More layout clean-up
* Improved message sending and contact form
* Fixed several outstanding bugs (reciprocal check, rare new link bug)
* Description field can now be hidden
* Removed the Add Link page from the backend (it was a redundant task to maintain both that page and the front page, if the latter can achieve the same thing)
* Removed a potentially harmful fopen() function

= 3.1 =
* Fixed a deprecated PHP function (eregi)
* Removed a potentially unsafe file open operation
* Fixed a concatenation error
* Fixed a rare WP_Error occurrance
* Fixed logo/image upload
* Added statistics widget
* Layout tweaks and clean-up

= 3.0 =
* Fixed a path problem with directory styles (not a problem, as version 2.1 had only one style)
* Fixed a line break missing in detail listing page
* New plugin file structure
* Added (toggle-able) contact form for each listing
* Added image upload for each listing (a logo, a photo, a symbol)
* Added a new listing interface (better placement, icons, boxes, etc), a contact form for each listing using the provided email
* All display options are switchable (on or off) - suitable for both location directories and bookmark directories - icons, address, map, location details, SEO/SERP details can now be hidden
* Added pagination
* Added email display option
* Thumbnails are now visible on category page, too
* Removed a visible (debug) SQL query on submission

= 2.1.1 =
* Repack to fix upgrade error

= 2.1 =
* Added QR option for URL
* Added localization .PO file
* Added Romanian language file
* Added fields for: open-hours
* Added light yellow style for pending links
* Added button to get directions from Google
* Fixed some warnings by initializing some variables
* Changed Add URL to Add link
* Link catalog back-end layout changes
* Removed reciprocal link and added the textarea to Add link page
* Allowed tags use <sup> and it breaks on some themes - used <div><small>
* [WISHLIST] Added ability to add custom fields to the submit form (phone, fax)
* [WISHLIST] Added ability to edit ALL fields in the admin section (Google Maps address, submitter's name/email)

= 2.0 =
* First public release
