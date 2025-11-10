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


        $id_admin = 1; // temporal hasta tener login

        // carga configuración existente o nueva
        $config = ConfiguracionGym::first();
        if (!$config) {
            $config = new ConfiguracionGym();
            $config->ID_Admin = $id_admin;
        }


        $rules = [
            'Nombre_Gym' => 'required|string|max:100',
            'Ubicacion' => 'required|string|max:150',
            'ID_Color_Fondo' => 'required|exists:colores_fondo,ID_Color_Fondo',
            'Color_Elemento' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'apertura' => 'required|array',
            'cierre' => 'required|array',
            'apertura.*' => ['nullable', 'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'],
            'cierre.*' => ['nullable', 'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'],
        ];

        // logo: obligatorio solo si no hay uno guardado todavía
        if (empty($config->Logo_PNG)) {
            $rules['Logo_PNG'] = 'required|image|mimes:png,jpg,jpeg|max:2048';
        } else {
            $rules['Logo_PNG'] = 'sometimes|nullable|image|mimes:png,jpg,jpeg|max:2048';
        }

        $validated = $request->validate($rules, [
            'Nombre_Gym.required' => 'El nombre del gimnasio es obligatorio.',
            'Ubicacion.required' => 'Debe ingresar una dirección.',
            'ID_Color_Fondo.required' => 'Debe seleccionar un color de fondo.',
            'Color_Elemento.regex' => 'El color del elemento debe ser un código hexadecimal válido (#RRGGBB).',
            'Logo_PNG.required' => 'Debe subir un logo del gimnasio.',
            'apertura.*.regex' => 'Las horas de apertura deben tener formato HH:MM o HH:MM:SS.',
            'cierre.*.regex' => 'Las horas de cierre deben tener formato HH:MM o HH:MM:SS.',
        ]);


        // color elemento y fono no pueden ser iguales 
        $colorFondo = ColorFondo::find($validated['ID_Color_Fondo']);
        if ($colorFondo && strcasecmp($colorFondo->Codigo_Hex, $validated['Color_Elemento']) == 0) {
            return back()->withErrors([
                'Color_Elemento' => 'El color de fondo y el color de los elementos no pueden ser iguales.'
            ])->withInput();
        }


        $config->Nombre_Gym = $validated['Nombre_Gym'];
        $config->Ubicacion = $validated['Ubicacion'];
        $config->ID_Color_Fondo = $validated['ID_Color_Fondo'];
        $config->Color_Elemento = $validated['Color_Elemento'];

        //nuevo logo
        if ($request->hasFile('Logo_PNG')) {
            if ($config->Logo_PNG && Storage::disk('public')->exists($config->Logo_PNG)) {
                Storage::disk('public')->delete($config->Logo_PNG);
            }
            $path = $request->file('Logo_PNG')->store('logos', 'public');
            $config->Logo_PNG = $path;
            \Log::debug('🖼️ Nuevo logo guardado en: ' . $path);
        }

        // guardar
        $config->save();



        cache()->forget('configuracion_activa');
        cache()->rememberForever('configuracion_activa', fn() => $config->fresh(['colorFondo']));

        // guardar horarios
        foreach ($request->apertura as $dia => $horaApertura) {
            $habilitado = isset($request->habilitado[$dia]);
            $horaCierre = $request->cierre[$dia] ?? null;

            if ($habilitado) {
                if (empty($horaApertura) || empty($horaCierre)) {
                    return back()->withErrors([
                        "horarios.$dia" => "El día $dia está habilitado, pero falta la hora de apertura o cierre."
                    ])->withInput();
                }


                if (strtotime($horaCierre) <= strtotime($horaApertura)) {
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
