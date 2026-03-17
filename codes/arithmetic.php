<?php

/*
In php, there are 5 arithmetic operators:
1. Addition (+): adds two numbers together
2. Subtraction (-): subtracts one number from another
3. Multiplication (*): multiplies two numbers together
4. Division (/): divides one number by another
5. Modulus (%): returns the remainder of a division operation
*/

$a= 10;
$b= 5;
echo $a + $b ."<br>"; // this will print 15
echo $a - $b ."<br>"; // this will print 5
echo $a * $b ."<br>"; // this will print 50
echo $a / $b ."<br>"; // this will print 2
echo $a % $b ."<br>"; // this will print 0 because 10 divided by 5 has no remainder

// buradaki herşey genel programa dilleriyle aynı mantık hiç fark yok 

//increment and decrement operators
// in php, there are two types of increment and decrement operators: pre-increment and post-increment for incrementing, and pre-decrement and post-decrement for decrementing.

$x= 5;
echo $x++; // this will print 5 because post-increment returns the value before incrementing
echo $x ."<br>"; // this will print 6 because $x has been incremented by 1
$y= 5;
echo ++$y; // this will print 6 because pre-increment increments the value before returning it
echo $y ."<br>"; // this will print 6 because $y has been incremented by 1
$z= 5;
echo $z--; // this will print 5 because post-decrement returns the value before decrementing
echo $z ."<br>"; // this will print 4 because $z has been decremented by 1
$w= 5;
echo --$w; // this will print 4 because pre-decrement decrements the value
echo $w ."<br>"; // this will print 4 because $w has been decremented by 1

// burası da diğer programlama dilleriyle aynı mantık hiç fark yok increment ve decrement operatörlerinde de aynı mantık var java ve go gibi dillerde de aynı şekilde çalışır.


?>