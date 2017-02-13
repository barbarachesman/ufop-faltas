<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;
use App\News;
use Excel;
use Input;
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

    public function import_page(){
      return view ('criarturma');
    }
/*
    public functionn insert_news(){
      $News = new News;
      $News->ano = $request->ano;
      $News->semestre = $request->ano;
      $News->ano = $request->ano;
      $News->ano = $request->ano;
      $News->ano = $request->ano;
      $News->ano = $request->ano;
      $News->ano = $request->ano;

    }
*/
    public function import_csv_file()
    {

      Excel::load(Input::file('file'), function ($reader) {
        $reader->each(function($sheet) {
         foreach ($sheet->toArray() as $row) {
            User::firstOrCreate($row);
         }
     });
});


    }
}
