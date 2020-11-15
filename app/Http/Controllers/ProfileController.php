<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = DB::table('profiles')->where('user_id', Auth::user()->id);
        $profiles = $profiles->get();
        return view('profile.change')->with('profiles',$profiles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aux = DB::table('profiles')
            ->select(DB::raw('count(*) as quantidade'))
            ->where('user_id', '=', Auth::user()->id)
            ->get();
            $id = Auth::user()->id;
            // foreach ($aux as $qtd => $id){
            //     $id->quantidade;
            // }
        if(($aux[0]->quantidade) < 4){
            $profile = $request->all();
            $profile['user_id'] = Auth::user()->id;

            profile::create($profile);
        }

        return redirect()->route('profile.change');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function accessProfile(Request $request, $id){
        session()->forget('error');
        // if(Auth::check()){

            $request->session()->put('profile_id', $id);
        
            $profile_name = Profile::find($id);
            $request->session()->put('profile_name', $profile_name["nome"]);

            return redirect()->route('profile.change');
        // }else{
        //     return redirect()->route('login');
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session()->forget('error');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        session()->forget('error');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        session()->forget('error');
        if($id==session()->get('profile_id', [1])){
            session()->put('error', "Erro, acesse por outro perfil para remover");
        }else{
            $profile = Profile::findOrFail ($id);
            $profile->delete();
        }
        return redirect()->route('profile.change');
        

    }
}
