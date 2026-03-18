<?php
/**
 * PHP ASSOCIATIVE ARRAYS (İlişkisel Diziler)
 * * Java'daki karşılığı: HashMap<String, String> veya Map<String, Object>
 * Farkı: Java'da Map için ayrı bir kütüphane ve karmaşık bir yapı gerekirken, 
 * PHP'de diziler doğal olarak birer Map gibi davranır. Ekstra bir sınıf gerekmez.
 */

// 1. TANIMLAMA (Modern [] sözdizimi ile)
// => operatörü atama anlamına gelir.
$student = [
    "name" => "Mazlum Emre",
    "surname" => "Girgin",
    "university" => "MSKU",
    "gpa" => 3.32,
    "is_graduated" => false
];

// 2. ERİŞİM
// Java'daki map.get("name") yerine direkt köşeli parantez kullanıyoruz.
echo "Öğrenci Adı: " . $student["name"] . "<br>";

// 3. YENİ ELEMAN EKLEME VEYA GÜNCELLEME
// Java'daki map.put("city", "Nazilli") karşılığı:
$student["city"] = "Nazilli"; // Yeni anahtar ekledik
$student["gpa"] = 3.40;      // Mevcut anahtarı güncelledik

// 4. FOREACH İLE TARAMA (En Önemli Kısım!)
// Java'da entrySet() üzerinden dönmek yerine direkt hem key hem value alabiliyoruz.
echo "<h3>Öğrenci Bilgileri:</h3>";
foreach ($student as $key => $value) {
    // Boolean değerleri ekranda görmek için ufak bir kontrol (true=1, false=boş döner çünkü)
    $displayValue = is_bool($value) ? ($value ? 'Evet' : 'Hayır') : $value;
    echo "<strong>$key:</strong> $displayValue <br>";
}

// ---------------------------------------------------------
// TEMEL ASSOC ARRAY FONKSİYONLARI (Alet Çantası)
// ---------------------------------------------------------

// A. array_keys(): Sadece anahtarları bir dizi olarak döner (Java: keySet())
$keys = array_keys($student);

// B. array_values(): Sadece değerleri bir dizi olarak döner (Java: values())
$values = array_values($student);

// C. array_flip(): Anahtarlar ile değerlerin yerini değiştirir (Value -> Key, Key -> Value)
$flipped = array_flip(["A" => 1, "B" => 2]); // [1 => "A", 2 => "B"] olur.

// D. array_merge(): İki diziyi birleştirir (Java: map.putAll())
$extra_info = ["department" => "Software Engineering", "year" => 3];
$full_profile = array_merge($student, $extra_info);

// E. count(): Eleman sayısını verir
echo "<br>Toplam Bilgi Sayısı: " . count($full_profile);

// F. ksort() ve asort(): 
// ksort: Anahtara göre (A-Z) sıralar.
// asort: Değere göre (A-Z) sıralar.
ksort($full_profile); 

// G. array_key_exists(): Belirli bir key var mı? (Java: containsKey())
if (array_key_exists("city", $student)) {
    echo "<br>Şehir bilgisi mevcut.";
}

// 5. DEBUGGING (Hata Ayıklama)
// Java'daki toString() veya JSON çıktısı gibi tüm yapıyı görmek için:
echo "<pre>";
print_r($full_profile); // Okunabilir döküm
// var_dump($full_profile); // Çok detaylı (tip bilgili) döküm
echo "</pre>";

?>