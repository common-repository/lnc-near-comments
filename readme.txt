=== LNC Near Comments ===
Tags: Near, comments, nCaptcha, web3, blockchain
Requires at least: 6.0.1
Tested up to: 6.4.1
Stable tag: 0.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

LNC Near Comments plugin is advanced captcha system prevents spam comments and bots from infiltrating your site,
by integration with near web3 smart contract.

== Description ==

LNC Near Comments plugin is a part of WordPress integration with web3 near blockchain protocol. This plugin provides a specific captcha for the comments section
and post user comments after small tip transaction to https://explorer.mainnet.near.org/accounts/v1.ncaptcha.near smart contract. As a site owner, you can earn money with our plugin! Our unique payment system allows you to receive a portion of the payment for each captcha solved by your users. So not only will you be protecting your site, but you'll also be generating extra revenue at the same time.
Revenue is configurable on your side. So all that you need is get our login and comments plugin, register near wallet and install it to your site for spam protection, money earning and joining web3!

== Installation ==
1. Install our core login with near plugin to synchronize user wallets with your site https://wordpress.org/plugins/near-login/
2. Upload the plugin files to the `/wp-content/plugins/lnc-n-comments` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Provide you comment section selector, wallet, reward value to lnc_near_comments_config settings
5. Join the results

== Screenshots ==

1. find your comment section id by inspecting comments form screenshot-1.png.
2. fill the plugin settings (comment form selector from step 1, site owner - your near wallet, reward value - price for submit form. You'll get half of it) form screenshot-2.png.
3. Not signed user will this button screenshot-3.png.
4. After step 3 user should sign in screenshot-4.png.
5. Fill the comment form and click verify with nCaptcha screenshot-5.png.
6. User will pay for verification (the way is based on type of used balled) screenshot-6.png.
7. The comments will be shown in the comments section after reload screenshot-7.png.
8. You will see reward transaction on your wallet screenshot-8.png

== Important Notes ==

1. Compatibility: Our plugin has been tested and designed to work with the latest version of WordPress. It is important that you update your WordPress installation before using our plugin to ensure compatibility.
2. Dependencies: Our plugin require https://wordpress.org/plugins/near-login/ to function properly. Please refer to the plugin documentation for any necessary dependencies and installation instructions.
3. Specific behavior: 70% functionality of plugin based on client javascript. So please keep in mind, that without enabled javascript nCaptcha will not protect your comments.

== Changelog ==
= 0.0.2 =
* [Improvement] Improved wallet integration and contract calls
= 0.0.3 =
* [Improvement] Update screenshots
= 0.0.4 =
* [Improvement] Improved installation
= 0.0.9 =
* [Improvement] Fix comment controller
= 0.1.1 =
* [Improvement] Chore update version
= 0.1.2 =
* [Improvement] minor fix warnings
= 0.1.3 =
* [Improvement] tested with new wp