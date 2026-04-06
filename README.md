# Boilerplate API Projesi

Bu proje, yeni API geliştirmeleri için temel teşkil eden, sadeleştirilmiş ve standartlara uygun bir Laravel boilerplate projesidir.

## Özellikler
- **Laravel 12** tabanlı modern yapı.
- **OpenAPI 3.0** standartlarına uygun dokümantasyon (`public/docs/openapi.json`).
- Standart JSON dönüş yapısı (`ApiResponse` support sınıfı ile).
- Merkezi kimlik doğrulama middleware (`CheckAuthenticatedUser`).
- Health check ve örnek metotlar hazır.

## API Uçları

### Genel Uçlar (Auth Gerektirmez)
- `GET /v1/health`: API sağlık durumu ve versiyon bilgisi.
- `GET /v1/information`: Genel test bilgisi döner.

### Yetkili Uçlar (X-Authenticated-UserId Header'ı Gerektirir)
- `GET /v1/student`: Kimliği doğrulanmış öğrenci bilgilerini (Alp Ermiş) döner.
- `PUT /v1/student`: Öğrenci bilgilerini güncelleme simülasyonu.
- `POST /v1/student`: Yeni öğrenci oluşturma simülasyonu.

## Test Etme (Bruno Kullanımı)

[Bruno](https://www.usebruno.com/), API testleri için hafif ve Git dostu bir araçtır. Bu projeyi test etmek için şu adımları izleyebilirsiniz:

1. Bruno uygulamasını açın.
2. Yeni bir koleksiyon oluşturun veya mevcut bir koleksiyona istekleri ekleyin.
3. İsteklerinizi şu şekilde yapılandırın:

### 1. Health Check
- **Method:** GET
- **URL:** `{{base_url}}/v1/health`

### 2. Get Student (Auth Gerekli)
- **Method:** GET
- **URL:** `{{base_url}}/v1/student`
- **Headers:** 
  - `X-Authenticated-UserId`: `12345` (Test için herhangi bir ID)

### 3. Set Student Information (Auth Gerekli)
- **Method:** PUT
- **URL:** `{{base_url}}/v1/student`
- **Headers:** 
  - `X-Authenticated-UserId`: `12345`
  - `Content-Type`: `application/json`
- **Body (JSON):**
  ```json
  {
    "name": "Alp",
    "lastname": "Ermiş"
  }
  ```

### 4. Create Student (Auth Gerekli)
- **Method:** POST
- **URL:** `{{base_url}}/v1/student`
- **Headers:** 
  - `X-Authenticated-UserId`: `12345`
  - `Content-Type`: `application/json`
- **Body (JSON):**
  ```json
  {
    "name": "Jane",
    "lastname": "Smith"
  }
  ```

## Geliştirme Notları
- Yeni metotlar eklerken `StudentController`'ı referans alabilirsiniz.
- Dönüşlerinizi her zaman `Controller` içindeki `$this->success()` veya `$this->error()` metotları ile yapın.
- API gateway entegrasyonu için `public/docs/openapi.json` dosyasını güncel tutmayı unutmayın.
