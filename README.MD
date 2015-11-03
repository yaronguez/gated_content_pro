=== Gated Content Pro ===
Contributors: yaronguez
Tags: gated, content, gravity forms, gated content, content protection
Requires at least: 3.5.1
Tested up to: 3.9.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Hides portion of content within a post or page until a user submits a Gravity Form. Can easily be linked to MailChimp or any other 3rd party Gravity Forms integrations requiring a user to subscribe to view content.

== Description ==

This plugin uses a shortcode to hide a portion of content on a post or page until a user completes an action.  Currently the only action supported is submitting a Gravity Form but additional actions will be added in the future.  Gravity Forms integrates with everything under the sun so this could easily be used with MailChimp, Constant Contact, etc.

A cookie is used to track the user.

Example usage on a post or page:
This content can be read immediately.  [gated_content gf="3"]This content can only be read once Gravity Form #3 has been submitted[/gated_content]

Note:
To ensure user sees content right away without having to reload the page:
1. Go to the form's Settings
2. Go the Confirmations panel
3. Set Confirmation Type to Redirect
4. Set the Redirect URL to {embed_url}

Advanced Options:
All of the attributes used by the standard Gravity Forms shortcode can be included in the Gated Content Pro shortcode.  Just prepend gf_ to the attribute.
Here is how you would use all of these attributes at once:
[gated-content gf="1" gf_display_title=false gf_display_description=false gf_field_values='parameter_name1=value1&parameter_name2=value2']

== Installation ==


= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Gated Content Pro'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `gated-content-pro.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `gated-content-pro.zip`
2. Extract the `gated-content-pro` directory to your computer
3. Upload the `gated-content-pro` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Frequently Asked Questions ==

= Where do I get the Gravity Form number? =

Click on "Forms" in the Dashboard.  The ID of the form is the first column listed.

= How does it remember that a user submitted a form without forcing them to register? =

Using cookies.  Thus, cookies are required.

= After submitting a form, the user gets a confirmation message instead of the content =
Gravity Forms is weird.  For now, change the Confirmation Type to Redirect and set the Redirect URL to: {embed_url}

== Changelog ==

= 1.0 =
* First version, woohoo!
