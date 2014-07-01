<?php
//Axed: Phoenix Bot Program
//By Kodamas for Ragezone.
ob_implicit_flush();
set_time_limit(0);
error_reporting(0);
include("Encoder.php");

$IP = "127.0.0.1";
$PORT = "30000";

$SSO = "SSOTICKET";
$RoomId = 1;

while(true)
{
	$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	
	socket_connect($sock, $IP, $PORT);
	echo "Connexion a l'emulateur\r\n\n\n";
			
	Send('<policy-file-request/>', $sock);
	Send(encodeLength(415).encodeLength(strlen($SSO)).$SSO, $sock);
			
	while(socket_recv($sock, $mRead, 1024, 0))
	{
		
		if($mRead == "" || strlen($mRead) == 1024)
			socket_close($sock);
		$mRead = trim($mRead);
			
		$Hearder = decodeLength(substr($mRead, 0, 2));
        $Body = substr($mRead, 2, strlen($mRead) - 3);
		echo "Id: ".$Hearder." message: ".$Body." Lengh: ".strlen($Body)."\n\n";
		
		switch($Hearder)
		{
			case 33:
			case 131:
			case 91:
			case 18:
				echo "Rooms Closed :( \n";
				break;
			case 2:
			case 570:
				Send(encodeLength(12), $sock);
                Send(encodeLength(391) . encodeInt($RoomId) . encodeInt(0) . encodeInt(0), $sock);
				break;
			case 19:
			case 166:
			case 314:
			case 700:
			case 69:
			case 831:
			case 46:
            case 12:
				Send("FA" . encodeInt($RoomId), $sock);
				break;
			case 454:
				Send(encodeLength(390), $sock);

                $figure = "";
                Send(encodeLength(44) . encodeLength("M") . strlen("M") . encodeLength(strlen($figure)) . $figure, $sock);

                $message = "message test";
                // $message = "@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@";
                Send(encodeLength(55) . encodeLength(strlen($message)) . $message, $sock);
                Send(encodeLength(55) . encodeLength(strlen($message)) . $message, $sock);
                Send(encodeLength(55) . encodeLength(strlen($message)) . $message, $sock);
                Send(encodeLength(55) . encodeLength(strlen($message)) . $message, $sock);
                Send(encodeLength(55) . encodeLength(strlen($message)) . $message, $sock);

                socket_close($sock);
				break;
		}
	}
	socket_close($sock);
}

function Send($text, $sock)
{
	$text = "@".encodeLength(strlen($text)).$text;
	// echo $text."\n";
	socket_send($sock, $text, strlen($text), 0);
}
?>