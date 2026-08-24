<?php
$empleados = [];
$empleados_prueba = [
    [
        "nombre" => "Juan Camilo",
        "especialidad" => "Limpieza facial,Pedicure",
    ],
    [
        "nombre" => "Meisil",
        "especialidad" => "Masajerelajante,Manicure",
    ],
    [
        "nombre" => "Carolina",
        "especialidad" => "Exfoliación corporal,Masajedescontracturante",
    ],
    [
        "nombre" => "Evelyn",
        "especialidad" => "Tratamiento antiedad",
    ]
];
$servicios = [
    [
        "servicio" => "Limpieza facial",
        "precio" => 80000,
        "duracion" => "2 horas"
    ],
    [
        "servicio" => "Manicure",
        "precio" => 35000,
        "duracion" => "1 hora"
    ],
    [
        "servicio" => "Pedicure",
        "precio" => 40000,
        "duracion" => "1 hora"
    ],
    [
        "servicio" => "Masajerelajante",
        "precio" => 90000,
        "duracion" => "1 hora"
    ],
    [
        "servicio" => "Masajedescontracturante",
        "precio" => 100000,
        "duracion" => "1 hora"
    ],
    [
        "servicio" => "Exfoliación corporal",
        "precio" => 60000,
        "duracion" => "1 hora"
    ],
    [
        "servicio" => "Tratamiento antiedad",
        "precio" => 120000,
        "duracion" => "2 horas"
    ]
];
function mostrar_menu(): void
{
    echo "=============================\n";
    echo "       SPA ADSO\n";
    echo "1. Registrar empleado\n";
    echo "2. Registrar cita\n";
    echo "3. Total facturado por empleado\n";
    echo "4. Servicio más solicitado\n";
    echo "5. Agenda de un día\n";
    echo "6. Detección de conflictos\n";
    echo "7. Liquidación de comisiones\n";
    echo "8. Salir\n";
    echo "=============================\n";
}
function validar_opcion(string $opcion_menu): bool
{
    switch ($opcion_menu){

        case "1":
        case "2":
        case "3":
        case "4":
        case "5":
        case "6":
        case "7":
        case "8":
        case "dp":
            return true;

        default:
            return false;
    }
}
function solicitar_texto(string $mensaje): string
{
    do {
        echo $mensaje;
        $texto_ingresado = trim(fgets(STDIN));
        if ($texto_ingresado === '') {
            echo "Error. Este campo no puede quedar vacío.\n";
        }
    } while ($texto_ingresado === '');
    return $texto_ingresado;
}
function registrar_empleados(array & $empleados): void
{
    $continuar_registro = 's';

    while ($continuar_registro === 's') {
        echo "\n";
        echo "=============================\n";
        echo "     REGISTRAR EMPLEADO\n";
        $nombre_empleado = solicitar_texto(
            "Ingrese el nombre del empleado: "
        );
        $especialidad_empleado = solicitar_texto(
            "Ingrese la especialidad del empleado: "
        );
        $empleados[] = [
            "nombre" => $nombre_empleado,
            "especialidad" => $especialidad_empleado,
            "citas" => [],
        ];
        echo "\nEmpleado registrado correctamente.\n";
        do {
            echo "¿Desea registrar otro empleado? (s/n): ";
            $continuar_registro = strtolower(trim(fgets(STDIN)));

            if ($continuar_registro !== 's' && $continuar_registro !== 'n') {
                echo "Error. Responda únicamente s o n.\n";
            }
        } while ($continuar_registro !== 's' && $continuar_registro !== 'n');
    }
}
function mostrar_empleados(array $empleados): int
{
    echo "EMPLEADOS DISPONIBLES:\n";
    foreach ($empleados as $indice => $empleado) {
        echo ($indice + 1) . ". ". $empleado["nombre"]. " - Especialidad: ". $empleado["especialidad"]. "\n";     
    }
    do {
        echo "Seleccione un empleado por número: ";
        $opcion_empleado = trim(fgets(STDIN));

        if (!is_numeric($opcion_empleado)|| (int) $opcion_empleado < 1 || (int) $opcion_empleado > count($empleados))
        {
            echo "Error. Seleccione un número válido.\n";
        }
    } while (!is_numeric($opcion_empleado)|| (int) $opcion_empleado < 1 || (int) $opcion_empleado > count($empleados));

    return (int) $opcion_empleado - 1;
}
function validar_dia(string $dia): bool
{
    $dias_validos = [
        "lunes",
        "martes",
        "miércoles",
        "jueves",
        "viernes",
        "sábado",
    ];

    return in_array($dia, $dias_validos, true);
}
function mostrar_servicios(array $servicios): void
{
    echo "SERVICIOS DISPONIBLES:\n";
    foreach ($servicios as $indice => $servicio) {
        echo ($indice + 1) . ". ". $servicio["servicio"]. " - Precio: ". $servicio["precio"]. " - Duración: ". $servicio["duracion"]. "\n";     
    }
}
function validar_hora(string $hora): bool
{
    if (!is_numeric($hora)) {
        return false;
    }
    $hora = (int) $hora;
    return $hora >= 8 && $hora <= 18;
}

