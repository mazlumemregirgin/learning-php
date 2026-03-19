<?php
declare(strict_types=1);
//dümdüz oop hiçbir ekstra yanı yok esprisi yok. baya java bu.


// Interface (Arayüz) - Java ile birebir aynı mantık
interface Chargeable {
    public function charge(): string;
}
/*
    javadaki gibi public, private ve protected keywordleri aynı şekilde var. birebir aynı oop.
    private string $password; -> sadece bu sınıf
    protected string $email; -> bu sınıf ve miras alanlar
    public string $name; -> her yerden erişilebilir.

    eğer bir değişkenin başında hiçbirşey yazmazsak, varsayılan olarak public kabul edilir.
*/



// Parent Class (Ata Sınıf)
class ElectronicDevice { // javadaki gibi public class, private class diyemiyoruz. sadece class yazılır.
    protected string $brand; // Sadece bu sınıf ve miras alanlar erişebilir

    public function __construct(string $brand) { // phpde constructo ismi sabittir. __constructor(). javadaki gibi sınıf ismiyle aynı olamaz.
        $this->brand = $brand;
    }
}

// Main Class (Smartphone) - Kalıtım ve Interface uygulaması
class Smartphone extends ElectronicDevice implements Chargeable {
    
    // 1. Properties (Özellikler / Fields)
    private string $model;
    private int $batteryLevel;
    
    // 2. Static Property (Sınıfa ait, nesneye değil)
    public static int $totalPhonesCreated = 0;

    // 3. Constructor (Yapıcı Metot) 
    // Java'daki Smartphone() yerine __construct() kullanılır.
    public function __construct(string $brand, string $model, int $batteryLevel = 100) {
        // üst sınıfın bir methodunu çağırmak yerine java gibi super() yazmak yerine parent::__constructor() kullanılır.
        parent::__construct($brand); 
        
        $this->model = $model;
        $this->batteryLevel = $batteryLevel;
        
        // Static değişkene erişim (Java: Smartphone.totalPhonesCreated++)
        self::$totalPhonesCreated++;
    }

    // 4. Methods (Metotlar)
    public function getInfo(): string {
        // Nesne özelliklerine erişirken $this-> kullanılır.
        return "Brand: {$this->brand}, Model: {$this->model}, Battery: {$this->batteryLevel}%";
    }

    // Interface'den gelen metodu zorunlu olarak dolduruyoruz
    public function charge(): string {
        $this->batteryLevel = 100;
        return "Phone is fully charged!";
    }

    // 5. Getter ve Setter (Encapsulation)
    /*
    Phpde javadaki gibi private değişkenlere erişmek için method yazmamız gerekiyor.
    isimlendirme olarak phpde built-in bir getter/setter zorunluluğu yok. ben mesela getter işlevi yapan bir fonksiyon yazıp ismini mazlum() koyabilirim.

    */
    public function setModel(string $model): void {
        $this->model = $model;
    }

    public function getModel(): string {
        return $this->model;
    }

    // 6. Destructor (Yıkıcı Metot) - Java'da Garbage Collector olduğu için pek kullanılmaz 
    // ama PHP'de nesne bellekten silinirken otomatik çalışır.
    public function __destruct() {
        // echo "Nesne bellekten siliniyor...";
    }
}

// --- KULLANIM ---
// aynı şekilde javadaki gibi new keywordü ile obje üretilir.
$myPhone = new Smartphone("Apple", "iPhone 15", 85);

//methodlara erişim için . yerine -> kullanılır.
echo $myPhone->getInfo() . "<br>";
echo $myPhone->charge() . "<br>";

// Static özelliğe erişim
echo "Total phones created: " . Smartphone::$totalPhonesCreated;