<?php

$empleados = [
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
function MostrarMenu()
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
function ValidarOpcion($opcion_menu)
{
    switch ($opcion_menu) {

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
$programa_activo = true;
while ($programa_activo) {

    MostrarMenu();
    echo "Seleccione una opción: ";
    $opcion_menu = trim(fgets(STDIN));
    if (!ValidarOpcion($opcion_menu)) {

        echo "\n";
        echo "Error. Intente nuevamente.\n";
        continue;
    }
    //Probando switch 
    switch ($opcion_menu) {

        case "1":

            echo "\n";
            echo "Registrar empleado\n";
            break;

        case "2":

            echo "\n";
            echo "Registrar cita\n";
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
