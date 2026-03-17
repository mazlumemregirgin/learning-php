<?php

// switch ifadeleri uzun uzun if-else yazmak yerine daha okunabilir ve düzenli bir yapı sağlar.
// more efficient, less code to write

$day = "Monday";

switch ($day) {
    case "Monday":
        echo "Today is Monday";
        break;
    case "Tuesday":
        echo "Today is Tuesday";
        break;
    case "Wednesday":
        echo "Today is Wednesday";
        break;
    case "Thursday":
        echo "Today is Thursday";
        break;
    case "Friday":
        echo "Today is Friday";
        break;
    case "Saturday":
    case "Sunday":
        echo "weekend";
        break;
    default:
        echo "Invalid day";
}

//burası da yine aynı şekilde java ve go gibi dillerde de aynı şekilde çalışır. sadece php de switch-case yapısında case bloklarının sonunda break ifadesi kullanılır. bu, o case bloğunun çalıştıktan sonra switch ifadesinden çıkılmasını sağlar. 
//break kullanılmazsa, o case bloğunun altındaki diğer case blokları da çalışır (fall-through denir) ve bu istenmeyen sonuçlara yol açabilir. bu nedenle php de switch-case yapısında break ifadesi kullanmak önemlidir.

// go da switch-case yapısında break ifadesi kullanmaya gerek yoktur çünkü go da switch-case yapısı otomatik olarak break ile sonlanır. yani go da bir case bloğu çalıştıktan sonra switch ifadesinden otomatik olarak çıkılır. bu nedenle go da switch-case yapısında break ifadesi kullanmak gerekmez.



/*
eski phpde switch yapısında loose comparison vardı. yani case bloklarında belirtilen değerler ile switch ifadesinde belirtilen değer arasında tür dönüşümü yapılırdı ve bu da beklenmeyen sonuçlara yol açabilirdi.
örneğin:    
switch (0) {
    case false:
        echo "This will be printed because 0 and false are considered equal in loose comparison";
        break;
    case null:
        echo "This will not be printed because 0 and null are not considered equal in loose comparison";
        break;
    default:
        echo "This will not be printed";
}
bu durumda 0 ve false birbirine eşit kabul edildiği için ilk case bloğu çalışır ve "This will be printed because 0 and false are considered equal in loose comparison" yazısı ekrana basılır. bu da beklenmeyen bir sonuç olabilir.
bu yüzden match ifadeleri tanıtıldı ve match ifadelerinde strict comparison kullanılır. yani case bloklarında belirtilen değerler ile match ifadesinde belirtilen değer arasında tür dönüşümü yapılmaz ve sadece türü ve değeri tam olarak eşit olan case bloğu çalışır. bu da daha güvenli ve beklenen sonuçlara yol açar.
örneğin:
match (0) {
    false => echo "This will not be printed because 0 and false are not considered equal in strict comparison",
    null => echo "This will not be printed because 0 and null are not considered equal in strict comparison",
    default => echo "This will be printed because 0 does not match any of the above cases"
}


*/
?>