# ProjectChatFilter
I made this in about 30 minutes when I needed a chat filter for my Minecraft network (https://www.optimusmc.info/). So, I'm posting the code here for you to all enjoy! Should you find that something doesn't work, try making a pull request!

Example
---
http://api.z609.me/censor/?message=You%20are%20such%20a%20cunt

Returns:

{"status":"1","response":"You are such a ****","profanityLevel":1}

Example:
status: can be 0 or 1. If 0, there is an error. If 1, the filter was successful.
response: This is the filtered message
profanityLevel: For every word that needs to be bleeped, this number increments by one. If you're using this on a network and the level is above 3 or something, you should broadcast to staff that are not on the same server that someone is starting to be a little profane.
error: this is only given when the status is 0. It gives a brief explanation of the error.

Does not work with spaces (like c u n t). Case sensitivity does not matter. There can be other contexts and variations of words that have not been added.
