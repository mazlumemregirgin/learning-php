<?php
declare(strict_types=1);

echo "<h1>PHP GET ve POST Simülasyonu</h1>";

// 1. ADIM: İsteğin tipini kontrol ediyoruz (Route mantığı gibi)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // POST ile gelen veriyi alıyoruz (Hassas/Büyük veri gibi düşün)
    // Java'daki @RequestParam String username karşılığı
    $username = $_POST['username'] ?? 'İsimsiz';
    
    echo "<div style='color:green;'>POST Başarılı! Hoş geldin: " . htmlspecialchars($username) . "</div>";

} elseif (isset($_GET['search'])) {
    
    // GET ile gelen veriyi alıyoruz (URL'deki ?search=... kısmı)
    $searchQuery = $_GET['search'];
    echo "<div style='color:blue;'>GET Sorgusu Yapıldı: " . htmlspecialchars($searchQuery) . "</div>";
}


/*
PHP'de GET ve POST verilerini almak için süper global değişkenler kullanılır:
- $_GET: URL üzerinden gönderilen verileri tutar. Örneğin, http://example.com?search=php adresine erişildiğinde $_GET['search'] değeri "php" olur.
- $_POST: Form aracılığıyla gönderilen verileri tutar. Örneğin,
<form method="POST" action="">
    <input type="text" name="username">
    <button type="submit">Gönder</button>
</form>
bu form gönderildiğinde $_POST['username'] değeri, input alanına girilen değ
er olur.

GET ve POST arasındaki farklar:
1. GET verileri URL üzerinden gönderilir, POST verileri ise HTTP isteğinin gövdesinde gönderilir.
2. GET verileri sınırlıdır (genellikle 2048 karakter), POST verileri ise daha büyük olabilir.
3. GET verileri tarayıcı geçmişine kaydedilir ve paylaşılabilir, POST verileri ise kaydedilmez ve paylaşılmaz.
4. GET verileri güvenli değildir (örneğin, şifreler gibi hassas bilgiler için uygun değildir), POST verileri ise daha güvenlidir çünkü URL'de görünmezler.
5. GET istekleri idempotenttir (aynı isteği tekrar tekrar yapmak aynı sonucu verir), POST istekleri ise idempotent değildir (aynı isteği tekrar yapmak farklı sonuçlar verebilir).
*/

/*
hiçbir esprisi yok http get ve post methodlarını simüle etmek için bu kadar kod yazmaya gerek yoktu ama php deki süper global değişkenleri göstermek için böyle bir örnek yaptım.
php de süper global değişkenler, tüm script boyunca her yerden erişilebilen özel değişkenlerdir. $_GET ve $_POST bunlardan sadece ikisidir. Diğer süper global değişkenler arasında $_SERVER, $_COOKIE, $_SESSION, $_FILES, $_REQUEST gibi değişkenler de bulunur. Bu değişkenler farklı amaçlar için kullanılır ve php'nin web geliştirme sürecinde önemli bir rol oynar.

javada mesela spring kodlarken controllerı classlarının başına @postmapping ve @getmapping gibi annotationlar koyarak hangi methodun hangi HTTP isteğiyle çalışacağını belirtiyoruz. php de ise böyle bir yapı yoktur ve doğrudan $_GET ve $_POST süper global değişkenlerini kullanarak gelen veriyi kontrol ederiz. Bu nedenle php de route mantığı gibi bir yapı oluşturmak için if-else blokları kullanırız.

java spring veya go da bir application server sürekli çalışır ve gelen istekleri dinler. gelen istekleri yakalar ve ilgili methoda route eder.
php de ise her istek geldiğinde script baştan çalışır ve $_GET veya $_POST gibi süper global değişkenler üzerinden gelen veriyi kontrol ederiz. bu nedenle php de route mantığı gibi bir yapı oluşturmak için if-else blokları kullanırız. bu yapı basit uygulamalar için yeterli olabilir ancak büyük projelerde daha karmaşık bir routing sistemi kullanmak gerekebilir. 
bu tür durumlarda php frameworkleri (örneğin Laravel, Symfony) devreye girebilir ve daha gelişmiş routing özellikleri sunabilirler.

1. PHP'nin Çalışma Felsefesi: "Die Young"
Java ve Go'da uygulama bir kez ayağa kalkar, portu dinler ve binlerce isteği aynı "yaşayan" süreç içinde karşılar. PHP'de ise durum şöyledir:
a. İstek Gelir: Tarayıcı bir butona basar.
b. Interpreter Doğar: PHP yorumlayıcısı (Interpreter) o .php dosyası için sıfırdan ayağa kalkar.
c. Süper Globaller Dolar: PHP, gelen HTTP paketini parçalar; URL'deki verileri $_GET'e, body'deki verileri $_POST'a doldurur.
d. Script Koşar: Kod yukarıdan aşağıya çalışır.
e. Interpreter Ölür: Çıktı (HTML/JSON) üretilip tarayıcıya gönderildiği an PHP interpreter o istek için tamamen kapanır. Bellekteki tüm değişkenler ($_POST, $name, $age) yok olur. Bir sonraki istekte her şey sıfırdan başlar.
*/





/*
Java, Go ve PHP Kıyaslaması
İşlem: Kullanıcıdan id parametresini alıp işlem yapmak.

Java (Spring Boot)
Uygulama belleğinde UserController objesi bir kez yaratılır ve hep orada kalır.

Java
@GetMapping("/user")
public String getUser(@RequestParam int id) {
    return "User ID: " + id;
}

Go (Standard Library)
Mux veya Router sürekli çalışır, isteği ilgili Handler fonksiyonuna paslar.

Go
func userHandler(w http.ResponseWriter, r *http.Request) {
    id := r.URL.Query().Get("id")
    fmt.Fprintf(w, "User ID: %s", id)
}

PHP (Pure Scripting)
Dosya her seferinde sıfırdan okunur. $_GET o isteğe özel bir "snapshot" (anlık görüntü) gibidir.

PHP
$id = $_GET['id'];
echo "User ID: " . $id;
// Script biter, $id ve $_GET bellekten silinir.

*/
?>

<hr>
<h3>POST Formu (Giriş Yap)</h3>
<form method="POST" action="">
    <input type="text" name="username" placeholder="Kullanıcı Adı">
    <button type="submit">Gönder (POST)</button>
</form>

<h3>GET Formu (Arama Yap)</h3>
<form method="GET" action="">
    <input type="text" name="search" placeholder="Kelime ara...">
    <button type="submit">Ara (GET)</button>
</form>

