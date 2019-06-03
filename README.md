# BBEWorkflow
A simple editorial workflow for Beaver Builder

## Background
This all started when our team migrated our large higher ed site over to WordPress. We wanted to allow large handfulls of authorized users to access the Beaver Builder interface to make simple edits when needed. We also wanted to control whether those edits were published, so we needed some kind of approval process. That's where this plugin comes in, and we've been using this sucessfully for a few years now (as of June 2019).

## What this does
Here's the gist
- The admin decides which user roles get publishing permission
- Users without permission will only be able to **Save Draft** in Beaver Builder
- When those users are ready to submit changes, there's a simple form available to describe the chnanges made
- The admin receives that info via email, and can view the changes before make them live.

## Setup
1. Install/activate the plugin
2. Set both the admin email and the user roles with publishing permission in the main plugin file (bbew.php)
3. You're done.


## Notes
- The notices printed to the screen are currently hooked into the Top Bar of the Beaver Builder Theme. If you're using a different theme, or just want to change this up, the notices are controlled in `includes/notices.bb-editing.php`.
- Yes, Beaver Builder has user access settings. And it's all or nothing. You either have access to the editor and the ability to publish, or you don't have anything.
