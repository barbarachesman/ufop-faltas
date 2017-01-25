<?php

namespace ufop-faltas\Http\Controllers;

use Illuminate\Http\Request;
use Excel;

class TurmaController extends Controller
{
    /**
     * Renderiza a página inicial do sistema.
     */
    public function home()
    {
        return view('criarturma');
    }

    /**
     * Renderiza a view contento informações sobre o sistema.
     */
    public function sobre()
    {
        return view('sobre');
    }

    public function import_csv_file()
    {
      Excel::load(input::file('csv_file'), function($reader) {
        $reader->each(function($sheet){
          Classs::firstOrCreate($sheet->toArray());
          return $sheet;
        });
      });
    }
}
