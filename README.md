<p align="center" style="text-align:center"><img width="256" height="256" src="https://raw.githubusercontent.com/taskinoz/Super-Mario-Maker-Queue/master/img/Mario%20Queue.png" alt="Titanfall Twitch Integration" /></p>

# Super-Mario-Maker-Queue
A custom self hosted Super Mario Maker Queue

## Installation

Change the `key` in `config.php` to a secret word of your choosing and upload both the `config.php` and `index.php` to your webserver.

## Bot Commands

### Nightbot
Create the command `!add`

Add the message:
 >`$(urlfetch https://example.url.com/?key=YOURKEYHERE&name=$(user)&code=$(query))`

Replace `YOURKEYHERE` with the secret word you added to the `config.php`

Replace `https://example.url.com` with the URL of your webserver

### Moobot
Create the command `!add`

Select advanced commands

Set the response to `URL fetch - Full (plain) response`

Set the URL to fetch to:
>`​https://example.url.com/?key=YOURKEYHERE&name=​` **Username of the user** `&code=​` **Command arguments**

Replace `YOURKEYHERE` with the secret word you added to the `config.php`

Replace `https://example.url.com` with the URL of your webserver

## OBS

To show your level queue on stream:

1. Create a new source for **Browser** and add the URL of your webserver
2. Set the width and height of your source. (Its usually quite small so it doesnt need to be set super big, but I've set mine to the canvas size)
3. Add some custom CSS to style it for stream
4. **OPTIONAL** Check `Refresh browser when scene becomes active`

## Customisation

The base view already has some basic CSS to reset the default padding the browser gives it

Some basic CSS to make it look nice:
```CSS
h1{margin:5px 0;}
body{font-family:Arial;counter-reset:a}
.codes{text-transform:uppercase}
.codes:empty::before{content:"There are no levels in the Queue";text-transform: none}
.code:first-child{font-size:1.2em}
.code::before{
  counter-increment: a;
  content: counter(a) ") ";
}
```

## Todo

 - Remove levels form the Queue
