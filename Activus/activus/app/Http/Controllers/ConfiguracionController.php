<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfiguracionGym;
use App\Models\ColorFondo;
use App\Models\HorarioFuncionamiento;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuracion = ConfiguracionGym::first();
        $coloresFondo = ColorFondo::all();

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $dias = [];

        foreach ($diasSemana as $dia) {
            $horario = $configuracion?->horarios()->where('Dia_Semana', $dia)->first();
            $dias[$dia] = [
                'habilitado' => $horario?->Habilitacion ?? false,
                'apertura' => $horario?->Hora_Apertura ?? '',
                'cierre' => $horario?->Hora_Cierre ?? '',
            ];
        }

        return view('configuraciones.index', compact('configuracion', 'coloresFondo', 'dias'));
    }

    public function storeOrUpdate(Request $request)
    {

        $id_admin = 1; //temporal hasta tener login
        $config = ConfiguracionGym::first() ?? new ConfiguracionGym(['ID_Admin' => $id_admin]);



        $rules = [
            'Nombre_Gym' => 'required|string|max:100',
            'Ubicacion' => 'required|string|max:150',
            'ID_Color_Fondo' => 'required|exists:colores_fondo,ID_Color_Fondo',
            'Color_Elemento' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'apertura' => 'required|array',
            'cierre' => 'required|array',
            'apertura.*' => 'nullable|date_format:H:i',
            'cierre.*' => 'nullable|date_format:H:i',
        ];


        if (!$config->Logo_PNG) {
            $rules['Logo_PNG'] = 'required|image|mimes:png,jpg,jpeg|max:2048';
        } else {
            $rules['Logo_PNG'] = 'nullable|image|mimes:png,jpg,jpeg|max:2048';
        }

        $validated = $request->validate($rules, [
            'Nombre_Gym.required' => 'El nombre del gimnasio es obligatorio.',
            'Ubicacion.required' => 'Debe ingresar una dirección.',
            'ID_Color_Fondo.required' => 'Debe seleccionar un color de fondo.',
            'Color_Elemento.regex' => 'El color del elemento debe ser un código hexadecimal válido (#RRGGBB).',
            'Logo_PNG.required' => 'Debe subir un logo del gimnasio.',
            'apertura.*.date_format' => 'Las horas deben tener el formato HH:MM.',
            'cierre.*.date_format' => 'Las horas deben tener el formato HH:MM.',
        ]);


        $colorFondo = ColorFondo::find($validated['ID_Color_Fondo']);
        if ($colorFondo && strcasecmp($colorFondo->Codigo_Hex, $validated['Color_Elemento']) == 0) {
            return back()->withErrors([
                'Color_Elemento' => 'El color de fondo y el color de los elementos no pueden ser iguales.'
            ])->withInput();
        }







        $config->fill([
            'Nombre_Gym' => $validated['Nombre_Gym'],
            'Ubicacion' => $validated['Ubicacion'],
            'ID_Color_Fondo' => $validated['ID_Color_Fondo'],
            'Color_Elemento' => $validated['Color_Elemento'],
        ]);

        // guardar logo nuevo , si existia eliminar el anterior 
        if ($request->hasFile('Logo_PNG')) {

            if ($config->Logo_PNG && Storage::disk('public')->exists($config->Logo_PNG)) {
                Storage::disk('public')->delete($config->Logo_PNG);
            }


            $path = $request->file('Logo_PNG')->store('logos', 'public');
            $config->Logo_PNG = $path;
        }

        $config->save();


        foreach ($request->apertura as $dia => $horaApertura) {
            $habilitado = isset($request->habilitado[$dia]);
            $horaCierre = $request->cierre[$dia] ?? null;

            if ($habilitado) {
                if (empty($horaApertura) || empty($horaCierre)) {
                    return back()->withErrors([
                        "horarios.$dia" => "El día $dia está habilitado, pero falta la hora de apertura o cierre."
                    ])->withInput();
                }

                if ($horaCierre <= $horaApertura) {
                    return back()->withErrors([
                        "horarios.$dia" => "En $dia, la hora de cierre debe ser posterior a la de apertura."
                    ])->withInput();
                }

            } else {

                if (!empty($horaApertura) || !empty($horaCierre)) {
                    return back()->withErrors([
                        "horarios.$dia" => "El día $dia tiene horarios cargados pero no está habilitado."
                    ])->withInput();
                }
            }




            HorarioFuncionamiento::updateOrCreate(
                [
                    'ID_Configuracion_Gym' => $config->ID_Configuracion_Gym,
                    'Dia_Semana' => $dia
                ],
                [
                    'Hora_Apertura' => $horaApertura,
                    'Hora_Cierre' => $horaCierre,
                    'Habilitacion' => $habilitado ? 1 : 0,
                ]
            );
        }
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('configuracion.index')
            ->with('success', 'Configuración guardada correctamente.');
    }





    public function mostrar()
    {

        $configuracion = ConfiguracionGym::with([
            'horarios' => function ($q) {
                $q->orderByRaw("FIELD(Dia_Semana, 'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')");
            }
        ])->first();
        return view('donde-entrenar.index', compact('configuracion'));
    }
}
