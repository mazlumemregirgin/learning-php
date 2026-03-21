<?php
/**

 * Java'da değişkeni kullanmadan önce tanımlamak ZORUNLUDUR.
 * Tanımlanmamış değişkeni kullanmaya çalışırsan kod derlenmez
 * bile (compile-time güvenliği).
 
 * PHP'de böyle bir zorunluluk yoktur. Değişken var mı, yok mu?
 * Bu soruyu RUNTIME'DA ben sormalıyım. isset() ve empty() fonksiyonları bu işe yarar.
 *
 */


// ============================================================
// BÖLÜM 1: isset() — "Bu değişken hayatta mı?"
// ============================================================
//
// Java karşılığı: map.containsKey("key") && map.get("key") != null
//
// isset($var) → TRUE  döner: değişken tanımlı VE null değil
// isset($var) → FALSE döner: değişken hiç yok VEYA değeri null
//
// ÖNEMLİ: PHP'de null = "yok" demektir. Java'da null bir nesne
// referansıdır, varlığı kesindir. PHP'de null atanmış değişkeni
// isset() "yok" sayar — bu en sık şaşırılan noktadır!

$tanimi_var   = "Merhaba";   // Tanımlı, null değil
$null_atanmis = null;         // Tanımlı AMA null
// $hic_yazilmadi            // Hiç tanımlanmadı

var_dump(isset($tanimi_var));    // bool(true)   Var ve dolu
var_dump(isset($null_atanmis));  // bool(false)  null = "yok"
var_dump(isset($hic_yazilmadi)); // bool(false)  Hiç tanımlanmadı

// Aynı anda birden fazla değişken de kontrol edilebilir:
// isset($a, $b, $c) → üçü de tanımlı ve null değilse true döner
// Java'daki: a != null && b != null && c != null


// ============================================================
// BÖLÜM 2: empty() — "Bu değişken işe yarar mı?"
// ============================================================
//
// Java'da şunu yapardık:
//   if (str == null || str.trim().isEmpty() || num == 0 || list.size() == 0)
//
// PHP'de empty() bunların TÜMÜNÜ tek seferde yakalar!
//
// PHP'de "boş" kabul edilen değerler:
//   ""      → Boş string
//   "0"     → Sıfır STRING'i (dikkat! Java'da bu boş sayılmaz)
//   0       → Sıfır integer
//   0.0     → Sıfır float
//   null    → Null değer
//   false   → Boolean false
//   []      → Boş array
//
// Bunların DIŞINDA kalan her şey → empty() FALSE döner (dolu)

$bos_string  = "";
$sifir_int   = 0;
$sifir_str   = "0";   
$null_deger  = null;
$false_deger = false;
$bos_dizi    = [];
$dolu_string = "Mazlum";
$sifir_degil = 42;

var_dump(empty($bos_string));   // bool(true)  ← Boş string
var_dump(empty($sifir_int));    // bool(true)  ← 0 boş sayılır
var_dump(empty($sifir_str));    // bool(true)  ← "0" bile boş!
var_dump(empty($null_deger));   // bool(true)  ← null boş
var_dump(empty($false_deger));  // bool(true)  ← false boş
var_dump(empty($bos_dizi));     // bool(true)  ← [] boş
var_dump(empty($dolu_string));  // bool(false) ← Dolu 
var_dump(empty($sifir_degil));  // bool(false) ← 42 dolu 



// Kural: isset() "Var mı?" sorar. empty() "Boş mu?" sorar.
// İkisi birlikte "Var mı ve işe yarar mı?" sorusunu cevaplar.


// ============================================================
// BÖLÜM 4: Gerçek Dünya Senaryosu — Form Verisi Kontrolü
// ============================================================
//
// Java'da şunu yapardık (Spring MVC):
//   String username = request.getParameter("username");
//   if (username != null && !username.isEmpty()) { ... }
//
// PHP'de $_POST bir dizidir (Map gibi).
// Kullanıcı formu gönderirken bir alanı silerse ya da boş
// bırakırsa o anahtar dizide YA YOKTUR ya da boş string'tir.
// Kontrol etmeden erişirsen → "Undefined array key" Warning!

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- ADIM 1: isset() → "Bu key $_POST'ta var mı?" ---
    //
    // Java karşılığı: request.getParameter("username") != null
    //
    // Kullanıcı formu gönderdi mi ve 'username' alanı geldi mi?
    if (isset($_POST["username"])) {

        $username = $_POST["username"];

        // --- ADIM 2: empty() → "Gelen değer işe yarar mı?" ---
        //
        // Java karşılığı: !username.trim().isEmpty()
        //
        // Kullanıcı alanı boş bırakmış olabilir. isset() bunu
        // yakalamaz, çünkü "" (boş string) hâlâ "var" sayılır!
        if (!empty($username)) {

            // htmlspecialchars → XSS saldırısına karşı Java'daki
            // StringEscapeUtils.escapeHtml() veya Thymeleaf'in
            // otomatik escape'ine karşılık gelir.
            echo "Hoş geldin, " . htmlspecialchars($username) . "!<br>";

        } else {
            echo "Hata: Kullanıcı adı boş bırakılamaz.<br>";
        }

    } else {
        // Bu dalın çalışması: Form düzgün iletilmedi ya da birisi
        // 'username' alanını POST'tan sildi (manipülasyon senaryosu).
        echo "Hata: Form düzgün gönderilmedi.<br>";
    }


    // --- NEDEN İKİSİNİ BİRDEN KULLANIYORUZ? ---
    //
    // Soru: "isset() kontrolü yeterli değil mi?"
    //
    // Cevap: Hayır. Kullanıcı input'u boş bırakıp gönderirse,
    // $_POST['username'] = "" olur. isset() → TRUE döner (key var),
    // ama içerik işe yaramaz. empty() bu boşluğu yakalar.
    //
    // isset() = Güvenlik duvarının 1. katmanı: "Key var mı?"
    // empty() = Güvenlik duvarının 2. katmanı: "Değer kullanılabilir mi?"
}


// ============================================================
// ÖZET
// ============================================================
//
//  PHP'de değişken/dizi erişimi her zaman potansiyel tehlikedir.
//
//  1. isset()  → "Var mı ve null değil mi?" — İlk savunma hattı
//  2. empty()  → "Boş mu?"                 — İkinci savunma hattı
//  3. ??       → "Varsa al, yoksa default"  — Modern kısa yol
//
//  Java'da compiler bizi erken uyarır.
//  PHP'de bu sorumluluğu biz üstleniriz.
//  isset() + empty() bu sorumluluğun profesyonel karşılığıdır.
?>

<!DOCTYPE html>
<html lang="tr">
<body>
    <h3>Kayıt Formu (Test)</h3>
    <form method="post" action="">
        Kullanıcı Adı: <input type="text" name="username" placeholder="Adınızı girin">
        <button type="submit">Kayıt Ol</button>
    </form>
</body>
</html>