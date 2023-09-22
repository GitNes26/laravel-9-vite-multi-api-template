<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use App\Models\GomezApp\Report;
use App\Models\GomezApp\InfoCards;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function index(Response $response)
    {

        $response = Report::all();
        return response()->json($response);
    }

    public function getCards(Response $response){
        $response = InfoCards::all();
        return response()->json($response);

    }
}
