<?php

// private - only accessible within the class
// public - accessible from anywhere
// protected - accessible within the class and by inheriting classes
// static - belongs to the class, not instances, parmanent changes in class,  

class Product
{
    public $price = 2;
    public $color = "red";
    public $total = 0;
    public static $count = 0;
    protected static $loop = 0;

    //methods

    public function calculateTotal($quantity)
    {
        $this->total = $this->price * $quantity;
        return $this->total;
    }

    public function generateId()
    {
        return rand(1000, 9999);
    }

    public function read()
    {
        return "The product is " . $this->color . " and costs $" . $this->price;
    }

    protected static function incrementCount()
    {
        self::$count = self::$count + 1;
    }

    public static function getCount()
    {
        return self::incrementCount() . "The count is " . self::$count;
    }
}


$car = new Product();
$car->color = "blue";
$car->price = 5000;
$car->calculateTotal(3);
echo "The total cost of the car is $" . $car->total . "<br>";
echo $car->color;
echo "<br>";
echo $car->price;

$car1 = new Product();
echo "<br>";
echo $car1->read();
echo "<br>";
echo $car1->color;
echo "<br>";
echo $car1->price;
echo "<br>";
echo $car1->calculateTotal(4);


$car2 = new Product();
echo "<br>";
echo Product::getCount(); // Accessing static method without creating an instance
echo "<br>";
echo Product::$count; // Accessing static property without creating an instance (will cause an error if uncommented)
echo "<br>";
echo $car2::getCount(); // Accessing static method using an instance
echo "<br>";
echo $car2::$count; // Accessing static property using an instance (will cause an error if uncommented)
echo "<br>";


$car3 = new Product();
echo $car3::$count; // Accessing static property using an instance (will cause an error if uncommented)
echo "<br>";


class Database
{
    public $hostname;
    public $db;

    public function __construct($host = "localhost", $db = "mydb")
    {
        $this->hostname = $host;
        $this->db = $db;

        echo "DB created <br>";
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            echo "Set {$name} to {$value} <br>";
        } else {
            echo "Property {$name} does not exist <br>";
        }
    }

    // Magic getter
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            echo "Property {$name} does not exist <br>";
            return null;
        }
    }

    public function __destruct()
    {
        echo "DB closed <br>";
    }
}

$db = new Database('localhost', 'testdb');
echo $db->hostname;
echo "<br>";
echo $db->db;
echo "<br>";
// Using __set
$db->hostname = "127.0.0.1";
$db->db = "testdb";

// Using __get
echo "Host: " . $db->hostname . "<br>";
echo "Database: " . $db->db . "<br>";

// Trying non-existing property
$db->username = "admin"; // Will show: Property username does not exist


class Math
{
    public function __call($name, $arguments)
    {
        if ($name == "add") {
            return array_sum($arguments);
        } elseif ($name == "multiply") {
            return array_product($arguments);
        } else {
            echo "Unknown method '$name'";
        }
    }
}

$m = new Math();
echo $m->add(2, 3, 4);
echo "<br>";     // 9
echo $m->multiply(2, 3, 4);  // 24
echo "<br>";
$m->subtract(5, 2);          // Unknown method 'subtract'
echo "<br>";


// final class - cannot be inherited
// final method - cannot be overridden in child classes
final class User
{
    private $name;
    private $email;

    public function __construct($name, $email)
    {
        $this->name  = $name;
        $this->email = $email;
    }

    // Magic method __toString
    public function __toString()
    {
        return "User: {$this->name}, Email: {$this->email}";
    }
}

$user = new User("Ishtiaq", "ishtiaq@example.com");

echo $user;


// inheritance
class Animal
{
    public static $count = 0;
    public function __construct()
    {
        self::$count++;
        echo "Animal created <br>";
    }

    public function eye()
    {
        echo "Animal have eyes <br>";
    }

    public function leg()
    {
        echo "Animal have legs <br>";
    }

    public function sound()
    {
        echo "Animal makes sound <br>";
    }
}


class Cow extends Animal
{
    public function __construct()
    {
        parent::__construct(); // Call the parent constructor
        Self::$count++;
        echo "Cow created <br>";
    }
    public function sound()
    {
        echo "Cow says Moo <br>";
    }

    public function horn()
    {
        echo "Cow has horns <br>";
    }
}


class Bull extends Cow
{
    public function __construct()
    {
        parent::__construct(); // Call the parent constructor
        self::$count++;
        echo "Bull created <br>";
    }
    // polymorphism - method overriding
    public function sound()
    {
        echo "Bull says Roar <br>";
    }