function registrar_cita(array &$empleados): void
{
    if (count($empleados) === 0) {
        echo "No hay empleados registrados.\n";
        echo "Primero debe registrar un empleado.\n";
        return;
    }

    echo "\n";
    echo "========== REGISTRAR CITA ==========\n";

    $indice_empleado = mostrar_empleados($empleados);

    $nombre_cliente = solicitar_texto(
        "Ingrese el nombre del cliente: "
    );

    do {
        echo "Ingrese el dia de la cita: ";
        $dia_cita = strtolower(trim(fgets(STDIN)));

        if (!validar_dia($dia_cita)) {
            echo "Error. El dia debe ser de lunes a sabado.\n";
        }
    } while (!validar_dia($dia_cita));

    do {
        echo "Ingrese la hora de inicio (8 - 18): ";
        $hora_cita = trim(fgets(STDIN));

        if (!validar_hora($hora_cita)) {
            echo "Error. La hora debe estar entre 8 y 18.\n";
        }
    } while (!validar_hora($hora_cita));

    echo "\n";
    echo "Datos de la cita:\n";
    echo "Empleado: " . $empleados[$indice_empleado]["nombre"] . "\n";
    echo "Cliente: " . $nombre_cliente . "\n";
    echo "Día: " . $dia_cita . "\n";
    echo "Hora: " . $hora_cita . "\n";
}


$programa_activo = true;
while ($programa_activo) {

    mostrar_menu();
    echo "Seleccione una opción: ";
    $opcion_menu = trim(fgets(STDIN));
    if (!validar_opcion($opcion_menu)) {

        echo "\n";
        echo "Error. Intente nuevamente.\n";
        continue;
    }
    //Probando switch 
    switch ($opcion_menu) {

        case "1":
            registrar_empleados($empleados);
            break;

        case "2":
            registrar_cita($empleados);
            break;

        case "3":

            echo "\n";
            echo "Total facturado por empleado\n";
            break;

        case "4":

            echo "\n";
            echo "Servicio mas solicitado\n";
            break;

        case "5":

            echo "\n";
            echo "Agenda de un dia\n";
            break;

        case "6":

            echo "\n";
            echo "Deteccion de conflictos\n";
            break;

        case "7":

            echo "\n";
            echo "Liquidacion de comisiones\n";
            break;

        case "8":

            echo "\n";
            echo "Gracias por utilizar el sistema ADSO-SPA.\n";
            $programa_activo = false;
            break;

        case "dp":

            echo "\n";
            echo "Opcion de datos de prueba seleccionada.\n";
            break;
    }
}

?>