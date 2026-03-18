<?php

    // for loop = repeat some code a ceratin # of times
    for ($i=0; $i < 5; $i++) { 
        echo "hello world <br>";
    }
    // java ve goda syntaxıyla aynı mantık var neredeyse herşeyi aynı. başlangıç, koşul ve artış ifadeler bulunur.



    $counter = $_POST["counter"] ?? 0; // formdan gelen değeri alır, eğer değer yoksa 0 olarak varsayılan değeri atar
    for ($i=0; $i < $counter; $i++) { 
        echo "hello world <br>";
    }
    // bu şekilde formdan gelen değere göre for loopun kaç kere çalışacağını belirleyebilirim. 
    //formdan gelen değeri $counter değişkenine atıyorum ve for loopun koşul ifadesinde $counter değişkenini kullanarak loopun kaç kere çalışacağını belirliyorum.



    // while loop = do some code infinitely while some condiiton remains true
    $base= 0;
    while($base<10){
        $base++;
        echo $base . "<br>" ;
    }
    // burası da easy peezy hiç fark yok
?>

    <html>
    <head>
        <title>My PHP Page</title>
    </head>
    <body>
        <p>This is a simple PHP page with a for loop.</p>

        <form action="" method="post">
            <input type="text" name="counter">
            <button type="submit">Submit</button>
        </form>

    </body>
    </html>