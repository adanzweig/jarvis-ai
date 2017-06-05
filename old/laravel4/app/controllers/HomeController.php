<?php
use PhpImap\Mailbox as ImapMailbox;
use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;
class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
    function __construct(){


    }

    public function index()
	{


        return View::make('hello');
	}
    public function search(){
//        $command = $_GET['command'];
        $url ='';
        $query = $_REQUEST['q'];
        $type = $_REQUEST['t'];

		switch($type){
            case 'spotify':
                $session = new SpotifyWebAPI\Session('f493972c4f5441b281472e8c66cf7f35', 'aafc85a0f8e64f5696d18dd75898190c', 'http://chepibe/spotify');
                $api = new SpotifyWebAPI\SpotifyWebAPI();

                // Request a access token with optional scopes
                $scopes = array(
                    'playlist-read-private',
                    'user-read-private'
                );

                $session->requestCredentialsToken($scopes);
                $accessToken = $session->getAccessToken(); // We're good to go!

                // Set the code on the API wrapper
                $api->setAccessToken($accessToken);
                $result = $api->search($query, 'track,artist,album,playlist');



                if(!empty($result->artists) && count($result->artists->items)>0){
                    $url = $result->artists->items[0]->external_urls->spotify;
                }
                if(!empty($result->playlists) && count($result->playlists->items)>0){
                    $url = $result->playlists->items[0]->external_urls->spotify;
                }
                if(!empty($result->albums) && count($result->albums->items)>0){
                    $url = $result->albums->items[0]->external_urls->spotify;
                }
                if(!empty($result->tracks) && count($result->tracks->items)>0){
                    $url = $result->tracks->items[0]->external_urls->spotify;
                }

                echo $url;
                break;
            case 'email':
                $mailbox = new PhpImap\Mailbox('{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX', 'adanzweig@gmail.com', 'vamosha1491', __DIR__);
                if($query=='unread'){
                    $mailsIds = $mailbox->searchMailbox('UNSEEN');
                    echo count($mailsIds);
                }
                if($query=='read'){
                    $mailsIds = $mailbox->searchMailbox('UNSEEN');
                    $mail = $mailbox->getMail($mailsIds[$_GET['number']]);
                    echo json_encode(array('emailSubject'=>$mail->subject,'text'=>$mail->textPlain));
                }

                break;

        }
    }
}
