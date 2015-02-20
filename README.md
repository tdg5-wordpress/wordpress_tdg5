# Wordpress Heroku Composer

Template project for deploying [Wordpress](https://wordpress.org/) to
[Heroku](https://heroku.com) using [Composer](https://getcomposer.org/) for
package and dependency management.

This project is designed to use MySQL via Heroku's
[ClearDB add-on](https://devcenter.heroku.com/articles/cleardb).
For a template that is bundled to use PostgreSQL, consider
[mhoofman/wordpress-heroku](https://github.com/mhoofman/wordpress-heroku),
however, be warned that the [PostgreSQL for Wordpress plugin](https://wordpress.org/plugins/postgresql-for-wordpress/)
does not support versions of Wordpress newer than 3.4.2.

Additionally, given the ephemeral nature of file storage on Heroku dynos, this
project is designed to use [Amazon S3](https://aws.amazon.com/s3/) for
persistent storage.

## Included themes/plugins/versions
- [Wordpress 4.1.1](https://wordpress.org/news/2015/02/wordpress-4-1-1/)
- [twentyfifteen 1.0 theme](https://wordpress.org/themes/twentyfifteen)
- [Amazon Web Services 0.2.2 plugin](https://wordpress.org/plugins/amazon-web-services/)
- [Amazon S3 and Cloudfront 0.8.2 plugin](https://wordpress.org/plugins/amazon-s3-and-cloudfront/)

## Installation

To facilitate personalization/customization, you'll probably first want to
[fork this repository](https://github.com/tdg5-wordpress/wordpress_heroku_composer/fork).

Next, clone this repository or your fork from GitHub:

```
  $ git clone https://github.com/tdg5-wordpress/wordpress_heroku_composer.git
```

Create your app using [Heroku CLI](https://devcenter.heroku.com/articles/heroku-command):

```
  $ cd wordpress_heroku_composer
  $ heroku create
  Creating glacial-harbor-1236... done, stack is cedar-14
  https://glacial-harbor-1236.herokuapp.com/ | https://git.heroku.com/glacial-harbor-1236.git
  Git remote heroku added
```

Add the free ClearDB ignite addon to your app:

```
  $ heroku addons:add cleardb:ignite
  Adding cleardb:ignite to glacial-harbor-1236... done, v2 (free)
  Use `heroku addons:docs cleardb` to view documentation.
```

Add the heroku-buildpack-php buildpack:

```
  $ heroku config:set BUILDPACK_URL=https://github.com/heroku/heroku-buildpack-php
  Setting config vars and restarting glacial-harbor-1236... done, v3
  BUILDPACK_URL: https://github.com/heroku/heroku-buildpack-php
```

Use Wordpress secret key generator to generate unique keys and salts for your
app and store those in Heroku environment variables:

```
  $ eval "heroku config:set $(curl -s https://api.wordpress.org/secret-key/1.1/salt/ | sed "s/define('/WP_/" | sed "s/', \+/=/" | sed "s/);$//" | sed ':a;N;$!ba;s/\n/ /g')"
  Setting config vars and restarting glacial-harbor-1236... done, v4
  WP_AUTH_KEY:         dkyKYeb[x3ujYsAZ}7iqFJ,q!k+z&Y kDC-}|@dZn^/7k8*?Qi[F=mbr7 lO@A4-
  WP_AUTH_SALT:        cX2Dgd+)~;Ow{_=U|coB*`+v%-AM#+ezhX@~sPAg+Vut24hA$t:Kv/(fmD[kElq>
  WP_LOGGED_IN_KEY:    J;3rJNJ1T/6H(vqW782&s[faV>MB,auM5>N= a|x3w6Gb|-;fCHv.v~Y}A4CCsEt
  WP_LOGGED_IN_SALT:   +F(Z++7a)pD(PwhQ{23*+_g$vwKUB9vDtrQ`>z:^zC{T( Pnf)$P}9%^)R RK8LJ
  WP_NONCE_KEY:        RKT|_7#w+l@HN6QBIQuORhAQ.iK+G<]|4-PdFe1e(_yg<7fbKzz,RC}C<G?0C$?7
  WP_NONCE_SALT:       JE9^ZMKycvmTPRp=k8Y@V,4AP- xtzUn%,$B_}_.rdCojW>x8Q9-@UHN+2|$^I86
  WP_SECURE_AUTH_KEY:  )Hag,{=%]`Fh%(kGXp|sXrjH*tu}RjO77|YjVCG;k0tu~qj^5e<k3o4Sh)p4Lxn0
  WP_SECURE_AUTH_SALT: qWg|db>nBYT=!DMdTB(1sKeOg2JjQJ~E.B8:y;j1R 0ZT+GL>!IgSgB5ex@rY@Rv
```

Store your AWS Access Key ID and AWS Secret Access key in your application's
environment:

```
  $ heroku config:set AWS_ACCESS_KEY_ID='<your_aws_key>' AWS_SECRET_ACCESS_KEY='<your_aws_secret>'
  Setting config vars and restarting glacial-harbor-1236... done, v5
  AWS_ACCESS_KEY_ID:     <your_aws_key>
  AWS_SECRET_ACCESS_KEY: <your_aws_secret>
```

You may want to set other optional configuration values:

```
  $ heroku config:set DATABASE_PREFIX="glacial"
  Setting config vars and restarting glacial-harbor-1236... done, v6
  DATABASE_PREFIX:     glacial
```

Deploy the app:

```
  $ git push heroku master
  Counting objects: 10, done.
  Delta compression using up to 8 threads.
  Compressing objects: 100% (3/3), done.
  Writing objects: 100% (4/4), 382 bytes | 0 bytes/s, done.
  Total 4 (delta 2), reused 0 (delta 0)
  remote: Compressing source files... done.
  remote: Building source:
  remote:
  remote: -----> Fetching custom git buildpack... done
  remote: -----> PHP app detected
  remote: -----> Resolved composer.lock requirement for PHP to version 5.6.6.
  remote: -----> Installing system packages...
  remote:        - PHP 5.6.6
  remote:        - Apache 2.4.10
  remote:        - Nginx 1.6.0
  remote: -----> Installing PHP extensions...
  remote:        - zend-opcache (automatic; bundled)
  remote: -----> Installing dependencies...
  remote:        Composer version 1.0-dev (833ce984264204e7d6576ab082660105c7d8f04c) 2015-02-17 21:55:44
  remote:        Loading composer repositories with package information
  remote:        Installing dependencies from lock file
  remote:          - Installing fancyguy/webroot-installer (1.0.0)
  remote:            Loading from cache
  remote:
  remote:          - Installing composer/installers (v1.0.21)
  remote:            Loading from cache
  remote:
  remote:          - Installing wordpress (4.1.1)
  remote:            Loading from cache
  remote:
  remote:          - Installing wpackagist-plugin/amazon-s3-and-cloudfront (0.8.2)
  remote:            Loading from cache
  remote:
  remote:          - Installing wpackagist-plugin/amazon-web-services (0.2.2)
  remote:            Loading from cache
  remote:
  remote:          - Installing wpackagist-theme/twentyfifteen (1.0)
  remote:            Loading from cache
  remote:
  remote:        Generating optimized autoload files
  remote: -----> Preparing runtime environment...
  remote: -----> Discovering process types
  remote:        Procfile declares types -> web
  remote:
  remote: -----> Compressing... done, 81.2MB
  remote: -----> Launching... done, v14
  remote:        https://glacial-harbor-1236.herokuapp.com/ deployed to Heroku
  remote:
  remote: Verifying deploy... done.
```

Browse to the app to complete the installation process. That's all!

[View the example app](http://glacial-harbor-1236.herokuapp.com/)


## Contributing

1. [Fork it](https://github.com/tdg5-wordpress/wordpress_heroku_composer/fork)
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request
