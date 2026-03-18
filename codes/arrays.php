<?php

    // array = "variable" which can hold more than one value at a time

    // tamam bunda da yeni hiçbirşey yok genel array mantığı

    $food_1= "apple";
    $food_2= "orange";
    $food_3= "banana";
    $food_4= "coconut";

    // bunları bir array içine almak istiyorsam array() methodunu kullanmalıyım.

    $foods= array($food_1,$food_2,$food_3,$food_4);

    $foods2 = [$food_1,$food_2,$food_3,$food_4]; // bu daha modern bir yazım şekli

    // echo $foods; // bu şekilde print edemem aynı şekilde javadaki gibi array to stirng conversion hataası veriyor.

    echo $foods[0]. "<br>";
    echo $foods[1]. "<br>";
    echo $foods[2]. "<br>";
    echo $foods[3]. "<br>";
    // bu şekilde manuel hepsini tek tek seçebilirim array index mantığı array_name[] ile.

    // foreach kullanarak tüm arrayi tarayabilirim
    foreach($foods as $food){
        echo $food. "<br>";
    }

    // arraydeki elemanı değştirmek istersem o indexe erişip başka birşeye setlemeliyim.
    $foods[0]= "elma";
    echo $foods[0];

    // arraye yeni elemanlar push etmek istersem array_push() fonksiyonunu kullanmalıyım.
    // parametre olarak önce arrayi sonrasnda eklemek istediğim elemanları yazılması gerekiyor.
    array_push($foods, "portakal");
    echo $foods[4];
    //veya
    $foods[] = "yeni meyve";

    // arrayin sonundan eleman pop etmek istersem array_pop() methodu kullanılmalı.
    array_pop($foods);

    // arrayin başından eleman silmek istersek array_shift() kullanılmalı
    array_shift($foods);

    // arrayi reverse etmek istersek array_reverse() methodu kullanılmalı. bunu arrayde görmek için yeni bir arraye addign etmek lazım.
    $reversed_foods= array_reverse($foods); // bu mantık javada da böyleydi method aynı şekilde çalışıyor java ile.

    foreach($reversed_foods as $reversed_food){
        echo $reversed_food. "<br>";
    } 

    // arrayde kaç eleman oludğunu kontrol etmek istersem count() methodunu kullanmalıyım.
    echo count($reversed_foods);

    // arrayde var olup olmadığını bilmek istediğin elemanları in_array() fonksiyonu ile bulabilirm. boolean döner
    in_array("orange", $foods);
    
    // arrayi alfabetik veya sayısal olarak sıralamak için sort() ama yine aynı şekilde javda oldığı gibi başka bir arraye assign etmek lazım.
    $sorted_array= sort($reversed_foods);



    /*
    Java/Go vs. PHP Dizi Mantığı
    
    javada dizilerin boyutu sabittir. fixed size yani, arrayListler ise dinamiktir.
    go da slice ve map ayrımı vardır.

    PHP'de ise ayrım yoktur.
    aynı dizinin içinde hem string, hem integeri hem de başka bir dizi tutabilrim. 
    php dizileri bellektre dinamik olarak büyür veya küçülür.

    $mix = ["Mazlum", 21, true, [1, 2, 3]]; // PHP için bu tamamen normaldir.

    
    */

?>