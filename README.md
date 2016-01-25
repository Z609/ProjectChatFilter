# ProjectChatFilter
I made this in about 30 minutes when I needed a chat filter for my Minecraft network (https://www.optimusmc.info/). So, I'm posting the code here for you to all enjoy! Should you find that something doesn't work, try making a pull request!

You are NOT required to host this on your server. You can use http://api.z609.me/censor/ (HTTPS is supported). In fact, it is recommended that you use the API as a) 100% uptime, b) updates, and c) it's cool! :)

Example
---
http://api.z609.me/censor/?message=You%20are%20such%20a%20cunt

Returns:

{"status":"1","response":"You are such a ****","profanityLevel":1}

Arguments
---
message: The message you want to filter

replacement: One character that will be used to bleep out parts of bad words. Recommended one letter. Default is an asterisk (*)

Response
---
status: can be 0 or 1. If 0, there is an error. If 1, the filter was successful.

response: This is the filtered message

profanityLevel: For every word that needs to be bleeped, this number increments by one. If you're using this on a network and the level is above 3 or something, you should broadcast to staff that are not on the same server that someone is starting to be a little profane.

error: this is only given when the status is 0. It gives a brief explanation of the error.

Caveats
---
Does not work with spaces (like c u n t). Case sensitivity does not matter. There can be other contexts and variations of words that have not been added.
