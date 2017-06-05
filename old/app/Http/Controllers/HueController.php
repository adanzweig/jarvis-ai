<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Phue;
class HueController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    public function home(){
        $client = new Phue\Client('192.168.0.10', 'coauPtOkg8KhnshBxP6FeuzdRFOtRqKdSe5ZBPfv');
        foreach ($client->getLights() as $lightId => $light) {
            echo "Id #{$lightId} - {$light->getName()}", "\n";
        }


    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function apagar($luzId)
	{
        $client = new Phue\Client('10.0.1.1', 'yourusername');
        $lights = $client->getLights();
        $light = $lights[$luzId];
        $light->setOn(false);

    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function prender($luzId)
	{
        $client = new Phue\Client('10.0.1.1', 'yourusername');
        $lights = $client->getLights();
        $light = $lights[$luzId];
        $light->setOn(true);
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
