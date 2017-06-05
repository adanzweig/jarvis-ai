<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use xzaero\Netatmo\Clients\NAApiClient;
//use xzaero\Netatmo\Common;
use xzaero\Netatmo;
class NetatmoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $client;

	function __construct()
    {
        $scope = Netatmo\Common\NAScopes::SCOPE_READ_CAMERA;

        $config = array();
        $config['client_id'] = "5928b07f65d1c4ee7a8b6f04";
        $config['client_secret'] = "d68GlJLtPaBQ4JrXrXNZiJjE6ol2eIedWDh78AB";
        $config['scope'] = $scope;
        $this->client = new Netatmo\Clients\NAWelcomeApiClient($config);
    }

    public function index()
	{

    //Retrieve access token
        try
        {
            $tokens = $this->client->getAccessToken();
        }
        catch(Netatmo\Exceptions\NAClientException $ex)
        {
            echo "An error happened  while trying to retrieve your tokens \n" . $ex->getMessage() . "\n";
        }

    //Try to retrieve user's Welcome information
        try
        {
            //retrieve every user's homes and their last 10 events
            $response = $this->client->getData(NULL, 10);
            $homes = $response->getData();
            //print homes names
            foreach($homes as $home)
            {
                echo $home->getName() . "\n";
            }
        }
        catch(Netatmo\Exceptions\NASDKException $ex)
        {
            echo "An error happened while trying to retrieve home information: ".$ex->getMessage() ."\n";
        }


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function install()
	{
        $this->client->subscribeToWebhook('http://www.adanjz.com:8081');


	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function getData()
	{
        dd($this->client->getData());

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function webhook()
	{
        if(Storage::disk('local')->exists('Netatmo.log')){
            Storage::disk('local')->append('Netatmo.log', json_encode($_REQUEST));
        }else{
            Storage::disk('local')->put('Netatmo.log', '\n'.json_encode($_REQUEST));

        }

    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function redir()
	{
	    var_dump($_REQUEST);
        if($_SESSION['state'] && !empty($_GET['state']) && ($_SESSION['state']===$_GET['state'])) {
            $code = $_GET["code"];
            $token_url = "https://api.netatmo.com/oauth2/token";

            $postdata = http_build_query(
                array(
                    'grant_type' => "authorization_code",
                    'client_id' => $app_id,
                    'client_secret' => $app_secret,
                    'code' => $code,
                    'redirect_uri' => $my_url,
                    'scope' => "read_camera 20access_camera"
                )
            );

            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );

            $context  = stream_context_create($opts);

            $response = file_get_contents($token_url, false, $context);
            $params = null;
            $params = json_decode($response, true);

            $api_url = "https://api.netatmo.com/api/getuser?access_token="
                . $params['access_token'];

            $user = json_decode(file_get_contents($api_url));
            echo("Hello " . $user->body->mail);
        } else {
            echo("The state does not match. You may be a victim of CSRF.");
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function test()
	{

        // This is just an example to illustrate the documentation
        // Prefer the PHP SDK


        $app_id = "5928b07f65d1c4ee7a8b6f04";
        $app_secret = "d68GlJLtPaBQ4JrXrXNZiJjE6ol2eIedWDh78AB";
        $my_url = "http://adanjz.com:1000/netatmo/redir";

        session_start();


        if(empty($_GET["code"])) {
            $_SESSION['state'] = md5(uniqid(rand(), TRUE));
            $dialog_url="https://api.netatmo.com/oauth2/authorize?client_id="
                . $app_id . "&redirect_uri=" . urlencode($my_url)
                . "&scope=read_camera%20access_camera"
                . "&state=" . $_SESSION['state'];

            header('location:'.$dialog_url);
            die();
        }




	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
