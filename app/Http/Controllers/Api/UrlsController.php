<?php

namespace App\Http\Controllers\api;

use App\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;

class UrlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls=Url::where('user_id',Auth::user()->id)->paginate(10);

        return response()->json([
            'success' => true,
            'data' =>  $urls
        ], 200);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $validator=$this->validator($request->all());
            //dd($validator);
            if ($validator->fails()) {

                return $validator->errors()->getMessages();
    
            }else{
                $data=$request->only('path','user_id');
                $data['statu_id']=1;
                $url=Url::create($data);

                return response()->json([
                    'success' => true,
                    'data' => $url
                ], 200);    
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        $status=$url->statu;
        return response()->json([
            'success' => true,
            'data' => $status
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $url)
    {
        $validator=$this->validator($request->all());
           //dd($validator); 
        if ($validator->fails()) {

            return $validator->errors()->getMessages();
    
        }
        else
        {
            $url->update($request->only('path','user_id'));

            return response()->json([
                    'success' => true,
                    'data' => $url
            ], 200);    
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        $url->delete();
        return response()->json([
            'success' => true,
            'data' => $url
        ], 200); 
    }
    public function validator($data){

        $validator = Validator::make($data, [
            'path'     => 'required',
            'user_id'  => 'required|numeric'
        ]);
        return $validator;

    }
}
