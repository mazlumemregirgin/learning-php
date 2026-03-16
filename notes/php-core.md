# PHP Notları

## 1. PHP Nedir ve Tarihçesi
PHP, 1994 yılında Rasmus Lerdorf tarafından aslında sadece kendi web sayfasındaki ziyaretçileri takip etmek için basit bir C script seti olarak yazıldı (Personal Home Page). Zamanla evrilerek PHP: Hypertext Preprocessor (özyinelemeli bir kısaltma) adını aldı.

* Java/Go ile Farkı: Java ve Go "general-purpose" (genel amaçlı) dillerdir. PHP ise web için doğmuş bir dildir. Standart kütüphanesi doğrudan HTTP taleplerini, çerezleri (cookies) ve HTML çıktılarını yönetmek üzerine kuruludur.

## 2. PHP'nin Yapısı ve Nasıl Çalışır?
PHP, interpreted (yorumlanan) bir dildir. Ancak modern PHP (versiyon 7 ve 8+), performansı artırmak için Zend Engine üzerinde çalışır ve kodları çalıştırmadan önce OpCode adı verilen bir ara koda dönüştürür.

Çalışma Döngüsü (Life Cycle)  
Java'da bir uygulama ayağa kalkar ve sürekli bellekte yaşar (Long-running process). Go'da da benzer şekilde bir binary dosya sürekli dinlemededir. PHP'de ise durum bambaşkadır:

1. İstek Gelir: Bir kullanıcı index.php sayfasına istek atar.  
2. Süreç Başlar: PHP yorumlayıcısı tetiklenir, kod baştan sona okunur, derlenir ve çalıştırılır.  
3. İş biter ve ÖLÜR: İstek yanıtlandığı anda PHP o süreçteki tüm belleği boşaltır ve kapanır.


## Share Nothing Mimarisi
Java ve Go'da uygulama bir "long-running process" (uzun süreli işlem) olarak çalışır. Yani sunucuyu bir kez başlatırsın, o sürekli RAM üzerinde bekler. Bir değişkeni static yaparsan, o değişken sunucu açık kaldığı sürece tüm kullanıcılardan gelen isteklerde aynı kalır.  
PHP'de ise durum tam tersidir: Her HTTP isteği, sanki taze bir bilgisayarın yeni açılması ve iş bitince kapanması gibidir. Bir istek geldiğinde PHP o isteğe özel bir alan oluşturur. İstek biter bitmez PHP o alanı "çöpe atar". Bir isteğin içinde tanımladığın bir değişkeni, bir sonraki istekte doğrudan kullanamazsın.  

Neden böyle?  
1. Güvenlik ve İzolasyon: Bir isteğin hata verip çökmesi, diğer kullanıcıları etkilemez (Java'daki bellek sızıntılarının sunucuyu çökertmesi PHP'de zordur).  
2. Ölçeklenebilirlik: Sunucuya yük binerse, PHP-FPM (FastCGI Process Manager) yeni bir process açar. Hiçbir durum (state) paylaşılmadığı için sistem kolayca çoğaltılabilir.

## OpCode ve JIT: PHP'nin JVM'i Mi?
Evet, aslında çok benziyorlar ama çalışma zamanları farklı.  

* Java Süreci: .java (Code) → .class (ByteCode) → JVM (Machine Code).  
* PHP Süreci: .php (Code) → OpCode (Ara Kod) → Zend Engine (Machine Code).  

OpCode Nedir? PHP kodu her seferinde satır satır okunup makine koduna dönüştürülseydi çok yavaş olurdu. Bu yüzden PHP, kodu bir kez tarayıp OpCode denilen bir ara forma sokar. Eskiden her istekte bu sıfırdan yapılırdı.  
OpCache: Artık modern PHP sunucularında OpCache (Operation Cache) var. PHP kodu ilk kez çalıştığında OpCode'u belleğe (RAM) yazar. İkinci istek geldiğinde kod dosyasına bakmaz, direkt RAM'deki OpCode'u çalıştırır.  
JIT (Just-In-Time): PHP 8 ile gelen bu özellik, Java'daki JIT'e çok benzer. Sık kullanılan OpCode'ları doğrudan makine koduna (Binary) çevirerek performansı inanılmaz artırır.

