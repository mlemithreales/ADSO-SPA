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

function registrar_cita(array &$empleados, array $servicios): void
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


    // ==========================================
    // SELECCIONAR SERVICIOS
    // ==========================================

    $servicios_cita = [];

    $agregar_servicio = "s";

    while ($agregar_servicio === "s") {

        echo "\n";
        mostrar_servicios($servicios);

        do {
            echo "Seleccione un servicio por número: ";
            $opcion_servicio = trim(fgets(STDIN));

            if (
                !is_numeric($opcion_servicio) ||
                (int)$opcion_servicio < 1 ||
                (int)$opcion_servicio > count($servicios)
            ) {
                echo "Error. Seleccione un servicio válido.\n";
            }

        } while (
            !is_numeric($opcion_servicio) ||
            (int)$opcion_servicio < 1 ||
            (int)$opcion_servicio > count($servicios)
        );


        $indice_servicio = (int)$opcion_servicio - 1;

        // Guardamos el servicio completo
        $servicios_cita[] = $servicios[$indice_servicio];


        do {
            echo "¿Desea agregar otro servicio? (s/n): ";
            $agregar_servicio = strtolower(trim(fgets(STDIN)));

            if ($agregar_servicio !== "s" && $agregar_servicio !== "n") {
                echo "Error. Responda únicamente s o n.\n";
            }

        } while ($agregar_servicio !== "s" && $agregar_servicio !== "n");
    }


    // ==========================================
    // GUARDAR LA CITA
    // ==========================================

    $cita = [
        "cliente" => $nombre_cliente,
        "dia" => $dia_cita,
        "hora" => (int)$hora_cita,
        "servicios" => $servicios_cita
    ];

    $empleados[$indice_empleado]["citas"][] = $cita;


    // ==========================================
    // MOSTRAR RESUMEN
    // ==========================================

    echo "\n";
    echo "========== CITA REGISTRADA ==========\n";

    echo "Empleado: "
        . $empleados[$indice_empleado]["nombre"]
        . "\n";

    echo "Cliente: " . $nombre_cliente . "\n";
    echo "Día: " . $dia_cita . "\n";
    echo "Hora: " . $hora_cita . "\n";

    echo "Servicios:\n";

    foreach ($servicios_cita as $servicio) {

        echo "- "
            . $servicio["servicio"]
            . " - $"
            . number_format($servicio["precio"], 0, ',', '.')
            . " - "
            . $servicio["duracion"]
            . " hora(s)\n";
    }

    echo "=====================================\n";
}
function total_facturado_empleados(array $empleados): void
{
    echo "\n";
    echo "========== TOTAL FACTURADO POR EMPLEADO ==========\n";

    if (count($empleados) === 0) {
        echo "No hay empleados registrados.\n";
        return;
    }

    $facturacion = [];

    foreach ($empleados as $empleado) {

        $total = 0;

        foreach ($empleado["citas"] as $cita) {

            foreach ($cita["servicios"] as $servicio) {
                $total += $servicio["precio"];
            }
        }

        $facturacion[] = [
            "nombre" => $empleado["nombre"],
            "total" => $total
        ];
    }

    for ($i = 0; $i < count($facturacion) - 1; $i++) {

        for ($j = $i + 1; $j < count($facturacion); $j++) {

            if ($facturacion[$j]["total"] > $facturacion[$i]["total"]) {

                $temporal = $facturacion[$i];
                $facturacion[$i] = $facturacion[$j];
                $facturacion[$j] = $temporal;
            }
        }
    }

    echo "\n";
    echo str_pad("EMPLEADO", 25);
    echo str_pad("TOTAL FACTURADO", 20);
    echo "\n";

    echo str_repeat("-", 45) . "\n";

    foreach ($facturacion as $empleado) {

        echo str_pad($empleado["nombre"], 25);

        echo "$" . number_format(
            $empleado["total"],
            0,
            ',',
            '.'
        );

        echo "\n";
    }

    echo str_repeat("-", 45) . "\n";
}
function servicio_mas_solicitado(array $empleados): void
{
    echo "\n";
    echo "========== SERVICIO MÁS SOLICITADO ==========\n";

    if (count($empleados) === 0) {
        echo "No hay empleados registrados.\n";
        return;
    }

    $servicios_contados = [];

    foreach ($empleados as $empleado) {

        foreach ($empleado["citas"] as $cita) {

            foreach ($cita["servicios"] as $servicio) {

                $nombre = $servicio["servicio"];

                if (isset($servicios_contados[$nombre])) {

                    $servicios_contados[$nombre]["cantidad"]++;

                } else {

                    $servicios_contados[$nombre] = [
                        "cantidad" => 1,
                        "precio" => $servicio["precio"]
                    ];
                }
            }
        }
    }

    if (count($servicios_contados) === 0) {
        echo "No hay servicios registrados en las citas.\n";
        return;
    }

    $nombre_mas_solicitado = "";
    $cantidad_mayor = 0;
    $precio = 0;

    foreach ($servicios_contados as $nombre => $datos) {

        if ($datos["cantidad"] > $cantidad_mayor) {

            $nombre_mas_solicitado = $nombre;
            $cantidad_mayor = $datos["cantidad"];
            $precio = $datos["precio"];
        }
    }

    $total_facturado = $cantidad_mayor * $precio;

    echo "\n";
    echo "Servicio más solicitado: " . $nombre_mas_solicitado . "\n";
    echo "Cantidad de veces: " . $cantidad_mayor . "\n";
    echo "Total facturado: $" . number_format($total_facturado, 0, ',', '.') . "\n";
}
function agenda_de_un_dia(array $empleados): void
{
    echo "\n";
    echo "========== AGENDA DE UN DÍA ==========\n";

    if (count($empleados) === 0) {
        echo "No hay empleados registrados.\n";
        return;
    }

    do {
        echo "Ingrese el día: ";
        $dia = strtolower(trim(fgets(STDIN)));

        if (!validar_dia($dia)) {
            echo "Error. Ingrese un día válido de lunes a sábado.\n";
        }

    } while (!validar_dia($dia));


    $agenda = [];

    // Recorrer los empleados
    foreach ($empleados as $empleado) {

        // Recorrer las citas del empleado
        foreach ($empleado["citas"] as $cita) {

            // Revisar si la cita corresponde al día seleccionado
            if ($cita["dia"] === $dia) {

                $agenda[] = [
                    "hora" => $cita["hora"],
                    "empleado" => $empleado["nombre"],
                    "cliente" => $cita["cliente"],
                    "servicios" => $cita["servicios"]
                ];
            }
        }
    }


    if (count($agenda) === 0) {
        echo "\nNo hay citas registradas para este día.\n";
        return;
    }


    // Ordenar las citas por hora
    for ($i = 0; $i < count($agenda) - 1; $i++) {

        for ($j = $i + 1; $j < count($agenda); $j++) {

            if ($agenda[$j]["hora"] < $agenda[$i]["hora"]) {

                $temporal = $agenda[$i];
                $agenda[$i] = $agenda[$j];
                $agenda[$j] = $temporal;
            }
        }
    }


    echo "\n";
    echo "AGENDA DEL DÍA: " . strtoupper($dia) . "\n";
    echo str_repeat("=", 70) . "\n";

    echo str_pad("HORA", 10);
    echo str_pad("EMPLEADO", 20);
    echo str_pad("CLIENTE", 20);
    echo "SERVICIOS\n";

    echo str_repeat("-", 70) . "\n";


    foreach ($agenda as $cita) {

        $nombres_servicios = [];

        foreach ($cita["servicios"] as $servicio) {
            $nombres_servicios[] = $servicio["servicio"];
        }

        $servicios_texto = implode(", ", $nombres_servicios);

        echo str_pad($cita["hora"] . ":00", 10);
        echo str_pad($cita["empleado"], 20);
        echo str_pad($cita["cliente"], 20);
        echo $servicios_texto . "\n";
    }

    echo str_repeat("=", 70) . "\n";
}
function obtener_duracion_cita(array $cita): int
{
    $duracion_total = 0;

    foreach ($cita["servicios"] as $servicio) {

        $duracion = explode(" ", $servicio["duracion"]);

        $duracion_total += (int)$duracion[0];
    }

    return $duracion_total;
}
function detectar_conflictos(array $empleados): void
{
    echo "\n";
    echo "========== DETECCIÓN DE CONFLICTOS ==========\n";

    $hay_conflicto = false;

    foreach ($empleados as $empleado) {

        $citas = $empleado["citas"];

        // Comparamos cada cita con las demás
        for ($i = 0; $i < count($citas) - 1; $i++) {

            for ($j = $i + 1; $j < count($citas); $j++) {

                // Solo se comparan si son el mismo día
                if ($citas[$i]["dia"] === $citas[$j]["dia"]) {

                    $inicio1 = $citas[$i]["hora"];
                    $duracion1 = obtener_duracion_cita($citas[$i]);
                    $fin1 = $inicio1 + $duracion1;

                    $inicio2 = $citas[$j]["hora"];
                    $duracion2 = obtener_duracion_cita($citas[$j]);
                    $fin2 = $inicio2 + $duracion2;


                    // Verificar si las citas se cruzan
                    if ($inicio1 < $fin2 && $inicio2 < $fin1) {

                        echo "\n";
                        echo "CONFLICTO DETECTADO\n";
                        echo "Empleado: " . $empleado["nombre"] . "\n";
                        echo "Día: " . $citas[$i]["dia"] . "\n";

                        echo "\nCita 1:\n";
                        echo "Cliente: " . $citas[$i]["cliente"] . "\n";
                        echo "Hora: " . $inicio1 . ":00 - " . $fin1 . ":00\n";

                        echo "\nCita 2:\n";
                        echo "Cliente: " . $citas[$j]["cliente"] . "\n";
                        echo "Hora: " . $inicio2 . ":00 - " . $fin2 . ":00\n";

                        echo "\n";

                        $hay_conflicto = true;
                    }
                }
            }
        }
    }

    if (!$hay_conflicto) {
        echo "No se encontraron conflictos de agenda.\n";
    }
}
function liquidacion_comisiones(array $empleados): void
{
    echo "\n";
    echo "========== LIQUIDACIÓN DE COMISIONES ==========\n";

    if (count($empleados) === 0) {
        echo "No hay empleados registrados.\n";
        return;
    }

    $liquidacion = [];
    $mayor_facturacion = 0;

    // Recorrer los empleados
    foreach ($empleados as $empleado) {

        $total_facturado = 0;
        $cantidad_citas = count($empleado["citas"]);

        // Calcular total facturado
        foreach ($empleado["citas"] as $cita) {

            foreach ($cita["servicios"] as $servicio) {
                $total_facturado += $servicio["precio"];
            }
        }

        // Definir porcentaje de comisión
        if ($cantidad_citas >= 6) {
            $porcentaje_comision = 0.12;
        } else {
            $porcentaje_comision = 0.08;
        }

        $comision = $total_facturado * $porcentaje_comision;

        $liquidacion[] = [
            "nombre" => $empleado["nombre"],
            "citas" => $cantidad_citas,
            "facturado" => $total_facturado,
            "porcentaje" => $porcentaje_comision,
            "comision" => $comision,
            "bono" => 0
        ];

        if ($total_facturado > $mayor_facturacion) {
            $mayor_facturacion = $total_facturado;
        }
    }


    // Dar el bono al empleado que más facturó
    foreach ($liquidacion as $indice => $empleado) {

        if ($empleado["facturado"] === $mayor_facturacion && $mayor_facturacion > 0) {

            $liquidacion[$indice]["bono"] = 50000;
        }
    }


    echo "\n";
    echo str_pad("EMPLEADO", 20);
    echo str_pad("CITAS", 10);
    echo str_pad("FACTURADO", 18);
    echo str_pad("COMISIÓN", 18);
    echo str_pad("BONO", 15);
    echo "TOTAL\n";

    echo str_repeat("-", 95) . "\n";


    foreach ($liquidacion as $empleado) {

        $total_pago = $empleado["comision"] + $empleado["bono"];

        echo str_pad($empleado["nombre"], 20);

        echo str_pad(
            $empleado["citas"],
            10
        );

        echo str_pad(
            "$" . number_format($empleado["facturado"], 0, ',', '.'),
            18
        );

        echo str_pad(
            "$" . number_format($empleado["comision"], 0, ',', '.'),
            18
        );

        echo str_pad(
            "$" . number_format($empleado["bono"], 0, ',', '.'),
            15
        );

        echo "$" . number_format($total_pago, 0, ',', '.') . "\n";
    }

    echo str_repeat("-", 95) . "\n";
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
            registrar_cita($empleados, $servicios);
            break;

        case "3":
 
            total_facturado_empleados($empleados);
            echo "\nPresione ENTER para continuar...";
            fgets(STDIN);
            break;

        case "4":
            servicio_mas_solicitado($empleados);
            echo "\nPresione ENTER para continuar...";
            fgets(STDIN);
            break;

        case "5":

            echo "Agenda de un dia\n";
            agenda_de_un_dia($empleados);
            echo "\nPresione ENTER para continuar...";
            fgets(STDIN);
            break;

        case "6":

            detectar_conflictos($empleados);
            echo "\nPresione ENTER para continuar...";
            fgets(STDIN);
            break;

        case "7":

            echo "Liquidacion de comisiones\n";
            liquidacion_comisiones($empleados);
            echo "\nPresione ENTER para continuar...";
            fgets(STDIN);
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