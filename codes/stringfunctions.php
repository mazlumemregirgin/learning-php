<?php
/**
 
 * Java'da String bir NESNE (object)'tir. String işlemleri için
 * nesne metodları çağırırsın: str.length(), str.toUpperCase()
 *
 * PHP'de String bir PRIMITIVE (ilkel) tiptir. String işlemleri
 * için GLOBAL FONKSİYONLAR kullanırsın: strlen($str), strtoupper($str)
 *
 * Java  → "Merhaba".toUpperCase()    (nesne metodu)
 * PHP   → strtoupper("Merhaba")      (global fonksiyon, string içeri girer)
 */


$metin = "  Merhaba, PHP Dünyası!  ";






$word1 = "Merhaba";

// strlen() → String'in karakter sayısını verir
echo strlen($word1);    // 7   ASCII için doğru
echo strlen("Şeker");        // 6   5 karakter ama 6 byte!

//strlen() BYTE sayar, karakter değil!
// Türkçe karakterler ş,ğ,ü gibi UTF-8'de 2 byte yer kaplar.
// Bu yüzden Türkçe metinlerde mb_strlen() kullanılmalı.  mb -> multibyte
echo mb_strlen("Şeker");     // 5  mb_ = multibyte = Unicode farkında



// strtoupper() → Tümünü büyük harf yapar
echo strtoupper("merhaba");     // MERHABA

// strtolower() → Tümünü küçük harf yapar
echo strtolower("MERHABA");     // merhaba

// ucfirst() → Sadece ilk harfi büyük yapar // yani bu fonksiyonu da bilmeyiver use casei kim bilir nerede karşıma çıkacak??
echo ucfirst("merhaba dünya");  // Merhaba dünya

// ucwords() → Her kelimenin ilk harfini büyük yapar
echo ucwords("merhaba php dünyası");  // Merhaba Php Dünyası

// Türkçe karakterler için mb_ versiyonları:
echo mb_strtoupper("şeker", "UTF-8");  // ŞEKER 
echo mb_strtolower("ŞEKER", "UTF-8");  // şeker 



// trim() → Her iki taraftaki boşlukları temizler
$kirli = "  Merhaba  ";
echo trim($kirli);   // "Merhaba"  (baş ve sondaki boşluk gitti)

// ltrim() → Sadece SOL (baş) taraftaki boşlukları temizler
echo ltrim($kirli);  // "Merhaba  "

// rtrim() → Sadece SAĞ (son) taraftaki boşlukları temizler
echo rtrim($kirli);  // "  Merhaba"

// trim() sadece boşluk değil, belirli karakterleri de temizler:
$url = "///site.com///";
echo trim($url, "/");  // "site.com"  (slash karakterlerini temizledi)




$cumle = "PHP öğrenmek çok eğlenceli ve PHP güçlüdür.";

// strpos() → İlk eşleşmenin POZİSYONUNU döner
// Java karşılığı: str.indexOf("kelime")
//
// KRİTİK UYARI: strpos() bulamazsa FALSE döner, -1 değil!
// Java'da indexOf() bulamazsa -1 döner.
// PHP'de FALSE döner 

$pozisyon = strpos($cumle, "PHP");
echo $pozisyon;  // 0  (ilk karakter, 0-indexed — Java gibi)

// YANLIŞ kontrol (klasik PHP hatası):
if (strpos($cumle, "PHP") == false) {
    // Bu dal YANLIŞ çalışır! Çünkü pozisyon 0 == false TRUE yapar!
    // 0 == false → true  ← PHP'nin loose comparison tuzağı!
}

// DOĞRU kontrol: === (strict comparison) kullan
if (strpos($cumle, "PHP") === false) {
    echo "Bulunamadı";
} else {
    echo "Bulundu, pozisyon: " . strpos($cumle, "PHP");  // 0
}


// str_contains() → String içeriyor mu?
if (str_contains($cumle, "eğlenceli")) {
    echo "Evet, 'eğlenceli' geçiyor!<br>";
}

// str_starts_with() → 
// Java karşılığı: str.startsWith("PHP")
if (str_starts_with($cumle, "PHP")) {
    echo "Cümle PHP ile başlıyor!<br>";
}

// str_ends_with() → 
// Java karşılığı: str.endsWith("dür.")
if (str_ends_with($cumle, "güçlüdür.")) {
    echo "Cümle 'güçlüdür.' ile bitiyor!<br>";
}





