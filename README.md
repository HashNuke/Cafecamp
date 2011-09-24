# Cafecamp (early 2008)

This repo contains the source code of a social network I developed (and was operated for a while) in early 2008.

### Don't expect MVC. Don't expect clean code.
### Don't expect any programming abstractions or concepts here.
### __The only thing it does is: work__

If you want to get it working. grep the codebase for "some_password" and replace it with the password of the database. And along with it the database name, user and host. Some parts of the site might require the Flickr API. For that grep the codebase for "FLICKR_API" and replace it with Flickr API key and secret.

When I quit working on this, I had already written some part of my own OpenSocial parser, so there is minimal support for OpenSocial apps. Only the gadget spec is implemented as per what I faintly remember, so Google Gadgets can be run on this easily. There are a couple examples in the __appstore__ directory.

## Screenshots

![Dashboard](https://github.com/HashNuke/Cafecamp/raw/master/pics/screenshot.png "Dashboard")

![OpenSocial app drag-drop](https://github.com/HashNuke/Cafecamp/raw/master/pics/my_profile_app_rearranging_view.png "OpenSocial app re-arranging")
