# PHP OOP Notlarım 

> Bu notlar Java bilen biri olarak PHP öğrenirken kafama takılan şeyleri kendi dilimle yazdığım kişisel notlardır. Çok resmi değil, sade tutmaya çalıştım.

---

## 1. Erişim Belirleyiciler (public / private / protected)

Java'daki mantığın tamamen aynısı. Tek fark şu: **sınıf tanımlarken** `public class` veya `private class` diyemiyorsun. PHP'de sınıf her zaman sadece `class` ile tanımlanır.

Ama **property ve method tanımlarken** bunları kullanıyorsun, bu kısım Java ile birebir:

```php
class User {
    private string $password;   // sadece bu sınıf görebilir
    protected string $email;    // bu sınıf + miras alanlar görebilir
    public string $name;        // herkes görebilir
}
```

> ⚠️ Eğer hiçbir şey yazmazsan eski PHP'de varsayılan `public` kabul edilir ama **bu kötü bir alışkanlık**. Her zaman açıkça yaz.

---

## 2. Constructor Farkı

Java'da constructor sınıf ismiyle aynı oluyordu:

```java
// Java
class Smartphone {
    Smartphone(String brand) { ... }
}
```

PHP'de constructor ismi **her zaman sabit**: `__construct()`

```php
// PHP
class Smartphone {
    public function __construct(string $brand) { ... }
}
```

### Üst Sınıfı Çağırmak

Java'da `super()` diyordun. PHP'de `parent::__construct()` yazıyorsun:

```php
class Smartphone extends ElectronicDevice {
    public function __construct(string $brand, string $model) {
        parent::__construct($brand); // Java'daki super() gibi
        $this->model = $model;
    }
}
```

> Java'da `super()` **kesinlikle ilk satırda** olmak zorundaydı. PHP'de teknik olarak zorunlu değil ama mantık gereği yine de ilk satıra yaz, yoksa ata sınıf property'leri initialize olmadan kullanmaya çalışırsın, hata alırsın.

---

## 3. `->` Operatörü (Nokta değil, Ok)

Java'da `obj.method()` veya `obj.property` diyordun. PHP'de bunun yerine `->` kullanıyorsun:

```php
$myPhone = new Smartphone("Apple", "iPhone 15");
echo $myPhone->getInfo();  // Java: myPhone.getInfo()
$myPhone->charge();
```

Property'lere erişirken de aynı şey:

```php
echo $myPhone->model; // public ise
```

---

## 4. `$this` Zorunluluğu

Bu en çok hata yapılan yerlerden biri. Java'da bazen `this` yazmadan sınıf içindeki değişkene erişebiliyordun. PHP'de **her zaman `$this->` yazmak zorundasın**:

```php
class Smartphone {
    private string $model;

    public function getModel(): string {
        return $this->model;  // $this-> olmadan PHP bunu yerel değişken sanır!
    }
}
```

---

## 5. `self` vs `$this` Farkı

