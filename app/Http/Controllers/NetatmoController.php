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
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
