<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Phue;

class HueController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $client;
	function __construct()
    {
        $this->client = new Phue\Client('192.168.0.10', 'coauPtOkg8KhnshBxP6FeuzdRFOtRqKdSe5ZBPfv');
    }

    public function index()
	{
		//
	}

    public function home(){

        foreach ($this->client->getLights() as $lightId => $light) {
            echo "Id #{$lightId} - Name: {$light->getName()} -  Status:{$light->isOn()} - {$light->getName()}"."<a href=\"/hue/apagar/{$lightId}\">Apagar</a><a href=\"/hue/prender/{$lightId}\">Prender</a><br>";
        }


    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function apagar($luzId)
	{
        $lights = $this->client->getLights();
        $light = $lights[$luzId];
        if($light->getName() == 'Hue color lamp 1'){
            $light->setBrightness(1);
        }else{
            $light->setOn(false);
        }

        return redirect()->action('HueController@home');
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function prender($luzId)
	{
        $lights = $this->client->getLights();
        $light = $lights[$luzId];
        if($light->getName() == 'Hue color lamp 1') {
            $light->setBrightness(255);
        }else{
            $light->setOn(true);
        }
        return redirect()->action('HueController@home');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
