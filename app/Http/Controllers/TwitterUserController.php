<?php

namespace App\Http\Controllers;

use App\Services\ParseTwitter;
use App\TwitterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use TwitterParse;


class TwitterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = TwitterUser::all();

        return view('main', compact('users'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
            ]);

            $res = TwitterParse::getParseResult($request->get('name'));

            $user = TwitterUser::firstOrNew(
                array('twitter_id' => $res['twitterId']));
            $user->photo = $res['photo'];
            $user->name = $res['name'];
            $user->description = $res['description'];
            $user->tweets = $res['tweets'];
            $user->following = $res['following'];
            $user->followers = $res['followers'];
            $user->likes = $res['likes'];
            $user->save();

            return redirect()->back();
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
