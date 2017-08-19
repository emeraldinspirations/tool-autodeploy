![emeraldinspirations logo](http://vps56132.vps.ovh.ca/logo.gitHub.png)

# tool-autodeploy
> An tool by [emeraldinspiration](https://github.com/emeraldinspirations)'s

Auto deployment script for demo site

## Installing

This project has no dependencies and can be cloned directly from the git repo

### Clone with HTTPS

```shell
git clone https://github.com/emeraldinspirations/tool-autodeploy.git
```

### Clone with SSH

```shell
git clone git@github.com:emeraldinspirations/tool-autodeploy.git
```

## Configure Apache

### Add public key to server
```shell
gpg --armor --export {KeyName} > {KeyFile}.gpg
scp {KeyFile}.gpg {User}@{WebHost}:/var/www/{KeyFile}.local.gpg
```

### Trust Key
[Source](https://www.gnupg.org/gph/en/manual/x334.html)
```shell
gpg --import {KeyFile}.local.gpg
gpg --edit-key {KeyName}
trust
# Select trust level, I used "Maximum"
quit
```

### Copy keyring to Apache user
[Source](https://maanasroyy.wordpress.com/2013/05/21/importing-gnupg-key-in-apache/)
```shell
# Import the key in any user
cp -R ~/.gnupg /var/www
chown -R www-data: /var/www/.gnupg
```

### Add gnu Environment Variable to Apache user
```shell
sudo -u www-data bash
export GNUPGHOME=/var/www/.gnupg/
# Use printenv to verify Environment Variable stored
exit
```

### Change permissions on repo to Apache user
> error: cannot open .git/FETCH_HEAD: Permission denied

```shell
sudo chown www-data --recursive .git
```

## Contributing

If you'd like to contribute, please fork the repository and use a feature branch.

I am also open to feedback about how well I am being compliant with standards and "best practices." I have written software solo for years, and am trying to learn how to work better with others.

## Licensing

The code in this project is licensed under [MIT license](LICENSE).
