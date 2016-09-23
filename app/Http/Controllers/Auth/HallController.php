<?php

namespace App\Http\Controllers;

use App\Hall;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HallController extends Controller
{
    protected $hall;

    public function __construct(Hall $hall)
    {
        $this->hall = $hall;
    }

    public function getHalls()
    {
        $halls = $this->hall->all();

        return response()->json($halls, 200);
    }

    public function getHallById($id)
    {
        $hall = $this->hall->where('hall', $id)->get();

        return response()->json($hall, 200);
    }

    public function createHall()
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'description' => 'required',
        ]);

        $category = $this->category->create($request->all());
        
        if ($category) {
            return response()->json($category, 201);
        }

        return response()->json(['message' => 'Oops, category creation was Unsuccesful'], 400);
    }

    // public function updateHall()
    // {

    // }

    // public function deleteHall()
    // {
        
    // }
}
