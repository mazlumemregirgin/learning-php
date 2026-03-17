<?php 

echo "Hello, World!";
echo"merhaba dünya<br>";

// this is a comment

/*
this is a multi-line comment like java, c#, c++ and many more languages.
*/

//variables
// in php variables start with $ sign and there is no need to declare the type of variable 
//like int, string, double, float etc. because php is a loosely typed language.

/*
In php, there are 8 data types:
1. String: a sequence of characters enclosed in quotes (single or double)   
2. Integer: a whole number without a decimal point
3. Double (also called float): a number with a decimal point
4. Boolean: a variable that can only have two values: true or false
5. Array: a collection of values indexed by keys (can be numeric or associative)
6. Object: an instance of a class that can have properties and methods
7. NULL: a variable that has no value
8. Resource: a special variable that holds a reference to an external resource (like a database connection or a file handle)

*/

$name= "mazlum emre"; // string variable
echo $name;

$surname= "girgin"; // string variable
echo "my full name is  $name $surname";

$email= "mazlum.emre@girgin.com"; // string variable
echo "my email is $email";

$age= 21; // integer variable
$price= 4.99; // double variable (also called float in some languages)

$employed= true; // boolean variable
echo "am i employed? $employed"; // this will print 1 because true is represented as 1 in php
$online= false; // boolean variable 
echo "am i online? $online"; // this will print nothing because false is represented as empty string in php


$languages= ["php", "java", "python"]; // array variable
echo $languages[0]; // this will print php
echo $languages[1]; // this will print java //indeksleme aynı java ve go gibi fark yok dizilerde


$value= null; // null variable
echo $value; // this will print nothing because null is represented as empty string in php

// Constants
// in php constants are defined using define() function and they are case-sensitive by default
define("PI", 3.14); // defining a constant named PI with value 3.14
echo "the value of PI is " . PI; // this will print the value of PI

// get to know the type of variable using gettype() function
echo gettype($name); // this will print string
echo gettype($age); // this will print integer
echo gettype($price); // this will print double
echo gettype($employed); // this will print boolean
echo gettype($languages); // this will print array
echo gettype($value); // this will print NULL

var_dump($name); // this will print the type and value of $name variable
var_dump($age); // this will print the type and value of $age variable

// the difference between gettype() and var_dump() is that gettype() only returns the type of variable as a string, while var_dump() returns both the type and value of variable in a more detailed way.

// java statically type olarak değişkeni tanımlarken tipini de belirtmek zorundayız. Örneğin: int age = 21; String name = "mazlum emre"; gibi. 
//Ancak php'de böyle bir zorunluluk yoktur ve değişkenin tipi otomatik olarak atanır. Bu nedenle php'ye loosely typed language denir.

/*
php de bu sıkıntıyı aşmak için type hinting ve strict types gibi özellikler eklenmiştir. Type hinting ile fonksiyon parametrelerinin ve dönüş değerlerinin tipini belirtebiliriz. 
Strict types ise tüm dosyada tip kontrolünü zorunlu kılarak daha güvenli kod yazmamızı sağlar. Ancak bu özellikler opsiyoneldir ve kullanmak zorunda değilsiniz.

normal kod içinde değişken tnaımlarken yine aynı şekilde tip belirtmeden tanımlamak zorundayız.    
Ancak fonksiyonlarda type hinting kullanarak parametrelerin ve dönüş değerlerinin tipini belirtebiliriz. Örneğin:
function add(int $a, int $b): int {
    return $a + $b;
}
 veya classlarda propertylerin tipini belirtebiliriz. Örneğin:
class User {
    public string $name;
    public int $age;

    public function __construct(string $name, int $age) {
        $this->name = $name;
        $this->age = $age;
    }

php hızlı geliştirme için esnek bir dildir.
HIZZZZZ

*/

?>