    public function muscle()
    {
        echo "Bull is very muscular <br>";
    }
}

echo "<br>";
$bull = new Bull();
$bull->eye();
$bull->leg();
$bull->sound();
$bull->horn();
$bull->muscle();
echo "Total animals: " . Animal::$count . "<br>";
echo "Total cows: " . Cow::$count . "<br>";
echo "Total bulls: " . Bull::$count . "<br>";


// abstract class - cannot be instantiated, must be inherited
// abstract method - must be implemented in child classes

abstract class A
{
    protected $var1;
    protected $var2;
    public function __construct($var1, $var2)
    {
        echo "Abstract class A constructor called <br>";
        $this->var1 = $var1;
        $this->var2 = $var2;
    }

    abstract function sum($var1, $var2);
    abstract function multiply($var1, $var2);
    abstract function divide($var1, $var2);
    protected function display()
    {
        echo "Var1: {$this->var1}, Var2: {$this->var2} <br>";
    }
}

class B extends A
{
    public function __construct($var1, $var2)
    {
        parent::__construct($var1, $var2);
        echo "Class B constructor called <br>";
    }

    public  function sum($var1, $var2)
    {
        $this->display();
        return $var1 + $var2;
    }

    public function multiply($var1, $var2)
    {
        $this->display();
        return $var1 * $var2;
    }

    public function divide($var1, $var2)
    {
        $this->display();
        if ($var2 == 0) {
            return "Division by zero error <br>";
        }
        return $var1 / $var2;
    }
}

$res = new B(10, 5);
echo "Sum: " . $res->sum(10, 5) . "<br>";
echo "Multiply: " . $res->multiply(10, 5) . "<br>";
echo "Divide: " . $res->divide(10, 5) . "<br>";

// interface - defines a contract for classes, all methods must be implemented in the class
// interfaces can be implemented by multiple classes


interface Player
{
    const team = "Team A"; // constant
    public function swimming();
    public function running();
}

interface Coach
{
    public function training();
    public function strategy();
}

interface Manager
{
    public function manage($a, $b, $c);
}

class Football implements Player, Coach, Manager
{
    public function swimming()
    {
        echo "Football player can swim <br>";
    }

    public function running()
    {
        echo "Football player can run <br>";
    }

    public function training()
    {
        echo "Football coach trains the team <br>";
    }

    public function strategy()
    {
        echo "Football coach devises strategies <br>";
    }
    public function manage($a, $b, $c)
    {
        echo "Football manager manages the team with parameters: $a, $b, $c <br>";
    }

    public function getTeam()
    {
        return self::team;
    }
}


$foo = new Football();
$foo->swimming();
$foo->running();
$foo->training();
$foo->strategy();
$foo->manage(4, 3, 3);
$foo->getTeam();
echo "Football team: " . $foo->getTeam() . "<br>";

// trait - a mechanism for code reuse in single inheritance languages like PHP
// traits are similar to classes, but are intended to group functionality in a fine-grained and consistent way
// traits cannot be instantiated on their own
trait Logger
{
    public function log($message)
    {
        echo "[LOG]: " . $message . "<br>";
    }

    public function display()
    {
        echo "This is a display method from Logger trait <br>";
    }
}
trait Validator
{
    public function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
}

class UserAccount
{
    use Logger, Validator; // using traits

    private $username;
    private $email;

    public function __construct($username, $email)
    {
        $this->username = $username;
        $this->email = $email;
        $this->log("UserAccount created for " . $this->username);
    }

