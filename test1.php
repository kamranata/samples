<?php
class Product {
    private string $name;
    private int $value;
    private int $cost;

    public function __construct(string $name, int $value, int $cost) {
        $this->name = $name;
        $this->value = $value;
        $this->cost = $cost;
    }
    
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}

$day1Products = [
    new Product("Product 1", 3, 200),
    new Product("Product 2", 33, 100),
    new Product("Product 3", 100, 250),
    new Product("Product 4", 10, 500),
    new Product("Product 5", 90, 125),
];
$day2Products = [
    new Product("Product 1", 2, 1),
    new Product("Product 2", 1000, 1000),
];
$day3Products = [
    new Product("Product 1", 99, 1000),
    new Product("Product 2", 95, 100),
    new Product("Product 3", 85, 400),
    new Product("Product 4", 15, 500),
];

// Замените код вашей реализацией
function findBestCombinationValue($products, int $n = 1000): int {
    usort($products, fn($a, $b) => $a->value < $b->value);

    $tmp1 = [];
    $tmp2 = [];
    $check1 = 0;
    $check2 = 0;
    foreach ($products as $product) {
        if (($c = $check1 + $product->cost) <= $n) {
            $tmp1[] = $product->value;

            $check1 = $c;
        }

        if ($product->cost != $n  && ($c = $check2 + $product->cost) <= $n) {
            $tmp2[] = $product->value;

            $check2 = $c;
        }
    }

    return max([array_sum($tmp1), array_sum($tmp2)]);
}


assert(findBestCombinationValue($day1Products) == 33+100+10+90);
assert(findBestCombinationValue($day2Products) == 1000);
assert(findBestCombinationValue($day3Products) == 95+85+15);