## Detaylı Life Cycle (Login Süreci Örneği)
PHP uygulaması Java/Go gibi bellekte "beklemez". Bir web sunucusu (Nginx/Apache) ve PHP-FPM vardır.  
Örnek: Kullanıcı Login Oluyor (/login isteği attı)  

1. Request Gelir: Nginx isteği yakalar ve "Hey PHP-FPM, sana bir iş var" der.  
2. Process Doğar (veya Uyandırılır): PHP-FPM, boşta bekleyen bir PHP işçisini (process) bu işe atar.  
3. Bootstrapping: PHP, index.php'yi okumaya başlar. Eğer Laravel kullanıyorsan; framework'ün tüm kütüphaneleri, konfigürasyonları ve veritabanı bağlantıları o saniye içinde sıfırdan yüklenir (OpCache sayesinde çok hızlıdır).  
4. Execute: Senin yazdığın login kodu çalışır:  
   * Veritabanına sorgu atar.  
   * Şifreyi doğrular.  
   * "Giriş Başarılı" yanıtını (JSON veya HTML) oluşturur.  
5. Clean-up & Death: Yanıt kullanıcıya gönderildiği an PHP bu işçi içindeki tüm nesneleri (User nesnesi, DB bağlantısı, değişkenler) yok eder. Bellek tamamen boşaltılır.

## Java vs PHP Process Karşılaştırması
Java: "Paylaşan Dev Bir Fabrika" (Multithreading)  
Java'da bir Spring Boot uygulamasını başlattığında tek bir Process (İşlem) başlar.  
* Bellek: Tüm uygulama aynı RAM alanını paylaşır.  
* İstek Geldiğinde: Java yeni bir "işlemci" (Process) oluşturmaz, sadece mevcut bellek içinde yeni bir Thread (Hafif İş parçacığı) açar.  
* Avantajı: Thread'ler arası veri paylaşımı (Static değişkenler, Cache) çok hızlıdır. Bellek verimlidir.  
* Dezavantajı: Bir Thread'de bellek sızıntısı (Memory Leak) olursa veya bir Thread tüm işlemciyi kilitlerse, tüm sunucu (tüm kullanıcılar) bundan etkilenir.  

PHP: "Bağımsız Tek Kişilik Odalar" (Multi-processing / PHP-FPM)  
PHP'de (genellikle PHP-FPM ile) sistem şöyle çalışır:  
* İstek Geldiğinde: Nginx isteği alır, PHP-FPM'e iletir. PHP-FPM, işletim sisteminden tamamen bağımsız bir Worker Process (İşçi Süreci) ayırır.  
* Sıfırdan Başlama: Bu "İşçi", senin index.php dosyanı en baştan okur, framework'ü yükler, veritabanına bağlanır ve işi bitirince kendini imha eder (veya temizlenir).  
* Avantajı: İzolasyon. Eğer bir kullanıcının isteği sonsuz döngüye girerse veya hata verip çökerse, sadece o Process ölür. Diğer 1000 kullanıcı bundan zerre etkilenmez. Bellek yönetimi "otomatiktir"; iş bitince her şey silindiği için bellek şişmesi yaşamazsın.  
* Dezavantajı: Her seferinde dünyayı yeniden kurmak (Bootstrapping) maliyetlidir. (OpCache bunu hızlandırsa da Java'daki "her şey hazır bekliyor" hızıyla yarışamaz).

Karşılaştırma Tablosu  

| Özellik              | Java (Multithreading)                  | PHP (Shared-Nothing / Process)                  |
|----------------------|----------------------------------------|-------------------------------------------------|
| Hafıza (RAM)         | Tek bir büyük havuz.                   | Her istek için izole küçük kutular.             |
| Veri Paylaşımı       | static değişkenlerle çok kolay.        | İmkansız. Mutlaka Redis/DB gerekir.             |
| Hata Toleransı       | Bir hata tüm uygulamayı çökertebilir.  | Hata sadece o isteği öldürür, gerisi sağlamdır. |
| Ölçekleme            | Dikey (RAM ekleyerek) ölçekleme daha yaygın. | Yatay (Yeni sunucu ekleyerek) ölçeklemeye çok uygun. |

## 3. Ne İşe Yarar?
PHP'nin ana uzmanlık alanı Server-Side Rendering (SSR) ve API geliştirmedir.  

* Form verilerini işleme, veritabanı yönetimi ve dinamik HTML içeriği üretmede çok hızlıdır.  
* Modern dünyada Laravel ve Symfony gibi frameworkler sayesinde enterprise (kurumsal) seviyede karmaşık backend sistemleri kurmak için kullanılır.

## 4. Sektördeki Kullanım Oranı ve Şirketler
"PHP ölüyor mu?" sorusu her yıl sorulur ama rakamlar farklı söyler. W3Techs verilerine göre web'in yaklaşık %75-76'sı hala PHP ile çalışıyor.  

* Neden bu kadar yüksek? WordPress, Magento ve Drupal gibi devasa ekosistemler PHP tabanlıdır.  
* Kimler Kullanıyor?  
  * Facebook: PHP ile başladı, sonra kendi PHP versiyonu olan HHVM'i geliştirdi.  
  * Wikipedia: Tamamen PHP.  
  * Slack: Backend kısmının büyük bir bölümü PHP (veya türevi Hack) ile yazılmıştır.  
  * E-ticaret: Türkiye'de ve dünyada birçok pazaryeri (Trendyol'un bazı servisleri, Getir, çeşitli ajanslar) PHP/Laravel kullanır.

