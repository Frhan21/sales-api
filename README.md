
# **API Pembayaran Komisi Marketing dengan Midtrans**

Proyek ini adalah sebuah sistem pembayaran komisi marketing menggunakan Laravel dan Midtrans. Marketing yang mencapai omzet tertentu akan menerima komisi, dan komisi tersebut dapat dibayarkan melalui Midtrans.

---

## **Fitur**
1. **Menghitung Komisi Marketing**:
   - Komisi dihitung berdasarkan omzet yang dicapai oleh marketing.
   - Persentase komisi:
     - 0% untuk omzet di bawah 100.000.000
     - 2.5% untuk omzet 100.000.000 - 200.000.000
     - 5% untuk omzet 200.000.000 - 500.000.000
     - 10% untuk omzet di atas 500.000.000
2. **Pembayaran via Midtrans**
   - Marketing yang memenuhi syarat omzet dapat menerima pembayaran komisi melalui Midtrans.
   - Menggunakan Snap.js untuk integrasi frontend.


## **Instalasi**

### **1. Clone Repository**
Clone repository ini ke lokal Anda:

```bash
git clone https://github.com/username/repository-name.git
cd repository-name
```

### **2. Install Dependencies** 
Install semua dependencies menggunakan Composer: 

```bash
composer install
```
### **3. Buat File .env**
Salin file .env.example dan sesuaikan konfigurasi database 

```bash 
cp .env.example .env
```

### **4. Generate key**
Generate application key: 
```bash 
php artisan key: generate
```

### **5. Jalankan Migrasi**
Jalankan migrasi untuk table di database: 
```bash 
php artisan migrate
```

### **6. Jalankan Seeder**
```bash
php artisasn db:seed
```

### **7. Jalankan Server**
Jalankan server Laravel 
```bash
php artisan serve
```

## **Penggunaan API** 
### **1. Menghitung Komisi dari Omzet**
Endpoint untuk menghitung komisi marketing berdasarkan bulan dan tahun
* URL: `/api/comission`
* Method: `GET`
* Parameter: 
   * `month` (bulan): Bulan (Jan-Des)
   * `year` (tahun): Tahun (ex: 2023)

**Contoh Request:**
```bash
GET /api/comission?month=05&year=2023
```
**Contoh Response**
```json
[
    {
        "marketing": "Alfandy",
        "bulan": "5",
        "omzet": 138000000,
        "komisi_persen": 2.5,
        "komisi_nominal": 3450000
    },
    {
        "marketing": "Mery",
        "bulan": "5",
        "omzet": 80000000,
        "komisi_persen": 0,
        "komisi_nominal": 0
    }
]
```

### **2. Mengakses Data Penjualan dan Marketing**
Endpoint untuk mengakses data penjualan dan marketing
**a. Penjualan**
   * URL: `/api/penjualan`
   * Method: `GET`

**Contoh Endpoint**
```bash
GET /api/penjualan
```
**Contoh Response API**
```json
[
    {
        "id": 6,
        "transaction_number": "TRX001",
        "marketing_id": 1,
        "date": "2023-05-22",
        "cargo_fee": "25000.00",
        "total_balance": "3000000.00",
        "grand_total": "3025000.00",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 7,
        "transaction_number": "TRX002",
        "marketing_id": 3,
        "date": "2023-05-22",
        "cargo_fee": "25000.00",
        "total_balance": "320000.00",
        "grand_total": "345000.00",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 8,
        "transaction_number": "TRX003",
        "marketing_id": 1,
        "date": "2023-05-22",
        "cargo_fee": "0.00",
        "total_balance": "65000000.00",
        "grand_total": "65000000.00",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 9,
        "transaction_number": "TRX004",
        "marketing_id": 1,
        "date": "2023-05-23",
        "cargo_fee": "10000.00",
        "total_balance": "70000000.00",
        "grand_total": "70010000.00",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 10,
        "transaction_number": "TRX005",
        "marketing_id": 2,
        "date": "2023-05-23",
        "cargo_fee": "10000.00",
        "total_balance": "80000000.00",
        "grand_total": "80010000.00",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 11,
        "transaction_number": "TRX006",
        "marketing_id": 2,
        "date": "2023-05-23",
        "cargo_fee": "10000.00",
        "total_balance": "80000000.00",
        "grand_total": "80010000.00",
        "created_at": null,
        "updated_at": null
    },
]

```
**b. Marketing**
   * URL: `/api/marketing`
   * Method: `GET`, `POST`


**Contoh Endpoint**
```bash
GET /api/marketing
```
**Contoh Response API**
```json
[
    {
        "id": 1,
        "name": "Alfyandy",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 2,
        "name": "Mery",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 3,
        "name": "Danang",
        "created_at": null,
        "updated_at": null
    }
]

```



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
