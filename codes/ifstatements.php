<?php

$age=10;

if($age < 18) {
    echo "you are a minor";
} elseif ($age >= 18 && $age < 65) {
    echo "you are an adult";
} else {
    echo "you are a senior";
}

// javada if else syntaxıyla aynı mantık var php de de aynı şekilde çalışır. sadece php de if else blokları süslü parantezler içinde yazılır ve koşul ifadeleri parantez içinde belirtilir. 


/*

    logic operators in php are:
    1. AND (&&): returns true if both operands are true
    2. OR (||): returns true if at least one of the operands is true
    3. NOT (!): returns true if the operand is false

    example:
    
*/

$a = true;
$b = false;
echo $a && $b; // this will print false because both operands are not true
echo $a || $b; // this will print true because at least one of the operands is true
echo !$a; // this will print false because $a is true
echo !$b; // this will print true because $b is false


echo ($age >= 18 && $age < 65) ? "you are an adult" : "you are not an adult"; // this will print "you are not an adult" because $age is not between 18 and 65
// ternary operator is a shorthand for if-else statement. it takes three operands: a condition, a value to return if the condition is true, and a value to return if the condition is false. the syntax is: (condition) ? value_if_true : value_if_false;
    
// buralar da yine aynı şekilde go ve java ile aynı mantık.

?>