$metin = "Merhaba PHP!";

// substr() → Belirli pozisyondan itibaren parça alır
// Java karşılığı: str.substring(başlangıç, bitiş)
//
// PHP: substr($str, başlangıç, UZUNLUK)   ← 3. parametre uzunluk!
// Java: str.substring(başlangıç, BİTİŞ)  ← 2. parametre bitiş indeksi!
// Bu fark çok yaygın bir karışıklık kaynağıdır!

echo substr($metin, 0, 7);   // "Merhaba"  (0'dan itibaren 7 karakter)
echo substr($metin, 8);      // "PHP!"     (8'den sona kadar)
echo substr($metin, -4);     // "PHP!"     (sondan 4 karakter, eksi = sondan)
echo substr($metin, -4, 3);  // "PHP"      (sondan 4. karakterden 3 karakter)

// Java'dan fark özeti:
// Java:  "Merhaba PHP!".substring(0, 7)  → "Merhaba"  (bitiş: 7. INDEX)
// PHP:   substr("Merhaba PHP!", 0, 7)    → "Merhaba"  (uzunluk: 7 KARAKTER)





// str_replace() → Tüm eşleşmeleri değiştirir
// Java karşılığı: str.replace("eski", "yeni")
$yeni = str_replace("PHP", "Python", "PHP öğren, PHP sev!");
echo $yeni;  // "Python öğren, Python sev!"  

// Büyük/küçük harf duyarsız replace:
$yeni = str_ireplace("php", "Python", "PHP öğren, php güçlü!");
echo $yeni;  // "Python öğren, Python güçlü!"

// Çoklu değiştirme: Dizi ile birden fazla kelimeyi değiştir
$yeni = str_replace(
    ["PHP", "Python", "Java"],     // Aranacaklar
    ["Rust", "Go",    "Kotlin"],   // Karşılıklar
    "PHP, Python ve Java popüler"
);
echo $yeni;  // "Rust, Go ve Kotlin popüler"




// explode() → String'i böler, dizi döner
$meyveler = "elma,armut,kiraz,üzüm";
$dizi = explode(",", $meyveler);
// ["elma", "armut", "kiraz", "üzüm"]

// 3. parametre: maksimum parça sayısı
$iki_parca = explode(",", $meyveler, 2);
// ["elma", "armut,kiraz,üzüm"]  ← Sadece 2 parçaya böldü

// implode() → Diziyi birleştirir, string döner
// Java karşılığı: String.join(",", liste)  veya  stream().collect(joining(","))
$birlesik = implode(" | ", $dizi);
echo $birlesik;  // "elma | armut | kiraz | üzüm"

// join() = implode()'un takma adı (alias), aynı şey
echo join(", ", $dizi);  // "elma, armut, kiraz, üzüm"

// preg_split() → Regex ile bölme
// Java karşılığı: str.split("\\s+")
$kelimeler = preg_split("/\s+/", "Merhaba   PHP   Dünyası");
// ["Merhaba", "PHP", "Dünyası"]  (birden fazla boşluk da işledi)




// BÖLÜM 10: GÜVENLIK FONKSİYONLARI
//
// Web geliştirmede string güvenliği KRİTİKTİR.
// Java Spring'de Thymeleaf otomatik escape eder.
// PHP'de bu sorumluluğu sen alırsın!

// htmlspecialchars() → XSS saldırısına karşı HTML karakterlerini kaçırır
// Java karşılığı: StringEscapeUtils.escapeHtml4()  (Apache Commons)
//                 veya Thymeleaf'in th:text="..." özelliği
$kullanici_girdisi = "<script>alert('XSS!');</script>";
echo htmlspecialchars($kullanici_girdisi, ENT_QUOTES, "UTF-8");
// "&lt;script&gt;alert(&#039;XSS!&#039;);&lt;/script&gt;"
// Tarayıcıda script çalışmaz, metin olarak görünür. 

// htmlspecialchars_decode() → Tersi işlem
echo htmlspecialchars_decode("&lt;b&gt;Kalın&lt;/b&gt;");
// "<b>Kalın</b>"

// strip_tags() → HTML taglerini tamamen siler
// Java karşılığı: Jsoup.parse(html).text()
echo strip_tags("<b>Merhaba</b> <i>PHP</i>!");  // "Merhaba PHP!"

