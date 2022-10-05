<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Chancho;
use Illuminate\Http\Request;

class ChanchoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chanchos = Chancho::all();

        return view('chanchos.index', compact('chanchos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chanchos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* dd($request); */
        $chancho = new Chancho();
        $chancho->fecha = Carbon::now()->toDateString();
        $chancho->usuario = $request->usuario;
        $chancho->costilla_kilos = $request->costilla_kilos;
        $chancho->costilla_marinado = $request->costilla_marinado;
        $chancho->costilla_horneado = $request->costilla_horneado;
        $chancho->costilla_cortado = $request->costilla_cortado;

        $chancho->pierna_kilos = $request->pierna_kilos;
        $chancho->pierna_marinado = $request->pierna_marinado;
        $chancho->pierna_horneado = $request->pierna_horneado;
        $chancho->pierna_cortada = $request->pierna_cortada;
        $chancho->chancho_enviado = $request->chancho_enviado;

        $chancho->save();

        return redirect()->route('chanchos.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chancho = Chancho::find($id);
        return view('chanchos.show', compact('chancho'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
