<?php

$naughty = array('\b(?:fat|gay|gay |jack|jack |dat|dat |jerk|lame|lame |suck|suck )?ass(?:es|hole|holes|fucking|fucker|fuckers|fucks|head|heads|hat|hats|jabber|jabbers|pirate|pirates|bag|bags|clown|clowns|shit|shits|hit|hits|wipe|wipes)?\b', 
				'\bbampot(?:s)?\b',
				'\bbastard(?:s)?\b',
				'\bbeaner(?:s)?\b',
				'\bbitch(?:es|s|ass|asses|y|tits|tit)?\b',
				'\bblow(?:s|job| job|jobs| jobs)?\b',
				'\bbj(?:s|\'s)?\b',
				'\bbollox(?:s|es)?\b',
				'\bboner(?:s)?\b',
				'\b(?:gay|gays|gay |brother|sister|uncle|brotha|sista|mother|motha|bumble)?fuck(?:a|er|as|ers|s|shits|shit|tard|tards|brain|brains|butt|butts|butter|butters|ed|face|faces|ing|nut|nuts|nutt|nutts|off|up|ups|offs|tart|tarts|wad|wads|wit|wits|witt|witts|ist|ists|in)?\b',
				'\bdayum?\b',
				'\b(?:god)dam(?:n|mit|nit|n it)?\b',
				'\bhomo(?:s|es)?\b',
				'\bfag(?:bag|bags|fucker|fuckers|it|its|git|gits|got|gots|cock|cocks|tard|tards)?\b',
				'\bhonk(?:y|ies|ys)?\b',
				'\bcock(?:s|sucker|suckers)?\b',
				'\bdick(?:s|sucker|suckers|fuck|fuckers|head|heads)?\b',
				'\b(?:)jerk(?:ing|ing off|in|in off)?\b',
				'\bjizz(?:in|ing|es|izz|is)?\b',
				'\b(?:sand|sand )?nigga(?:s)?\b',
				'\b(?:sand|sand )?nigger(?:s)?\b',
				'\bpussy(?:s|ies|licking)?\b',
				'\bpussies?\b',
				'\btit(?:ties|s|fuck|fucks|tyfuck|ty fuck)?\b',
				'\btwat(?:s|lips|waffle|waffles|lip)?\b',
				'\b(?:thunder)?cunt(?:s)?\b',
				'\b(?:dumb:homo:homodumb:dip)?shit(?:e|ted|ting|ty|head|ass|asses|bag|bags|bagger|baggers|tiest|dick|dicks|face|faced|faces|cunt|cunts|hole|holes|house|houses|spitter|spitters|stain|stains|ter|ters)?\b');

$response = array('status' => '0', 'error' => 'No message specified');
$replacement = "*";
if(isset($_GET['replacement'])){
	$replacement = $_GET['replacement'];
}
if(isset($_GET['message'])){
	$message = $_GET['message'];
	$profanityLevel = 0;
    foreach($naughty as $word){
        $match_count = preg_match_all('/' . $word . '/i', $message, $matches);
        for($i = 0; $i < $match_count; $i++){
			$bwstr = trim($matches[0][$i]);
			$message = preg_replace('/\b' . $bwstr . '\b/', str_repeat($replacement, strlen($bwstr)), $message);
		}
		$profanityLevel+=$match_count;
    }
	$response = array('status' => '1', 'response' => $message, 'profanityLevel' => $profanityLevel);
}

$response = json_encode($response);

die($response);