// Belirli taglere izin ver:
echo strip_tags("<b>Merhaba</b> <script>hack()</script>!", "<b>");
// "<b>Merhaba</b> hack()"  (sadece <b> tag'i korundu)

// addslashes() → SQL injection'a karşı tırnak karakterlerini kaçırır
echo addslashes("O'Brien dedi ki: \"Merhaba\"");
// "O\'Brien dedi ki: \"Merhaba\""


// strcmp() → İki string'i karşılaştırır (büyük/küçük harf duyarlı)
// Java karşılığı: str1.compareTo(str2)
//   0 döner  → Eşit
//  <0 döner  → İlk string küçük
//  >0 döner  → İlk string büyük
echo strcmp("elma", "elma");    //  0  (eşit)
echo strcmp("armut", "elma");   // <0  (armut < elma alfabetik)
echo strcmp("üzüm", "elma");    // >0  (üzüm > elma alfabetik)



// ============================================================
// BÖLÜM 12: PRATİK SENARYO — Form Verisi İşleme
// ============================================================
//
// Java Spring'de @RequestParam ile alıp, servis katmanında
// işlediğin verinin PHP karşılığı:

function kullanici_adi_dogrula(string $input): array {
    // 1. Baş/son boşlukları temizle (trim)
    $temiz = trim($input);

    // 2. Uzunluk kontrolü (mb_ ile Unicode güvenli)
    if (mb_strlen($temiz) < 3) {
        return ["gecerli" => false, "hata" => "En az 3 karakter olmalı"];
    }
    if (mb_strlen($temiz) > 20) {
        return ["gecerli" => false, "hata" => "En fazla 20 karakter olabilir"];
    }

    // 3. Sadece harf, rakam ve alt çizgiye izin ver (regex)
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $temiz)) {
        return ["gecerli" => false, "hata" => "Sadece harf, rakam ve _ kullanılabilir"];
    }

    // 4. Küçük harfe çevir (standart format)
    $final = strtolower($temiz);

    return ["gecerli" => true, "deger" => $final];
}

$test_girdileri = ["  Mazlum_42  ", "ab", "çok uzun bir kullanıcı adı deneme", "Admin!"];

foreach ($test_girdileri as $girdi) {
    $sonuc = kullanici_adi_dogrula($girdi);
    if ($sonuc["gecerli"]) {
        echo "✅ Geçerli: " . $sonuc["deger"] . "<br>";
    } else {
        echo "❌ Hata ({$girdi}): " . $sonuc["hata"] . "<br>";
    }
}


// ============================================================
// ÖZET — Java vs PHP String Karşılaştırma Tablosu
// ============================================================
//
//  İşlem              | Java                        | PHP
//  -------------------|-----------------------------|--------------------------
//  Uzunluk            | str.length()                | strlen() / mb_strlen()
//  Büyük harf         | str.toUpperCase()           | strtoupper() / mb_strtoupper()
//  Küçük harf         | str.toLowerCase()           | strtolower() / mb_strtolower()
//  Boşluk temizle     | str.trim()                  | trim()
//  İlk bulunan index  | str.indexOf("x")            | strpos() — FALSE döner, -1 değil!
//  İçeriyor mu?       | str.contains("x")           | str_contains()  (PHP 8+)
//  Başlıyor mu?       | str.startsWith("x")         | str_starts_with()  (PHP 8+)
//  Bitiyor mu?        | str.endsWith("x")           | str_ends_with()  (PHP 8+)
//  Parça al           | str.substring(baş, BİTİŞ)  | substr($s, baş, UZUNLUK) ← fark!
//  Değiştir           | str.replace("a","b")        | str_replace("a","b",$s)
//  Böl                | str.split(",")              | explode(",", $s)
//  Birleştir          | String.join(",", liste)     | implode(",", $dizi)
//  Formatla           | String.format(...)          | sprintf(...)
//  XSS koruma         | Thymeleaf otomatik          | htmlspecialchars() — MANUEL!
//  Karşılaştır        | str.compareTo()             | strcmp()
//  Eşit mi?           | str.equals()                | $a === $b  (operatör ile)
//
//  ALTIN KURAL: Türkçe/Unicode metin varsa HEP mb_ versiyonunu kullan!
//  strlen → mb_strlen | strtoupper → mb_strtoupper | substr → mb_substr
?>