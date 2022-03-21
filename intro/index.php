<h1>PHP</h1>

<p style="color:red"><?php echo sum(4, 7); ?></p>


<?php
function sum($a, $b) {
    return $a + $b;
}

define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

define('GREATING', "Hello world");

function getGreating() {
    return GREATING;
}

echo getGreating();

?>
<br>
<?php
for ($i = 0; $i < 10; $i++) {
    echo $i;
}

?>
<br>
<?php

$data = [
    'items' => [
        '5' => "value1",
        '3' => "value2",
    ]
];

$data2 = ["value1", "value2", "key" => "value3"];

$data2['key2'] = 'value4';
$data2[] = 'value4';

$a = 'This text';

$b = 'a';

echo $$b;

$var1 = 5;
$var2 = &$var1;
$var2++;

echo "<h2>" . $var1 . "</h2>";

var_dump($data2);

foreach ($data['items'] as $value) {
    echo $value;
}


class Car
{
    private $color = '';
    public function setColor($color) {
        $this->color = $color;
    }

    public function getColor() {
        return $this->color;
    }
}

$audi = new Car();
$audi->setColor('black');

$bmw = new Car();
$bmw->setColor('blue');

echo $audi->getColor();

?>

<br>
<a href="?btn=1">one</a>
<a href="?btn=2">two</a>


<?php
if (isset($_GET['btn']) && is_string($_GET['btn'])) {
    echo "<h2>" . $_GET['btn'] . "</h2>";
}


$data = [
    "next_id" => 1,
    "items" => []
];
$items = &$data['items'];
$next_id = 1;

function addItem(&$arr, &$id, $value) {
    $arr[$id++] = $value;
}

addItem($items, $next_id, 'First message');
addItem($items, $next_id, 'Second message');

var_dump($data);