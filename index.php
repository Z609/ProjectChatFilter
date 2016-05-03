<?php

$naughty = array('\b(?:fat|gay|gay |jack|jack |dat|dat |jerk|lame|lame |suck|suck )?a+s+s+(?:es|hole|holes|fucking|fucker|fuckers|fucks|head|heads|hat|hats|jabber|jabbers|pirate|pirates|bag|bags|clown|clowns|shit|shits|hit|hits|wipe|wipes)?\b', 
				'\bb+a+m+p+o+t+(?:s)?\b',
				'\bb+a+s+t+a+r+d+(?:s)?\b',
				'\bb+e+a+n+e+r+(?:s)?\b',
				'\bb+i+t+c+h+(?:es|s|ass|asses|y|tits|tit)?\b',
				'\bb+l+o+w+(?:s|job| job|jobs| jobs)?\b',
				'\bb+j+(?:s|\'s)?\b',
				'\bb+o+l+l+o+x+(?:s|es)?\b',
				'\bb+o+n+e+r+(?:s)?\b',
				'\b(?:gay|gays|gay |brother|sister|uncle|brotha|sista|mother|motha|bumble)?f+u+c+k+(?:a|er|as|ers|s|shits|shit|tard|tards|brain|brains|butt|butts|butter|butters|ed|face|faces|ing|nut|nuts|nutt|nutts|off|up|ups|offs|tart|tarts|wad|wads|wit|wits|witt|witts|ist|ists|in|head|heads)?\b',
				'\bd+a+y+u+m+?\b',
				'\b(?:god)d+a+m+(?:n|mit|nit|n it)?\b',
				'\bh+o+m+o+(?:s|es)?\b',
				'\bf+a+g+(?:bag|bags|fucker|fuckers|it|its|git|gits|got|gots|cock|cocks|tard|tards)?\b',
				'\bh+o+n+k+(?:y|ies|ys)?\b',
				'\bc+o+c+k+(?:s|sucker|suckers)?\b',
				'\bd+i+c+k+(?:s|sucker|suckers|fuck|fuckers|head|heads)?\b',
				'\bj+e+r+k+(?:ing|ing off|in|in off)?\b',
				'\bj+i+z+z+(?:in|ing|es|izz|is)?\b',
				'\b(?:sand|sand )?n+i+g+g+a+(?:s)?\b',
				'\b(?:sand|sand )?n+i+g+g+e+r+(?:s)?\b',
				'\bp+u+s+s+y+(?:s|ies|licking)?\b',
				'\bw+h+o+r+e+(?:s)?\b',
				'\bp+u+s+s+i+e+s+?\b',
				'\bt+i+t+(?:ties|s|fuck|fucks|tyfuck|ty fuck)?\b',
				'\bt+w+a+t+(?:s|lips|waffle|waffles|lip)?\b',
				'\b(?:thunder)?c+u+n+t+(?:s)?\b',
				'\b(?:dumb|homo|homodumb|dip|bull|horse)?s+h+i+t+(?:e|ted|ting|ty|head|ass|asses|bag|bags|bagger|baggers|tiest|dick|dicks|face|faced|faces|cunt|cunts|hole|holes|house|houses|spitter|spitters|stain|stains|ter|ters)?\b');

$response = array('status' => 0, 'error' => 'No message specified');
$replacement = "*";
if(isset($_GET['replacement'])){
	$replacement = $_GET['replacement'];
}
if(isset($_GET['message'])){
	$message = $_GET['message'];
	$message = preg_replace("/(?<=(?<!\pL)\pL) (?=\pL(?!\pL))/", "", $message);
	$profanityLevel = 0;
    foreach($naughty as $word){
        $match_count = preg_match_all('/' . $word . '/i', $message, $matches);
        for($i = 0; $i < $match_count; $i++){
			$bwstr = trim($matches[0][$i]);
			$message = preg_replace('/\b' . $bwstr . '\b/', str_repeat($replacement, strlen($bwstr)), $message);
		}
		$profanityLevel+=$match_count;
    }
	$response = array('status' => 1, 'response' => $message, 'profanityLevel' => $profanityLevel);
}

$response = json_encode($response);

die($response);
