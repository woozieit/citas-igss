<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Clinica;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = auth()->user()->rol;

        $cardCitas = Cita::get()->count();
        $cardClinicas = Clinica::where('estado', true)->count();
        $cardAfiliados = User::Afiliados()->get()->count();

        $citas = Cita::latest()->take(10)->get();

        if ( $role === 'Afiliado' ) {
            $citas = $citas->where('afiliado_id', auth()->id())->where('fecha_cita', '>=', Carbon::now()->format('Y-m-d'));
        }

        return view('admin.home', compact(
            'cardCitas',
            'cardClinicas',
            'cardAfiliados',
            'citas',
            'role',
        ));
    }
}