    public function setEmail($email)
    {
        if ($this->validateEmail($email)) {
            $this->email = $email;
            $this->log("Email updated to " . $this->email);
        } else {
            $this->log("Invalid email: " . $email);
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function display()
    {
        echo "This is a display method from UserAccount class <br>";
    }
}
$account = new UserAccount("john_doe", "john@gmail.com");
$account->setEmail("invalid-email"); // Invalid email
$account->setEmail("john@gmail.com"); // Valid email
echo "User email: " . $account->getEmail() . "<br>";
$account->log("This is a custom log message."); // Custom log message
echo "<br>";
$account->validateEmail("john@gmail.com");
echo "<br>";
$account->validateEmail("invalid-email"); // false
echo "<br>";
$account->display(); // Calls UserAccount's display method
echo "<br>";

// chaining methods

class Person
{
    private $name;
    private $age;

    public function setName($name)
    {
        $this->name = $name;
        return $this; // Returning the object
    }

    public function setAge($age)
    {
        $this->age = $age;
        return $this; // Returning the object
    }

    public function introduce()
    {
        echo "Hi, I'm {$this->name} and I'm {$this->age} years old.<br>";
        return $this;
    }
}

$person = new Person();
$person->setName("Ishtiaq")
    ->setAge(25)
    ->introduce();


// type hinting - specifying the expected data type of a function argument
// return type declaration - specifying the expected return type of a function

function greet(string $name, int $age)
{
    return "Hello, my name is $name and I'm $age years old.<br>";
}

greet("Ishtiaq", 32); // Valid
// greet(25, "Ishtiaq"); // Invalid, will cause a TypeError

function add(float $a, float $b): float
{
    return $a + $b;
}

echo add(2.5, 3.5); // Valid
// echo add(2, "3.5"); // Invalid, will cause a TypeError
echo "<br>";


// ?array - nullable array return type
function findUser(int $id): ?array
{
    $users = [
        1 => ['name' => 'Ishtiaq', 'age' => 32],
        2 => ['name' => 'Alice', 'age' => 28],
    ];

    return $users[$id] ?? null; // Returns null if user not found
}
$user = findUser(1);
if ($user) {
    echo "User found: " . $user['name'] . ", Age: " . $user['age'] . "<br>";
} else {
    echo "User not found.<br>";
}


// union types - specifying multiple possible types for a function argument or return type (PHP 8.0+)
function processInput(int|float|string $input): int|float|string
{
    if (is_int($input)) {
        return $input * 2; // Returns int
    } elseif (is_float($input)) {
        return $input / 2; // Returns float
    } else {
        return strtoupper($input); // Returns string
    }
}

echo processInput(10); // 20
echo "<br>";
echo processInput(10.5); // 5.25
echo "<br>";
echo processInput("hello"); // "HELLO"
echo "<br>";

// mixed type - accepts any type (PHP 8.0+)
function showType(mixed $value): void
{
    var_dump($value);
    echo "<br>";
}

showType(123); // int
showType(45.67); // float
showType("Hello"); // string
showType([1, 2, 3]); // array
showType(new stdClass()); // object
showType(null); // null
echo "<br>";

// void return type - indicates that a function does not return a value (PHP 7.1+)

function logMessage(string $message): void
{
    echo "[LOG]: " . $message . "<br>";
}

logMessage("This is a log message.");
echo "<br>";

// static return type - indicates that a method returns an instance of the called class (PHP 8.0+)
class Builder
{
    private $parts = [];

    public function addPart(string $part): static
    {
        $this->parts[] = $part;
        return $this; // Returning the current instance
    }

    public function getParts(): array
    {
        return $this->parts;
    }
}
$builder = new Builder();
$builder->addPart("Engine")
    ->addPart("Wheels")
    ->addPart("Body");  // Method chaining  
print_r($builder->getParts());
echo "<br>";

class Base
{
    public function create(): static
    {
        return new static();
    }
}

class Child extends Base {}

$obj = (new Child())->create(); // Returns Child object
var_dump($obj);
echo "<br>";

// callable type - indicates that a parameter is a valid callable (PHP 8.0+)
function executeCallback(callable $callback, mixed $data): void
{
    $callback($data);
}
executeCallback(function ($data) {
    echo "Callback executed with data: " . $data . "<br>";
}, "Test Data");

// intersection types - specifying that a parameter must satisfy multiple type constraints (PHP 8.1+)
interface A1
{
    public function methodA(): void;
}
interface B1
{
    public function methodB(): void;
}
class C1 implements A1, B1
{
    public function methodA(): void
    {
        echo "Method A from interface A1<br>";
    }
    public function methodB(): void
    {
        echo "Method B from interface B1<br>";
    }
}
function useBoth(A1&B1 $obj): void
{
    $obj->methodA();
    $obj->methodB();
}
$c1 = new C1();
useBoth($c1); // Valid, C1 implements both A1 and B1    


// iterable type - indicates that a parameter or return type is iterable (PHP 7.1+)
function processItems(iterable $items): void
{
    foreach ($items as $item) {
        echo "Item: " . $item . "<br>";
    }
}
processItems([1, 2, 3, 4]); // Array
processItems(new ArrayIterator([5, 6, 7, 8])); // Traversable object
echo "<br>";

// strict types - enforce strict type checking (declare at the top of the file)

//declare(strict_types=1);
function addfloat(float $a, float $b): float
{
    return $a + $b;
}
echo addfloat(2.5, 3.5); // Valid
// echo addfloat(2, "3.5"); // Invalid, will cause a TypeError
echo "<br>";

// namespace - encapsulate code to avoid name collisions
// use - import classes, functions, or constants from a namespace

require 'user.php';

$u = new MyApp\User();
$u->sayHello();