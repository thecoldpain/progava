<?php

// ============================================================
// CLASE Socio:
// Representa a un socio del sistema con sus datos personales.
// Las propiedades son privadas: solo se acceden desde afuera
// mediante getters y setters (encapsulamiento).
// ============================================================

class Socio
{
    // el porque de propiedades privadas: no se pueden leer ni modificar
    // directamente desde fuera de la clase.
    private string $nombre;
    private string $cedula;
    private string $email;

    // Constructor: se ejecuta automáticamente al hacer new Socio(...).
    // Recibe los 3 datos y los asigna a las propiedades del objeto.
    //con $this -> hago referencia al objeto actual que se está creando.
    public function __construct(string $nombre, string $cedula, string $email)
    {
        $this->nombre = $nombre;
        $this->cedula = $cedula;
        $this->email  = $email;
    }

    // --- GETTERS ---
    // Son Métodos públicos que permiten leer las propiedades privadas
    // desde fuera de la clase (me retornan el valor de la propiedad).

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getCedula(): string
    {
        return $this->cedula;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    // --- SETTERS ---
    // Son Métodos públicos que permiten modificar las propiedades privadas
    // desde fuera de la clase. Devuelven void ((vacio) no retornan nada).

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setCedula(string $cedula): void
    {
        $this->cedula = $cedula;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}


// ============================================================
// LÓGICA PRINCIPAL:
// Array de objetos donde se almacenan los socios en memoria
// durante la ejecución del script (no persiste al cerrar).
// ============================================================

$socios = []; // array vacío que irá acumulando objetos Socio


// ============================================================
// FUNCIONES AUXILIARES:
// Encapsulan lógica reutilizable fuera del menú principal.
// Verifica si ya existe un socio con esa cédula en el array
// Recorre $socios y compara cédulas con ===  (estricto: mismo valor y tipo)
// Devuelve true si encuentra coincidencia, false si no.
// ============================================================
function cedulaExiste(array $socios, string $cedula): bool
{
    foreach ($socios as $socio)
    {
        if ($socio->getCedula() === $cedula)
        {
            return true; // encontró duplicado, no hace falta seguir buscando
        }
    }
    return false; // recorrió todo el array y no encontró la cédula
}

// Busca un socio por cédula y lo devuelve si existe.
// Devuelve el objeto Socio encontrado, o null si no existe.
// ?Socio = tipo nullable: puede devolver Socio o null.
function buscarPorCedula(array $socios, string $cedula): ?Socio
{
    foreach ($socios as $socio)
    {
        if ($socio->getCedula() === $cedula)
        {
            return $socio; // devuelve el objeto encontrado
        }
    }
    return null; // no encontró ningún socio con esa cédula
}


// ============================================================
//  porque MENÚ INTERACTIVO — do-while:
// Se usa do-while porque el menú debe mostrarse AL MENOS UNA VEZ
// antes de evaluar si el usuario quiere salir.
// ============================================================

do
{
    // Muestra las opciones disponibles en cada iteración
    echo "\n===== SISTEMA DE SOCIOS =====\n";
    echo "1. Agregar socio\n";
    echo "2. Buscar socio por cédula\n";
    echo "3. Salir\n";

    // readline() lee lo que el usuario escribe en consola y lo devuelve como string
    $opcion = readline("Ingrese opción: ");

    // Evalúa la opción elegida con if/elseif
    if ($opcion === '1')
    {
    // opcion: 1 --- AGREGAR SOCIO ---

        // Lee los datos del nuevo socio desde consola
        $nombre = readline("Nombre: ");
        $cedula = readline("Cédula: ");
        $email  = readline("Email: ");

        // Antes de agregar, verifica que la cédula no esté registrada
        echo "⚠ Ya existe un socio con esa cédula.\n";
        // cedulaExiste() recorre el array y devuelve true/false
        if (cedulaExiste($socios, $cedula))
        {
            // Si devuelve true, la cédula ya existe → no agrega y avisa
        }
        else
        {
            // Si devuelve false, la cédula es nueva → crea el objeto y lo agrega
            // new Socio(...) instancia la clase y llama al constructor automáticamente
            $nuevoSocio = new Socio($nombre, $cedula, $email);

            // $socios[] = agrega el objeto al final del array (equivale a array_push para un elemento)
            $socios[] = $nuevoSocio;

            echo "✓ Socio agregado correctamente.\n";
        }
    }
    elseif ($opcion === '2')
    {
    //opcion 2: --- BUSCAR SOCIO ---

        $cedula  = readline("Ingrese cédula a buscar: ");

        // buscarPorCedula() devuelve el objeto Socio o null
        $encontrado = buscarPorCedula($socios, $cedula);

        if ($encontrado === null)
        {
            // null significa que no se encontró ningún socio con esa cédula
            echo "✗ No se encontró ningún socio con esa cédula.\n";
        }
        else
        {
            // Si no es null, es un objeto Socio → accedemos a sus datos con getters
            echo "\n--- Socio encontrado ---\n";
            echo "Nombre : " . $encontrado->getNombre() . "\n";
            echo "Cédula : " . $encontrado->getCedula() . "\n";
            echo "Email  : " . $encontrado->getEmail()  . "\n";
        }
    }
    elseif ($opcion === '3')
    {
    // opcion 3: --- SALIR ---
        // Solo muestra el mensaje; la condición del do-while se encarga de cortar el bucle
        echo "Saliendo del sistema...\n";
    }
    else
    {
        // Opción inválida: no es 1, 2 ni 3
        echo "Opción no válida. Intente de nuevo.\n";
    }

// La condición se evalúa DESPUÉS de cada iteración (característica del do-while)
// Mientras la opción no sea '3', el menú vuelve a mostrarse (esta digitando una opcion invalida).
} while ($opcion !== '3');