- **`$this`** → o anki nesneye (instance'a) işaret eder
- **`self`** → sınıfın kendisine işaret eder, statik şeyler için kullanılır

```php
class Smartphone {
    public static int $totalPhonesCreated = 0;

    public function __construct() {
        self::$totalPhonesCreated++;  // static property için self::
    }
}

// Dışarıdan erişim:
echo Smartphone::$totalPhonesCreated; // Java: Smartphone.totalPhonesCreated
```

---

## 6. Interface ve Kalıtım

Bunlar Java ile **tamamen aynı**. `implements` ve `extends` keyword'leri birebir aynı çalışıyor:

```php
interface Chargeable {
    public function charge(): string;
}

class ElectronicDevice {
    protected string $brand;
    public function __construct(string $brand) {
        $this->brand = $brand;
    }
}

// Hem kalıtım hem interface - Java ile aynı mantık
class Smartphone extends ElectronicDevice implements Chargeable {
    public function charge(): string {
        return "Şarj oldu!";
    }
}
```

---

## 7. Getter / Setter Mantığı

PHP'de Java gibi `private` değişkenlere dışarıdan erişmek için getter/setter yazıyorsun. **Ama PHP'de isimlendirme zorunluluğu yok.** `getModel()` da yazabilirsin, `modelGetir()` de, hatta `mazlum()` da. Tamamen sana kalmış.

```php
public function setModel(string $model): void {
    $this->model = $model;
}

public function getModel(): string {
    return $this->model;
}
```

> Sektörde `getXxx()` / `setXxx()` isimlendirmesine uymak okunabilirlik açısından iyi bir alışkanlık.

---

## 8. Destructor (`__destruct`)

Java'da Garbage Collector olduğu için pek uğraşmazdın. PHP'de nesne bellekten silinirken `__destruct()` otomatik çalışır. Genelde bağlantı kapatmak gibi temizlik işleri için kullanılır:

```php
public function __destruct() {
    // veritabanı bağlantısını kapat vs.
}
```

---

## 9. Özet Karşılaştırma Tablosu

| Özellik | Java | PHP |
|---|---|---|
| Üyelere erişim | `obj.method()` | `$obj->method()` |
| Constructor | `ClassName()` | `__construct()` |
| Ata sınıf çağrısı | `super.method()` | `parent::method()` |
| Sınıf içi erişim | `this.property` | `$this->property` |
| Static erişim | `ClassName.property` | `ClassName::$property` veya `self::$property` |
| Interface | `implements` | `implements` (aynı) |
| Kalıtım | `extends` | `extends` (aynı) |

---

## 10. Dosyalar Arası Haberleşme (Önemli!)

Java'da `import` yapıyordun ve JVM her şeyi biliyordu. PHP'de ise her şey **dosya bazlı** çalışıyor. Yani bir PHP dosyasında yazdığın sınıfı başka bir dosyada kullanmak istiyorsan, o dosyayı "tanıtman" gerekiyor.

### Eski yöntem:
```php
require 'User.php'; // dosyayı elle dahil et
```

### Modern yöntem (Composer + PSR-4):
Sektörde **Composer** adında bir paket yöneticisi kullanılıyor. Bir kez kuruyorsun, sonra sadece şunu yazıyorsun:

```php
require_once '../vendor/autoload.php'; // tek satır, gerisini Composer hallediyor
```

Composer senin için hangi sınıf hangi dosyada diye bakıyor ve otomatik yüklüyor. Java'daki `import` mekanizmasına en yakın şey bu.

---

## 11. Gerçek Bir Proje Nasıl Görünür?


```
my-app/
├── src/                  ← Tüm PHP sınıfların (iş mantığı) burada
│   ├── Models/           ← Veri yapıları (User.php, Product.php)
│   ├── Controllers/      ← HTTP isteklerini karşılayanlar
│   └── Services/         ← Ağır iş mantığı (OrderService.php vs.)
├── public/               ← Dış dünyaya açık TEK klasör (web sunucusu buraya bakıyor)
│   └── index.php         ← "Entry Point" - uygulama buradan başlıyor
├── vendor/               ← Composer'ın yüklediği kütüphaneler (git'e ekleme!)
└── composer.json         ← Proje ayarları ve autoload kuralları
```

### Bu yapıda OOP nasıl kullanılıyor?

#### `src/Models/User.php`

```php
<?php
namespace App\Models; // Java'daki "package com.myapp.models" gibi

class User {
    private string $name;
    private string $email;

    public function __construct(string $name, string $email) {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }
}
```

#### `src/Services/UserService.php`

```php
<?php
namespace App\Services;

use App\Models\User; // Java'daki import gibi

class UserService {
    // Veritabanından kullanıcı çekip User nesnesi döndürüyor
    public function findUser(int $id): User {
        // normalde burada DB sorgusu olurdu
        return new User("Mazlum", "mazlum@ornek.com");
    }

    public function greetUser(User $user): string {
        return "Merhaba, " . $user->getName() . "!";
    }
}
```

#### `src/Controllers/UserController.php`

```php
<?php
namespace App\Controllers;

use App\Services\UserService; // sadece ihtiyacın olanı import ediyorsun

class UserController {
    private UserService $userService;

    // Dependency Injection - iş mantığını dışarıdan alıyoruz
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function show(int $userId): void {
        $user = $this->userService->findUser($userId);
        echo $this->userService->greetUser($user);
    }
}
```

#### `public/index.php` (Her şeyin başladığı yer)

```php
<?php
require_once '../vendor/autoload.php'; // Composer her şeyi buluyor

use App\Controllers\UserController;
use App\Services\UserService;

// Bağımlılıkları oluştur ve birleştir
$userService = new UserService();
$controller = new UserController($userService);

// İsteği işle
$controller->show(1);
```

### Bu yapının mantığı nedir?

- **`Models/`**: Sadece veriyi taşır. Veritabanı tablosundaki bir satırın PHP karşılığı gibi düşün.
- **`Services/`**: Asıl iş mantığı burada. "Kullanıcıyı bul", "Siparişi hesapla" gibi şeyler.
- **`Controllers/`**: HTTP isteği gelir, doğru Service'i çağırır, sonucu döner. Kendisi iş mantığı yapmaz.
- **`public/index.php`**: Tek giriş noktası. Web sunucusu (Nginx, Apache) her isteği buraya yönlendirir.

> Bu ayrım aslında **Separation of Concerns** prensibi. Her sınıfın tek bir sorumluluğu var. SOLID'in "S"si yani Single Responsibility Principle. Java'dan geldiğin için zaten biliyorsun bu kavramları, PHP'de de aynı şekilde uygulanıyor.

---

## 12. Composer Kurulum (Hızlı Başlangıç)

```bash
# Projeyi başlat
composer init

# composer.json içine autoload ekle:
# "autoload": {
#     "psr-4": {
#         "App\\": "src/"
#     }
# }

# Autoload dosyalarını oluştur
composer dump-autoload
```

Bundan sonra `src/` altındaki her sınıf `App\` namespace'i ile otomatik bulunuyor. Tıpkı Java'da `com.myapp` package yapısı gibi.

---

## Genel Özet

PHP'ye geçişte Java'dan gelen biri olarak şunlara dikkat et:

1. **`->`** operatörüne alış, Java'daki nokta yerine bu var
2. **`__construct()`** ismi sabit, sınıf ismiyle aynı yapamıyorsun
3. **`$this->`** her zaman zorunlu, unutursan yerel değişken sanıyor
4. **`parent::`** ata sınıf için, **`self::`** static şeyler için
5. **Composer** kullan, dosyaları tek tek `require` etme
6. **Namespace** kullan (`namespace App\Models;`), yoksa büyük projelerde isim çakışması olur

