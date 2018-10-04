# ᶘ ᵒᴥᵒᶅ InstaChan
a one file solution for image BBS ʕ•ᴥ•ʔ
 ---
InstaChan is in no way a substitute for more robust bbs and chans-a-like.
But if you need a quick and dirty way to set a BBS for fell people it may just be your chan!
The premisses are as follow:
1) It is free! to use and mod, but if you do so pls mention me ;)
2) It's a one file does it all project.... it's not meant to be fast or efficient, it's meant as a joke!
3) I do not take responsibility for any damage this peace os software may cause to you or to your system... you've been warned! o___o
4) This is not a serious board and it's meat as a quick and cheap way to setup a chan in your server.
5) This is just a study for a one file image board BBS using PHP and JSON.

Just upload this file to a php able server and watch it burn! ʕ￫ᴥ￩ʔ

Have fun...

---
## Getting started...
Just put the instachan.php file in a PHP able server and run it!
It'll run a first time setup and create the needed folder and files.
To reset just delete the .json files and it will be just as new ;)

to delete just delete every thing...
it's no rocket science... o___O

---

## To Do...

- implement security against code injection ಠ▃ಠ
- a way to create thumb nails
- a quote function, to quote other people msg...
- multi threads... maybe doable with the following ;)
- implement object oriented programming..


## DONE!

- ~auto delete board after n number of post~
- ~ERROR: if number of post per page is a multiple of number os posts the pages index gets 1 empty page at the end... and some more...~ DONE!!!
- ~ERROR: some times we get a error when trying to reset the chan: Warning: Cannot modify header information - headers already sent by~ DONE?
- ~color themes DONE!~ =D
- ~configuration at the first run~ DONE!
- ~multy page support... I've been thinking in ways to do this...~ DONE!


---
## History
v1 -- multy page, config on first run, themes

v0 -- Basic text and image function, JSON "database". Post can be posted and deleted.
      One file, easy deploy...
