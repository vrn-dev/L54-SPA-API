<?php
namespace App\Http\Controllers;

use App\Quote;
use Illuminate\Http\Request;
use JWTAuth;

class QuoteContoller extends Controller
{
    public function postQuote (Request $request)
    {
       /* if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }*/
        $user = JWTAuth::parseToken()->toUser();
        $quote = new Quote();
        $quote->quote = $request->input('quote');
        $quote->save();
        return response()->json(['quote' => $quote, 'user' => $user], 201);
    }

    public function getQuotes ()
    {
        $quotes = Quote::all();
        $response = [
            'quotes' => $quotes
        ];
        return response()->json($response, 200);
    }

    public function putQuote (Request $request, $id)
    {
        $quote = Quote::find($id);
        if(!$quote){
            return response()->json(['message' => 'Document not Found'], 404);
        }
        $quote->quote = $request->input('quote');
        $quote->save();
        return response()->json(['quote' => $quote], 200);
    }

    public function deleteQuote ($id)
    {
        $quote = Quote::find($id);
        $quote->delete();
        return response()->json(['message' => 'Quote Deleted'], 200);
    }
}