## 5. Java/Go vs PHP: Hızlı Kıyaslama

| Özellik          | Java              | Go                    | PHP                                      |
|------------------|-------------------|-----------------------|------------------------------------------|
| Tip Güvenliği    | Statik (Strict)   | Statik (Strong)       | Dinamik (Modern PHP'de opsiyonel tip belirleme var) |
| Çalışma Şekli    | JVM (Thread tabanlı) | Compiled Binary (Goroutines) | interpreted (Process tabanlı / FPM)     |
| Hız              | Yüksek (JIT)      | Çok Yüksek            | Orta/Yüksek (PHP 8 JIT ile hızlandı)     |
| Öğrenme Eğrisi   | Orta/Zor          | Kolay/Orta            | Çok Kolay                                |

## Hangisi Daha İyi (Java/Php)?
Aslında "hangisi daha iyi" değil, "hangisi neye uygun" sorusu önemli:  

* Java/Go: Eğer sistemin saniyede binlerce isteği çok düşük gecikmeyle (low latency) karşılaması gerekiyorsa ve uygulama içinde yoğun bir "state" (durum) tutman gerekiyorsa (mesela bir oyun sunucusu veya borsa takip sistemi) Java/Go çok daha üstündür.  
* PHP: Eğer bir e-ticaret sitesi, içerik yönetim sistemi veya hızlıca geliştirilip kolayca ölçeklenmesi gereken bir web projesi yapıyorsan PHP rakipsizdir. "Hata yapsam bile tüm site çökmez" güveni, web geliştirme için büyük bir konfordur.

## Deploy ve Ölçekleme (Docker + Azure Örneği)
Uygulamayı yaptım, backend serverimi dockerize ettim, bunu Azure'de deploy ettim. Benim o backend serverim her zaman ayakta durmayacak; sadece kodumun içinde ilgili PHP kodu tetiklendiğinde o kod yorumlanıp ayağa kalkacak işlem. Bu sayede mesela yüksek kullanıcılı bir platformu sorunsuz şekilde ölçekleyebileceğim.  

Aslında tam olarak şöyle! Ancak burada küçük bir teknik ayrım var: "Ayakta duran" şey senin kodun değil, o kodu yorumlayacak olan PHP-FPM (Process Manager) servisidir.  

Java'da Spring Boot jar dosyasını çalıştırdığında uygulamanın kendisi bir "server" olur. PHP'de ise durum şöyledir:  

1. Sistem Nasıl Ayakta Kalır?  
   Sen projeni Dockerize edip Azure'a attığında, Docker container'ının içinde genellikle iki şey çalışır:  
   1. Nginx (Web Server): Kapıda bekleyen güvenlik görevlisi gibi 80/443 portunu dinler.  
   2. PHP-FPM: İçeride bekleyen, kodlarını çalıştırmaya hazır "işçiler" ordusu.  
   Senin kodun (binary değil, script dosyaları) diskte öylece durur. Bir istek gelene kadar RAM'de senin User nesnelerin, Controller sınıfların veya veritabanı bağlantıların asla yer kaplamaz.  

2. 35 Milyon Kullanıcıyı Nasıl Ölçeklersin? (Login Örneği)  
   Diyelim ki aynı anda 10.000 kişi login butonuna bastı:  
   1. Azure Load Balancer: İstekleri Docker container'larına dağıtır.  
   2. PHP-FPM: Gelen her istek için boşta bekleyen bir "Worker" (İşçi) ayırır.  
   3. Anlık Doğum: O işçi, login kodunu diskten (veya OpCache'ten) okur, çalıştırır, cevabı döner ve anında hafızayı boşaltır.  

   Neden bu ölçekleme için harikadır?  
   * Düşük RAM Tüketimi: Java'da uygulama boşta dururken bile JVM yüzünden ciddi RAM harcar. PHP'de ise istek yoksa RAM tüketimi minimumdur.  
   * Zombileşme Yok: Java'da bir thread kilitlenirse o thread'i temizlemek zordur. PHP'de ise max_execution_time (örn: 30 saniye) dolduğu an PHP-FPM o işçiyi zorla öldürür ve yeni bir işçi yaratır. Sistem kendi kendini temizler.  

3. Java/Go vs PHP Ölçekleme Farkı  
   * Java/Go: "Ben çok güçlüyüm, gelen binlerce isteği tek bir dev process içinde, kendi içimdeki thread'lerle çözerim." (Vertical & Intelligent)  
   * PHP: "Ben çok hafifim. 1000 istek mi geldi? Hemen 1000 tane küçük işçi oluşturur, işi bitince hepsini yok ederim." (Horizontal & Stateless)  

35 milyon kullanıcı örneğinde, Facebook hala PHP (HHVM) kullanıyor. Çünkü her isteğin izole olması, binlerce sunucuya yayılmayı (horizontal scaling) çok kolaylaştırıyor. "State" (durum) kodun içinde değil, Redis veya Database'de olduğu için sunucu sayısını 1'den 1000'e çıkarmak çocuk oyuncağıdır.  



## Neden PHP Seçiliyor? (Performans vs Gerçek Dünya Maliyetleri)
Okulda derslerde hep scalable yüksek trafiği olan şirketlerin Java veya Go kullanmaları gerektiğini düşünüyordum. PHP kullanan bir firmanın tech stack noktasında neden PHP seçtiğini anlamıyordum. Şuan biraz daha iyi anladım; izole ortamlar yaratması ve kodumuzun serverda sürekli çalışmıyor oluşu mantıklı.  

Okulda öğretilen "Java/Go daha performanslıdır" bilgisi teorik olarak (CPU ve RAM yönetimi açısından) doğrudur, ancak mühendislik sadece hız değil, aynı zamanda maliyet, sürdürülebilirlik ve operasyonel kolaylık yönetimidir.  

PHP seçen bir firmanın (özellikle backend odaklı biri için) neden bu yolu seçtiğini şu üç ana başlıkla "sektörel" bir bakış açısıyla özetleyelim:  

1. Hata İzolasyonu (Blast Radius)  
   Java veya Go'da yazdığın bir kodda "Memory Leak" (bellek sızıntısı) varsa, o sızıntı yavaş yavaş tüm JVM'i veya binary process'i şişirir. Sonunda tüm sunucu kilitlenir ve 35 milyon kullanıcının tamamı servis dışı kalır.  
   PHP'de ise bir kodun belleği şişirmesi sadece o anki o tek isteği etkiler. İstek biter, process ölür, bellek temizlenir. "Bir kişinin hatası, tüm gemiyi batırmaz." Bu, büyük ölçekli sistemlerde inanılmaz bir operasyonel konfordur.  

2. "Stateless" Olmanın Getirdiği Yatay Ölçekleme  
   Java'da bazen "Shared State" (ortak veri) kullanma tuzağına düşersin (bellekte tutulan session'lar, cache'ler vb.). Bu, uygulamayı birden fazla sunucuya dağıtırken (scaling out) başını ağrıtır.  
   PHP seni en baştan "Stateless" (durumsuz) olmaya zorlar. Çünkü kodun her şeyi unutarak başlar. Bu yüzden her şeyi mecburen Redis veya DB'ye yazarsın. Hal böyle olunca, Azure'da 1 sunucu yerine 1000 sunucu açtığında sistemin hiçbir ayar yapmadan tıkır tıkır çalışır.  

3. Geliştirme Hızı (Time-to-Market)  
   Go'da bir API yazarken her şeyi (structlar, error handling, pointerlar) en ince detayına kadar düşünmen gerekir. PHP ise web için tasarlandığı için:  
   * Veritabanına bağlanmak,  
   * JSON dönmek,  
   * Form doğrulamak (Validation),  
   * Dosya yüklemek...  
   ...gibi işler Java/Go'ya kıyasla çok daha az kodla yapılır. 35 milyon kullanıcısı olan bir şirket için "yeni bir özelliği 1 haftada mı yoksa 1 ayda mı çıkarıyoruz?" sorusu, CPU'nun %5 daha hızlı olmasından çok daha kritiktir.

## Kritik Sorular ve Cevaplar
1. PHP-FPM nedir ve neden kullanılır?  
   Soru: "Nginx doğrudan PHP dosyasını okuyamaz mı? Araya neden PHP-FPM giriyor?"  
   Cevap: Nginx bir web sunucusudur, statik dosyaları (HTML, CSS) çok iyi yönetir ama PHP kodunu anlamaz. PHP-FPM (FastCGI Process Manager) ise PHP'nin "işlem yöneticisidir". Nginx isteği alır, FastCGI protokolü ile PHP-FPM'e iletir. PHP-FPM, önceden oluşturulmuş (pre-forked) işçi süreçlerini (worker processes) yönetir.  
   Kritik Puan: "Java'daki Tomcat/Netty gibi düşünmeyin; PHP-FPM sadece bir process manager'dır. Uygulama kodunun yaşam döngüsünü o yönetir."  

2. Stateless Yapının Scaling'e Etkisi  
   Soru: "PHP uygulamalarını yatayda ölçeklemek neden Java'ya göre daha dertsizdir?"  
   Cevap: PHP doğası gereği stateless (durumsuz) bir dildir. Bir request bittiğinde her şey temizlendiği için uygulama içinde "local state" (bellekte tutulan session verisi gibi) barınamaz.  
   Kritik Puan: "Bu sayede 1 sunucu ile 100 sunucu arasında mimari bir fark kalmaz. Load Balancer arkasına dilediğimiz kadar node ekleyebiliriz; çünkü biliyoruz ki hiçbir request bir önceki request'in bellekteki artığına ihtiyaç duymaz."  

3. "Shared Nothing" ve Veritabanı Bağlantıları  
   Soru: "Her request'te her şey sıfırlanıyorsa, saniyede 10.000 istekte 10.000 kez DB bağlantısı kurmak sunucuyu patlatmaz mı?"  
   Cevap: Normal şartlarda evet, bu bir maliyettir. Ancak bunu iki şekilde çözeriz:  
   1. Persistent Connections (pconnect): PHP sürecinin DB bağlantısını iş bittikten sonra da açık tutmasını sağlarız.  
   2. Proxy Katmanı: PHP ile DB arasına ProxySQL (MySQL için) veya PgBouncer (PostgreSQL için) gibi araçlar koyarak bağlantı havuzunu (connection pool) uygulama katmanından ayırırız.  

4. PHP'nin "Single-Threaded" Olması ve I/O Block Durumu  
   Soru: "PHP single-threaded bir dildir. Uzun süren bir API isteği veya dosya okuma işlemi geldiğinde tüm sunucu kilitlenir mi?"  
   Cevap: Hayır, kilitlenmez. Çünkü PHP-FPM multi-process çalışır. Bir worker process bir isteği beklerken (blocking I/O), diğer workerlar diğer isteklere cevap vermeye devam eder.  
   Fark: "Go'daki goroutine'ler kadar hafif olmasa da (çünkü her process bir RAM maliyetidir), PHP-FPM binlerce süreci yönetebilecek şekilde optimize edilmiştir."  

5. OpCache ve JIT (Just-In-Time)  
   Soru: "PHP yorumlanan bir dil olduğu için derlenen dillere (Go/Java) göre çok yavaş değil mi?"  
   Cevap: Eskiden öyleydi. Ancak modern PHP'de OpCache sayesinde kodlar bir kez yorumlanıp RAM'de "OpCode" olarak saklanır. PHP 8 ile gelen JIT ise, çok sık çalışan kod parçalarını çalışma anında makine koduna (binary) çevirir.  
   Mühendis Yaklaşımı: "I/O bound (veritabanı odaklı) işlemlerde PHP ile Go/Java arasındaki fark hissedilmeyecek kadar azdır. Sadece CPU bound (ağır matematiksel hesaplama) işlerde fark açılır."

## Stateless Yapı ve Session Yönetimi
Stateless sağlıyorsa bu kötü bir şey değil mi? Örneğin bir kullanıcı login oldu, ben onun bilgilerini bir şeyin tutmam gerekir; onu nasıl yapacağım? Sadece local cache veya local storage yerine o işlem sırasında DB'ye veya Redis'e mi kaydetmeliyim? Bu da bir maliyet değil midir?  

Harika bir noktaya parmak bastın. Bir Java/Go geliştiricisi için "her şeyi unutma" fikri başlangıçta bir "verimsizlik" gibi görünür. Ancak modern web mimarisinde Stateless (Durumsuzluk) aslında bir hata değil, bir özelliktir.  

1. Stateless Kötü Mü? (Neden Bir Standart Haline Geldi?)  
   Eskiden (Java'nın ilk zamanları gibi) kullanıcı verileri sunucunun kendi RAM'inde (Session) tutulurdu. Buna Stateful denir.  
   * Sorun: Eğer senin 3 tane backend sunucun varsa ve kullanıcı 1. sunucuda login olduysa, bir sonraki isteği 2. sunucuya giderse sistem onu tanımazdı. Bunu çözmek için "Sticky Sessions" (kullanıcıyı hep aynı sunucuya gönder) gibi karmaşık ve ölçeklemeyi zorlaştıran yöntemler gerekirdi.  

   Stateless PHP'de çözüm: Kullanıcı login olduğunda, PHP bu durumu kendi RAM'inde değil, tüm sunucuların erişebildiği ortak bir "merkezi hafızada" tutar.  
   * Session: PHP'nin yerleşik $_SESSION mekanizması vardır. Sen bir veri eklediğinde PHP bunu otomatik olarak bir dosyaya veya (tercihen) Redis'e yazar.  
   * Token (JWT): Veya hiçbir yerde tutmazsın; kullanıcıya bir JWT (JSON Web Token) verirsin, kullanıcı her istekte bu "kimlik kartını" gönderir, PHP de içindeki imzayı kontrol ederek kim olduğunu anlar.  

2. Redis/DB Maliyet Değil Mi?  
   Evet, teknik olarak RAM'e erişmekten (nanosaniye) Redis'e gitmek (milisaniye) daha maliyetlidir. Ancak:  
   1. Ağ Hızı: Modern veri merkezlerinde (Azure, AWS gibi) backend sunucusu ile Redis arasındaki gecikme (latency) 1ms'nin altındadır. Kullanıcı bu farkı asla hissetmez.  
   2. Güvenilirlik: Backend server'ın (Docker container) çökse veya Azure onu yeniden başlatsa bile kullanıcıların "oturumları kapatılmaz". Çünkü veriler dışarıdaki kalıcı bir Redis'tedir.  
   3. Ölçekleme Konforu: Uygulamanı 1000 node'a çıkardığında "Hangi kullanıcı hangi sunucudaydı?" diye düşünmezsin. Hepsi aynı Redis'e bakar.  

3. PHP'de "Local Cache" Hiç mi Yok?  
   Aslında var ama ömrü çok kısa!  
   * Request-Level Cache: Bir istek geldiği anda, o isteğin sonuna kadar yaşayan değişkenler (Static variables, Global variables) kullanabilirsin. Örneğin, aynı istek içinde veritabanından 5 kere User bilgisini çekmek yerine, ilk çekişinde bir değişkene atarsın. O istek bitene kadar o değişkenden okursun. İstek bittiğinde o da ölür.  

4.  "Session Storage"  
    "PHP'de session verilerini varsayılan olarak nerede tutar? Büyük ölçekli sistemlerde bu neden değiştirilmelidir?"  
   * Cevap: PHP varsayılan olarak session verilerini sunucudaki yerel dosya sistemine (/tmp) kaydeder.  
   * Neden Değişmeli: Birden fazla sunucun (Azure'daki çoklu instance'lar) varsa, her sunucu sadece kendi üzerindeki dosyayı görür. Bu yüzden büyük ölçekli sistemlerde session handler olarak Redis veya Memcached kullanılır ki tüm sunucular kullanıcıyı tanıyabilsin.