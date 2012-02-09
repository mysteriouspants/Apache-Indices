# Apache Indices

A quick set of hacks to make Apache directory indexes look pretty spiffy.

This is a bunch of modifications to http://antisleep.com/software/indices, including moving everything to JQuery and massively rewriting the CSS to make use of `:nth-child()` selectors, etc. It's overall pretty spiffy.

# Install

Pay extra-special attention to the `.htaccess` files - they're pretty important. Dump the junk on your webserver, then mangle the configurations in `header.php` to suit your fancy. It'll probably require a bit of tweaking, but it shouldn't be too hard.

You'll need to go fetch your own JQuery; dump it somewhere and point to that using the config variable. After that, enjoy!