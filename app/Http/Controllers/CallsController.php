<?php

namespace App\Http\Controllers;

use App\Http\Resources\CallsResource;
use App\Models\Calls;
use App\Models\Ratings;
use Illuminate\Http\Request;

class CallsController extends Controller
{

  public function index()
  {
    return view('calls.index');
  }

  public function calls(string $number , string $year, string $month,string $day)
  {
    $query = Calls::query();
    if ($year>0){
      $query->whereYear('started_at',$year);
    }
    if ($month>0){
      $query->whereMonth('started_at',$month);
    }
    if ($day>0 ){
      $query->whereDay('started_at',$day);
    }
    $query->with('rating')
      ->orderBy(function($query) {
        $query->select('rating')
          ->from('ratings')
          ->whereColumn('ratings.call_id', 'calls.id')
          ->limit(1);
      }, 'DESC')
      ->orderBy('started_at', 'DESC');

    // Limit the results
    $num = $query->limit($number)->get();
    $calls = CallsResource::collection($num);
    return response()->json(['result'=>$calls],200);
  }
  public function callsByDate(Request $request)
  {
    $number = $request->query('selectNumber');
    $dateStart = $request->query('dateStart');
    $dateEnd = $request->query('dateEnd');
    $query = Calls::query();
    $query->whereBetween('started_at',[$dateStart,$dateEnd]);
    $num = $query->limit($number)
      ->orderBy('started_at','DESC')
      ->get();
    $calls = CallsResource::collection($num);
    return response()->json(['result'=>$calls],200);
  }

  public function rating(Request $request, $id)
  {
    $rating = Ratings::find($id);
    $rating->rating = $request->rating;
    $rating->save();
    return response()->json(['result'=>"Call rated successfully!"]);
  }
}
