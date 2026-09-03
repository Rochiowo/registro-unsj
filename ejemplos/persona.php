Respond and generate suggestions in Spanish when the original text is in Spanish.

class Persona {
    private $name;
    private $age;

    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }

    public function saludar() {
        return "Hola, mi nombre es $this->name y tengo $this->age años.";
    }

}

$persona = new Persona("Rochi", 20);
echo $persona->saludar();

$color = "rojo";
echo "Mi color favorito es $color.";