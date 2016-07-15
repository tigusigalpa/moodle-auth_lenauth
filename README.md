# LenAuth Plugin for Moodle
### Easy authorization via most popular International and Russian social networks: Facebook, Google+, Yahoo, Twitter, VK, Yandex, Mail.RU

This plugin allows easy auth method for your Moodle. You just need to register and adjust OAuth applications of social networks and fill system data to LenAuth settings. If user didnt registered via LenAuth and has not a Moodle account - his account will be created, if account is registered, but not binded with LenAuth - account will be binded.

## Features
- a lot of settings
- a lot of social buttons skins including [Font-Awesome](https://fortawesome.github.io/Font-Awesome/) and [Bootstrap](http://getbootstrap.com/) based skins
- detailed description about OAuth applications register
- Russian language includes
- own buttons text (some skins)
- enable/disable services
- international/russian logos in settings
- own buttons order

## Download Installation
[English plugin documentation](http://lms-service.org/lenauth-plugin-oauth-moodle/)

[Russian plugin documentation](http://lmstech.ru/lenauth-plugin-oauth-moodle/)

[Official Moodle plugin repository page](https://moodle.org/plugins/view.php?plugin=auth_lenauth)

First of all, you need to have installed and fine working **[Moodle](https://github.com/moodle/moodle) 2.6.5+**
- upload **lenauth** folder to **/auth** folder, so files need to be inside **/auth/lenauth/**
- update Moodle DataBase. Just in admin panel click Home, and Moodle will suggest for LenAuth update
- activate the plugin. Block **Administration -> Plugins -> Authentication -> Manage authentication**
- register OAuth clients/applications at social networks and fill api data to LenAuth settings. Instructions are in the plugin admin page.

## Usage. Output in Moodle theme
Its very-very simple. You have two methods: PHP-code or static HTML-code.

- **PHP-code**. Copy PHP-code from skins table at LenAuth plugin screen opposite skin you need and paste the code into your current Moodle theme. All updates of LenAuth settings will automatically apply in theme.

**Sample PHP-code:**

`<?php if ( file_exists( $CFG->dirroot . '/auth/lenauth/out.php' ) ) : include_once $CFG->dirroot . '/auth/lenauth/out.php'; echo auth_lenauth_out::getInstance()->lenauth_output('style3-text'); endif; ?>`

- **Static HTML-code**. Click **Static HTML-code** link under PHP-code. In new window you will see static HTML-code, so you can copy it and paste in your current theme. **BUT!** this is static code, so if you will change some settings in LenAuth you need to update this HTML-code!

## Contributing
You're welcome for pull requests but against master branch. Thanks!

## Changelog
#### Version 1.2.5 (2016071500)
- Fix with cookie clean while user logouts. Issue from [Mark Samberg](https://github.com/mjsamberg) from [The Friday Institute](https://github.com/TheFridayInstitute) ([pull request #5](https://github.com/tigusigalpa/moodle-auth_lenauth/issues/5))
- Some code improves
- Suspended user login lock. Issue from [V-Zemlyakov](https://github.com/V-Zemlyakov) ([pull request #12](https://github.com/tigusigalpa/moodle-auth_lenauth/issues/12))
- VK API version update to **5.52**

#### Version 1.2.4 (2015123100)
- Yet another [Font-Awesome](https://fortawesome.github.io/Font-Awesome/) and [Bootstrap](http://getbootstrap.com/) based buttons style from [Mark Samberg](https://github.com/mjsamberg) from [The Friday Institute](https://github.com/TheFridayInstitute) ([pull request #9](https://github.com/tigusigalpa/moodle-auth_lenauth/pull/9))
- Some code improves to hide human errors from Moodle frontend
- VK API version update to **5.42**

#### Version 1.2.3 (2015112001)
- Moodle 3.0 support. Thanks to [Amiad](https://github.com/amiad) and [Jarosław Maciejewski](https://github.com/nitro2010)
- Development mode option added

#### Version 1.2.2 (2015071100)
- Improvement from [Mark Samberg](https://github.com/mjsamberg) ([pull request #3](https://github.com/tigusigalpa/moodle-auth_lenauth/pull/3)) about [Bootstrap](http://getbootstrap.com/) + [Font Awesome](http://fortawesome.github.io/Font-Awesome/) buttons styles. **NOTE** your current Moodle theme requires Bootstrap and Font Awesome to correct output this buttons skin. Yandex and Mail.Ru logos are out of Font Awesome for now...
- Double email correct check

#### Version 1.2.0 (2015060300)
- **New feature**: custom order of links/buttons output
- **Yahoo OAuth2 protocol full integration**, old OAuth1 also supports. Now you can select Yahoo OAuth protocol version.
- Improvement from [Mark Samberg](https://github.com/mjsamberg) ([pull request #2](https://github.com/tigusigalpa/moodle-auth_lenauth/pull/2)) to allow display buttons for guest users
- VK API version updated to version 5.33

#### Version 1.1.0 (2015010500)
- Copyrights about code parts from [auth_googleoauth2 Moodle plugin](https://moodle.org/plugins/view.php?plugin=auth_googleoauth2). Much thanks to [Jérôme Mouneyrac](https://github.com/mouneyrac)!
- Added retrieve avatars from social profiles (new checkbox option)
- Fix about Twitter works
- Update VK.com API version to 5.27

#### Version 1.0.8 (2014122400). Much thanks to Yandex Tech Team!
- Added cookie clear if final data fails
- Fix from Yandex Tech team: get default email instead of first

#### Version 1.0.7 (2014112500)
- Fix for output variable at [get_string](https://docs.moodle.org/dev/String_API#get_string.28.29) function
- Predefine ALL of configs
- Small fix to complete show buttons examples in admin screen

#### Version 1.0.6 (2014112200)
- Preset some plugin configs (Thanks to [David Mudrák](https://github.com/mudrd8mz))
- Added check for file exists of out.php
- Complete [Frankenstyle](https://docs.moodle.org/dev/Frankenstyle) class and functions names
- Some very small fixes

#### Version 1.0.4 (2014111300)
- check permissions for file **view_admin_config.php**
- edited config names and method names to [Frankenstyle](https://docs.moodle.org/dev/Frankenstyle)
- fixed SQL request for function **_lenauth_get_userdata_by_social_id** to Postgresql compatibility
- more documentation/metainfo for some functions
- fix for Yandex button link for English locale

#### Version 1.0 (2014110200)
- initial release.

## Author
Copyright 2014, [Igor Sazonov](https://twitter.com/tigusigalpa) (sovletig@yandex.ru)
