Social Network Bot
===

This is a bot I built back in 2009. Its purpose is to read through a big list of username:password and
send a message to each of the friends of that particular user. If the login fails, the user is marked as
being bad. The software hasn't been touched since 2009, and the pages it used to communicate with have
changed radically, so the software doesn't currently work. I will not accept any pull requests for this
project which will make it work to scrape a social network.

Why am I releasing this as open source? It is a good proof of concept regarding PHP and long running
tasks. The interface is simple and makes good use of a progress bar, something you don't see in a lot of
PHP apps. The app makes repeated AJAX requests to the backend to see what the status is. The long running
script keeps doing its thing, and the status script doesn't interfere.

I will be removing the various URLs and other items which can identify the social network this was built
for. Feel free to fork this code and do whatever you want with it.

![Social Network Bot Screenshot](https://github.com/tlhunter/php-social-network-bot/raw/master/screenshot.png)

Instructions (original readme)
==

Update _config.php with your database settings.

Import database.sql to get started with.

To add new users, open import.php and paste them in using the following format:
username:password
user2:pass2

Don't delete users using phpMyAdmin, instead use the built in tool.
If you do delete users manually, make sure their 'id' columns are in order so that the GUI progress report works properly.

deleteall.php deletes ALL users in your database.

download.php downloads a text file of users that haven't been flagged.

Once you start the bot, it will keep running even if you close the page. If you want to kill it after you've closed the page, open the stop.php page.

reset.php will reset the progress of all users if you'd like to use them again.

License
==

MIT