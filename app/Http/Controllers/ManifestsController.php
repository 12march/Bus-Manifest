<?php

namespace App\Http\Controllers;

use App\Manifest;
use Illuminate\Http\Request;

class ManifestsController extends Controller
{
	public function index()
	{
		
	}

    public function store(Request $request)
    {
    	Manifest::create($this->validateRequest());
    	return redirect('/manifest');
    }

    public function update(Request $request, $id)
    {

    	Manifest::find($id)->update($this->validateRequest());

    	return redirect('/manifest');
    }

    public function destory($id)
    {
    	Manifest::find($id)->delete();

    	return redirect('/manifest');
    }


    /**
     * @return mixed
    */
    public function validateRequest()
    {
    	$validatedData = request()->validate([
	        'name' => 'required',
	        'gender' => 'required',
	        'seat_number' => 'required',
	        'phone' => 'required',
	        'address' => 'required',
    	]);

    	return $validatedData;
    }
}
