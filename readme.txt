=== Codeally Block Slides ===
Contributors: oldrup
Tags: slides, presentation, block-editor, accessibility, keyboard-navigation
Requires at least: 6.9
Tested up to: 7.1
Requires PHP: 8.2
Stable tag: 0.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Registers a slides post type with deck taxonomy and keyboard navigation for block-based presentations.

== Description ==
Codeally Block Slides transforms native Gutenberg blocks into full-screen, responsive presentation slides without heavy third-party frameworks.

Developed by [Bjarne Oldrup](https://oldrup.dk/) and sponsored by [Codeally](https://codeally.dk/).

This plugin is tested across the latest WordPress releases and a representative set of themes, including Blocksy, GeneratePress, Kadence, Twenty Twenty-Five, Greyd, and Ollie.

== Frequently Asked Questions ==

=== Why should I use Codeally Block Slides? ===
- **Lightweight & Native:** Eliminates external JavaScript frameworks like Reveal.js by using core WordPress blocks and theme styling.
- **Deep Linking:** Every slide is an individual post, enabling direct slide links, SEO indexing, and reuse across Query Loops.
- **Keyboard Navigation:** Native left and right arrow key navigation between single slide posts.

=== Which themes are included in the testing matrix? ===
- **Classic themes:** Blocksy, GeneratePress, and Kadence
- **FSE themes:** Twenty Twenty-Five, Greyd, and Ollie

=== How do I set up and configure the plugin? ===
1. Install and activate the plugin.
2. Go to **Slides** > **Add New Slide** to build slides using core WordPress blocks or choose a layout pattern from the Codeally category.
3. Organize slides into presentations using the **Slide Decks** taxonomy.

=== Where can I find official documentation and references? ===
- [Codeally GitHub Repository](https://github.com/oldrup/codeally-block-slides)

== Installation ==
1. Upload the plugin folder to `/wp-content/plugins/codeally-block-slides`.
2. Activate the plugin through the **Plugins** menu in WordPress.

== Changelog ==
= 0.2.0 =
- Bumped the plugin version for the next release and refreshed release metadata.

= 0.1.2 =
- Replaced superglobal sniffing with core `get_current_screen()` API to eliminate Plugin Check nonce warnings.

= 0.1.1 =
- Enqueued pattern stylesheet in both frontend and Gutenberg Block Editor using `enqueue_block_assets`.
- Corrected CSS variable declarations and refactored selectors for block editor compatibility.

= 0.1.0 =
- Enqueued pattern stylesheet (`assets/css/block-slide.css`) on single slide views.

= 0.0.9 =
- Renamed pattern category to "Codeally" for cross-plugin brand consistency.

= 0.0.8 =
- Attempted postTypes auto-suggestions and block inserter keywords.

= 0.0.7 =
- Dynamically scan and register all JSON patterns placed in assets/patterns/.

= 0.0.6 =
- Registered custom Block Pattern category and slide pattern from JSON asset.

= 0.0.5 =
- Encapsulated CPT and taxonomy registration inside a static class method to eliminate global variable warnings in Plugin Check.

= 0.0.4 =
- Converted CPT registration callback to static closure.

= 0.0.3 =
- Fixed plugin header license field and global function prefixing for Plugin Check compliance.
- Synchronized stable tag with plugin version.

= 0.0.1 =
- Initial release.