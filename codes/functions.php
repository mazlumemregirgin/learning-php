<?php

    // function = write some code once, reuse when you need it

    //function function_name() syntaxı ile oluşturulur. 
    function hello(){
        echo "merhaba";
    }

    // fonksiyon parametre alabilir. birden fazla da alabilir ihtiyaca göre.
    function hi($name){
        echo "merhaba". $name;
    }

    hello();    
    hi("emre");

    // fonksiyonumuzun birşeyler return etmesini sağlayabiliriz return keywordu ile.
    function is_even($number){
        $result = $number % 2;
        return $result;
    }

    echo is_even(11);

    function hypotenuse($number1, $number2){
        $hypo = ($number1 **2) + ($number2 **2);
        return $hypo;
    }

    echo hypotenuse(3,4);
    //echo hypotenuse("kısa kenar", "uzun kenar"); // uncaught type error verir çünkü fonkisyonumuzu int alıyordu biz string girdik.
    // bu sorunu önceden handle edebilmek için fonksiyonu tanımlarken  parametre kısmına tiplerini de yazarsak daha mantıklı error hataları alırız.
    function hypo(int $num1, int $num2): int{ // reutrn tipini de belirtebilirim.
        return ($num1 **2) + ($num2 **2);
    }


    // phpde method overloading yoktur. fonksiyonun signatureı eşsiz olmalı.
    function hypos(int $num1, int $num2){
        return ($num1 **2) + ($num2 **2);
    }

    echo hypo(3,5);
    echo hypo("kısa kenar", "uzun kenar");


    // bir fonksiyonun bazen bir tip, bazen de null döndürmesini istiyorsam tipin başına ? koymalıyım.
    // javadaki Optional mantığı gibi aslında.
    function getUsername(int $id): ?string {
        if ($id === 1) return "Mazlum";
        return null; // ID bulunamazsa hata değil, null döner
    }


    /* splat operator / variadic functions
     go'daki variadic funcitons yapısının birebir aynısıdır. fonknsiyonun kaçç tane parametre alacağını
     bilmediğimiz durumlarda kullanlılr.
     */
    function sumAll(...$numbers) {
    // $numbers artık bir Array (Dizi) gibi davranır
    return array_sum($numbers);
    }

    echo sumAll(1, 2, 3, 4, 5); // 15


    // anonymous functions: modern phpde fonksiyonları bir değişkene atayabilirim.
    $greet = function($name) {
    return "Selam $name";
    };
    echo $greet("Emre");

    /*
    phpde değişkenler java ve go ile olduğu gibi value ile iletilir. yani bir kopyası
    eğer fonksiyona soktuğumuz variableın gerçekten değerinin de değişmesini istiyorsak refernce ile sokmalıyız.
    go daki aynı mantık;
    function increment(&$number) { $number++; } // Referansla geçiş

    java da aslında böyle yapar ama syntax olarak böyle gözükmez.
    */


    /*
    phpde Strict Types nedir?

    php'de declare(strict_types=1); yazmanın önemi:
    php varsayılan olarak coercive moddadır. yani int bekleyen bir fonksiyona "5" gönderirsek php bunu sessizce dönüştürür.
    ancak dosyanın en başına strict_types=1 eklersek, tip uyumsuzluklarında TypeError fırlatır. Bu da runtime 
    hatalarını azaltır ve kodun öngörülebilirliğini artırır.
    */

?>