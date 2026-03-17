<?php

// Başlangıç değerleri
$sayi = null;

// 1. ADIM: İsteğin POST olup olmadığını kontrol et (Spring'deki @PostMapping gibi)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. ADIM: $_POST süper globalinden veriyi alıyorum
    // Not: Formdaki fielad ile burada aldığım field birebir aynı olmalı, matchleşmeli
    $sayi = $_POST['input_sayi'];
    

    echo "Girilen sayı: $sayi</div>";
    echo "aşağır yuvarlamak için floor()" . floor($sayi) . "<br>";
    echo "yukarı yuvarlamak için ceil()" . ceil($sayi) . "<br>";
    echo "en yakına yuvarlamak için round()" . round($sayi) . "<br>";
    echo "karekökünü almak için sqrt()" . sqrt(abs($sayi)) . "<br>"; // Negatif sayı gelirse hata almamak için abs() kullandık
    echo "karesini almak için pow()" . pow($sayi, 2) . "<br>"; 
    echo "0 ile 100 arasında rastgele sayı" . rand(0, 100) . "<br>"; // 0 ile 100 arasında rastgele bir sayı üretir
    // rand() fonksiyonu hızlıdır ama kriptografik olarak güvenli değildir. Güvenli rastgele sayılar için random_int() fonksiyonunu kullanmam gerekir.

    echo max(1,3,5,7) . "<br>"; // verilen sayılar arasında en büyük olanı döndürür
    echo min(1,3,5,7) . "<br>"; // verilen sayılar arasında en küçük olanı döndürür

    echo pi() . "<br>"; // pi sayısını döndürür
    echo M_PI; // pi sayısını döndürür, M_PI sabiti olarak tanımlanmıştır


}



/*
anlamadığım şey şuydu: mesela html ve javascript yazdığımızda butona tıkladığımızda bişeylerin olması için javacript dosyasını tagler ile html kodunun içinde belitrmemiz 
ve javascript kdunun içinde hangi fonksiyonun tetikleneceiğini belirtmemiz gerekiyordu. bu phpde ne bir php belirteci var ne bir fonksiyon var?? 
butona basınca php kodumuzun çalışacağını nerden biliyor??

cevap: 
javascriptte bir butona onclick="hello()" derim çünkü JS tarayıcıda yaşayan bir dildir. sayfa açık kaldığı sürece o gonskiyon orada bekler.
php ise yaşamaz. sayfa yüklendiği an işi biter ve hafızadan silinir. butona bastığında aslında bir fonksiyonu değil, tüm bir dosyayı (scripti) tekrar çağırıyorum
ve o dosyanın içinde de $_POST gibi süper global değişkenler var. bu değişkenler sayesinde gelen veriyi kontrol edebiliyorum ve ona göre işlem yapabiliyorum.

<form action="mathfunctions.php" method="POST">
 method attribute'u ile formun nasıl gönderileceğini belirtiyoruz. POST methodu, form verilerini HTTP isteğinin gövdesinde gönderir. Bu, GET methoduna göre daha güvenlidir çünkü veriler URL'de görünmez.
action attribute'u ile formun hangi dosyaya gönderileceğini belirtiyoruz. Eğer action attribute'u boş bırakılırsa, form verileri aynı sayfaya gönderilir. Bu durumda, mathfunctions.php dosyasına gönderilen veriler yine mathfunctions.php dosyası tarafından işlenir.
Bu nedenle, formun action attribute'u boş bırakıldığında, form verileri aynı dosya tarafından işlenir ve bu dosyada $_POST süper global değişkeni üzerinden gelen veriyi kontrol edebiliriz. Bu, form verilerini işlemek için yaygın bir yöntemdir çünkü hem formu hem de formun işlenmesini aynı dosyada tutarak kodun düzenli ve anlaşılır olmasını sağlar.

*/

/*
o zaman mesela sadece istekte bulunan kod dosyası, fonksiyon vey class php motoru ile interprete edilip çalışıyorsa, diğer dillerden daha fazla dikkat edereken daha modüler yazmaya çalışmalıyım?

java springde uygulama ayağa kalktığında tüm classları ve fonksiyonları belleğe yükler ve gelen isteklere göre ilgili fonksiyonu çağırır. istek geldiğinde her şey çok hızlıdır.
ama phpde her istekre dosya sıfırdan okunur. eğer benim hesapla.php dosyamın içinde hiç kullanmadğım 50 tane fonksiyon veya 10 tane ağır class varsa, php her seferinde bunları da yorumlamak zorunda kalır.

buna çözüm olarak phpde require_once veya include_once gibi fonksiyonlar var. bu fonksiyonlar sayesinde sadece ihtiyacım olan dosyaları çağırabilirim ve gereksiz kodların yorumlanmasını engelleyebilirim. bu da performansı artırır.
örnek:
require_once 'mathfunctions.php'; // sadece mathfunctions.php dosyasını çağırır ve içindeki kodları yorumlar
include_once 'utils.php'; // sadece utils.php dosyasını çağırır ve içindeki kodları yorumlar


sektördeki çözüm ise şu şekilde olur:
modern phpde her dosyayı tek tek include edilmez. javadaki import mantığına benzeyen autoloading sistemini kullanılır.
composer gibi bir paket yöneticisi kullanarak autoloading sistemi kurabilirim. bu sayede sadece ihtiyacım olan sınıflar otomatik olarak yüklenir ve gereksiz kodların yorumlanması engellenir. bu da performansı artırır.

*/
?>

<!DOCTYPE html>
<html lang="tr">
<body>

    <h2>Matematik İşlemleri Formu</h2>
    
    <form method="POST" action="">
        <label for="input_sayi">Bir ondalıklı sayı girin (Örn: 3.65):</label><br>
        <input type="text" name="input_sayi" id="input_sayi" required 
               value="<?php echo $sayi; ?>">
        <button type="submit">Hesapla</button>
    </form>


</body>
</html>

