/*
Предварительно
Вы можете работать над заданиями в любом удобном для вас редакторе или даже в документе.
У вас есть 60 минут.
Контекст
У компании есть N денежных единиц на приобретение товаров в день. Деньги с текущего дня не переходят на последующие.
Структура товара:
Имя товара. Строка.
Ценность. Число. Чем больше, тем выше ценность.
Стоимость. Число. Чем больше, тем выше стоимость.
Задача
Написать функцию поиска максимальной суммы ценностей комбинации товаров, сумма стоимостей которых меньше чем N.

День 1.
Входные данные:
Товар 1. Ценность: 3. Стоимость: 200
Товар 2. Ценность: 33. Стоимость: 100
Товар 3. Ценность: 100. Стоимость: 250
Товар 4. Ценность: 10. Стоимость: 500
Товар 5. Ценность: 90. Стоимость: 125
Выходные данные (порядок не имеет значения):
Товар 5, Товар 3, Товар 2, Товар 4
Объяснение:
Сумма ценности будет 33+100+10+90=233. Никакая другая комбинация не позволяет достичь такой ценности при учете ограничения в 1000 денежных единиц.

День 2.
Входные данные:
Товар 1. Ценность: 2. Стоимость: 1
Товар 2. Ценность: 1000. Стоимость: 1000
Выходные данные (порядок не имеет значения):
Товар 2
Объяснение:
Взять 2 товара мы не можем, так как их суммарная стоимость будет больше лимита.

День 3.
Входные данные:
Товар 1. Ценность: 99. Стоимость: 1000
Товар 2. Ценность: 95. Стоимость: 100
Товар 3. Ценность: 85. Стоимость: 400
Товар 4. Ценность: 15. Стоимость: 500
Выходные (порядок не имеет значения):
Товар 2, Товар 3, Товар 4

Для реализации можно использовать PHP или другой язык.

Обращаем внимание.
Проще всего достичь результата полным перебором всех вариантов с выбором оптимального.
Также, для простоты можете считать, что в день не бывает более 10 товаров на выбор.
*/

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





