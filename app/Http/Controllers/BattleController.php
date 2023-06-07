<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class BattleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $poke1, string $poke2)
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(__DIR__.'../../log/api.log', Level::Info));

        $poke1Data = Http::get("https://pokeapi.co/api/v2/pokemon/$poke1");

        $poke2Data = Http::get("https://pokeapi.co/api/v2/pokemon/$poke2");

        if ($poke1Data == "Not Found") {
            $log->error("Pokemon 1 não existe!");
            return "Pokemon 1 não existe!";
        } 

        if ($poke2Data == "Not Found") {
            $log->error("Pokemon 2 não existe!");
            return "Pokemon 2 não existe!";
        } 

        if ($poke1Data['forms'][0]['name'] == $poke2Data['forms'][0]['name']) {
            $log->error("Não é possível fazer uma batalha com dois pokemons iguais!");
            return "Não é possível fazer uma batalha com dois pokemons iguais!";
        }

        $poke1Attack = $poke1Data['stats'][1]['base_stat'];

        $poke2Attack = $poke2Data['stats'][1]['base_stat'];

        if($poke1Attack == $poke2Attack) {
            $log->info("winner => nenhum - empate");
            return [
                "winner" => "nenhum - empate"
            ];
        }

        if ($poke1Attack > $poke2Attack) {
            $log->info("winner => {$poke1Data['forms'][0]['name']}");
            return [
                "winner" => $poke1Data['forms'][0]['name'],
            ];
        }

        $log->info("winner => {$poke2Data['forms'][0]['name']}");

        return [
            "winner" => $poke2Data['forms'][0]['name'],
        ];

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
