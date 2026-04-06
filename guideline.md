# API Boilerplate Guideline (PHP 8.3 + Laravel 12 + OpenAPI)

## 1. Amaç

Bu boilerplate (BP), üniversite bünyesinde geliştirilecek API projeleri için standart bir başlangıç noktası sağlar.

Developer’lar BP repository’sini kullanarak yeni projelerini başlatır ve aşağıdaki kurallara uygun şekilde geliştirme yapar.

Amaç:
- Tüm API’lerde tutarlı yapı
- Hızlı proje başlangıcı
- Okunabilir ve sürdürülebilir kod
- OpenAPI ile standart dokümantasyon

---

## 2. Hedef Kullanıcı

Bu guideline:

API geliştiren tüm PHP / Laravel backend developer’lar için hazırlanmıştır.

---

## 3. Teknoloji ve Standartlar

- PHP: 8.3+
- Framework: Laravel 12
- Kod stili: Laravel Pint (zorunlu)
- Dil:
  - Tüm değişkenler, mesajlar ve error’lar İngilizce olmalıdır

---

## 4. Mimari Yaklaşım

BP, yalın Laravel yaklaşımını benimser.

Controller → Request → Model

Kurallar:

- Gereksiz abstraction eklenmez
- Service / Repository katmanları default olarak kullanılmaz
- Logic büyüdüğünde ayrıştırılabilir (opsiyonel)

---

## 5. Routing Standardı

- Tüm endpoint’ler version prefix ile tanımlanır:

/v1/...

- Public ve protected endpoint’ler ayrı tanımlanır

- Tanımsız route’lar için standart response:

Route::fallback(function () {
    return ApiResponse::error('Route not found', 'ROUTE_NOT_FOUND', 404);
});

---

## 6. Authentication / Request Trust

Authentication API Gateway üzerinden yapılır.

Backend tarafında:

- Header zorunludur:
X-Authenticated-UserId

- Middleware:
auth.user (CheckAuthenticatedUser)

Kurallar:

- Protected route’lar middleware altında tanımlanmalıdır
- Header yoksa request reject edilir
- Header değeri controller içinde gerektiğinde okunur

---

## 7. Response Standardı

Tüm response’lar ApiResponse üzerinden dönmelidir.

### Success

{
  "success": true,
  "data": {},
  "error": null
}

### Error

{
  "success": false,
  "data": null,
  "error": {
    "code": "ERROR_CODE",
    "message": "Error message",
    "details": {}
  }
}

Kurallar:

- Controller içinde raw response()->json() kullanılmaz
- Her zaman success() veya error() kullanılır

---

## 8. Validation Standardı

Validation controller içinde yapılır:

$validator = Validator::make($request->all(), [...]);

Validation fail durumunda:

return $this->error(
    'Validation failed',
    'VALIDATION_ERROR',
    400,
    $validator->errors()->toArray()
);

Kurallar:

- Error code: VALIDATION_ERROR
- Details: field bazlı error listesi
- FormRequest kullanılmaz (şimdilik)

---

## 9. Naming Conventions

- Tüm isimler İngilizce
- Değişkenler: camelCase
- Methodlar: camelCase

### Controller Method

getStudent
setStudent (PUT)
createStudent (POST)
getInformation

Kurallar:

- PascalCase kullanılmaz
- Laravel standardına uyulur

---

## 10. Controller Responsibility

Controller:

- Request alır
- Validation yapar
- Basit logic içerir
- Response döner

Kural:

Logic büyürse ayrıştırılmalıdır (Service vs), ancak default olarak controller içinde tutulabilir.

---

## 11. OpenAPI Standardı

Her endpoint için OpenAPI dokümantasyonu sağlanmalıdır.

Zorunlu:

- Endpoint tanımı
- Request schema
- Response schema
- Error response

Output:
openapi.json

Notlar:

- Auth JWT değildir
- Header-based auth dokümante edilmelidir

---

## 12. Pagination (Opsiyonel)

Şu an zorunlu değildir.

Kullanılırsa:
- Standart yapı uygulanmalıdır (ileride tanımlanacak)

---

## 13. Anti-Patterns (Kaçınılacaklar)

- Controller içinde kontrolsüz büyüyen logic
- Farklı response formatları
- Hardcoded JSON response
- İngilizce dışı mesajlar
- Version’sız endpoint’ler

---

## 14. Geliştirme Akışı (Önerilen)

1. Route ekle
2. Controller method oluştur
3. Validation yaz
4. Logic yaz
5. ApiResponse ile dön
6. OpenAPI dokümantasyonunu ekle
